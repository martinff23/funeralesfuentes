<?php

namespace Controllers;

use Classes\Email;
use Classes\Pagination;
use Model\Product;
use MVC\Router;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\Encoders\WebpEncoder;
use Model\Branch;
use Model\Category;
use Model\Employee;
use Model\EmployeeRole;
use Model\FinancialsEmployee;
use Model\Identification;
use Model\Password;
use Model\PermissionsEmployee;
use Model\RatingsEmployee;
use Model\Relation;
use Model\SpecialProgram;
use Model\User;

class UsersController {

    public static function empDashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);

            $currentPage = $_GET['page'];
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

            if(!$currentPage || $currentPage < 1){
                header('Location: /dashboard/users/employees?page=1');
            }

            $totalRecords = User::countRecords('status', 'ACTIVE');
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/users/employees?page=1');
            }

            $users = User::paginateWhereStatus($recordsPerPage, $pagination->calculateOffset(), ['isAdmin' => 0, 'isEmployee' => 1], 'ACTIVE');
            
            $router->render('admin/users/employees/index',[
                'title' => 'Colaboradores registrados',
                'users' => $users,
                'pagination' => $pagination->pagination(),
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function empCreate(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            $alerts = [];
            $us = new User;
            $employee = new Employee;
            $financials = new FinancialsEmployee;
            $permissions = new PermissionsEmployee;
            $ratings = new RatingsEmployee;
            $programs = SpecialProgram::allWhere('status', 'ACTIVE');
            $roles = EmployeeRole::allWhere('status', 'ACTIVE');
            $branches = Branch::allWhere('status', 'ACTIVE');
            $relations = Relation::allWhere('status', 'ACTIVE');
            $identifications = Identification::allWhere('status', 'ACTIVE');

            if('POST' === $_SERVER['REQUEST_METHOD']){

                $role = getDatabaseRoles("EMPLOYEE");
                $imageFolder = 'public/build/img/users/';
                $savePicture = false;
                $imagesToSave = [];
                $imageName = md5(uniqid(rand(),true));

                // Read image
                if (!empty($_FILES['user_image']['tmp_name'])) {
                    $manager = new ImageManager(new Driver());
                    $tmpNameFiles = $_FILES['user_image']['tmp_name'];
                    $imagesToSave = [];
                
                    $tmpNameFile = trim($tmpNameFiles);
            
                    $image = $manager->read($tmpNameFile)->resize(800, 600);
                    $pngImage = $image->encode(new PngEncoder(80));
                    $webpImage = $image->encode(new WebpEncoder(80));
            
                    // Guardar en array temporal
                    $imagesToSave[] = [
                        'name' => $imageName,
                        'png' => $pngImage,
                        'webp' => $webpImage
                    ];
                
                    $_POST['image'] = $imageName;
                    $savePicture = true;
                } else {
                    $_POST['image'] = $us->image;
                }

                $_POST['status'] = "ACTIVE";
                $_POST['registerOrigin'] = "1";
                $_POST['isAdmin'] = $role['isAdmin'];
                $_POST['isEmployee'] = $role['isEmployee'];
                $_POST['base_salary'] = 0.00;
                $_POST['bonus'] = 0.00;
                $_POST['commission'] = 0.00;
                $_POST['savings'] = 0.00;
                $_POST['loans'] = 0.00;
                $_POST['emergency_contact_relation'] = "NONE" === strtoupper($_POST['emergency_contact_relation']) ? 0 : $_POST['emergency_contact_relation'];
                $_POST['vacations_taken'] = 0;
                $_POST['vacations_available'] = 20;
                $_POST['sickdays_taken'] = 0;
                $_POST['sickdays_available'] = 10;
                $_POST['parentleave_taken'] = 0;
                $_POST['parentleave_available'] = 30;
                $_POST['specialpermissions_count'] = 0;

                $_POST['year'] = getDateYear($_POST['start_date']);
                
                $_POST['internal_rating'] = 5.00;
                $_POST['external_rating'] = 5.00;
                $_POST['rating'] = 5.00;

                $_POST['period'] = getPeriod($_POST['start_date'], 2);

                $_POST['employee_code'] = generateEmployeeCode(lookForRoleId($roles, $_POST['positionId']));

                $us->sincronize($_POST);
                $alertsUser = $us->validateAccount();
                
                $employee->sincronize($_POST);
                $alertsEmployee = $employee->validateEmployee();

                $alerts = [];
                $alerts['error'] = $alertsUser['error'];
                $alerts['error'] = $alertsEmployee['error'];

                if(!$alerts['error']) {
                    
                    if($savePicture){
                        // Create folder if does not exist
                        if(!is_dir(trim($imageFolder))){
                            mkdir(trim($imageFolder),0777,true);
                        }
    
                        // Make the foldar ALWAYS writable
                        chmod($imageFolder, 0777);

                        // Delete previous images before saving the new ones
                        $oldPngPath  = $imageFolder . $us->currentImage . '.png';
                        $oldWebpPath = $imageFolder . $us->currentImage . '.webp';

                        if (file_exists($oldPngPath)) {
                            unlink($oldPngPath);
                        }
                        if (file_exists($oldWebpPath)) {
                            unlink($oldWebpPath);
                        }
    
                        // Put image on server
                        foreach($imagesToSave as $imageToSave){
                            $currentPngImage = $imageToSave['png'];
                            $currentWebpImage = $imageToSave['webp'];
                            $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                            $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                        }
                    }
                    
                    $userExists = User::where('email', $us->email);

                    if($userExists) {
                        User::setAlert('error', 'El Usuario ya esta registrado');
                        $alerts = User::getAlerts();
                    } else {
                        // Hash the password
                        $us->hashPassword();

                        // Delete password2
                        unset($us->password2);

                        // Generate the token
                        $us->createToken();

                        // Create new user
                        $result =  $us->saveElement();

                        if($result) {
                            User::setAlert('success', 'El usuario se registró con éxito');
                            $alertsCheckUserSave = User::getAlerts();

                            $_POST['userId'] = $result['id'];
                            
                            // Create employee
                            $employee->sincronize($_POST);
                            $financials->sincronize($_POST);
                            $permissions->sincronize($_POST);
                            $ratings->sincronize($_POST);
                            $alertsEmployeeCheck = $employee->validateEmployee();

                            if(empty($alertsEmployeeCheck['error'])){
                                $employeeExists = Employee::where('employee_code', $employee->employee_code);
                                if($employeeExists){
                                    Employee::setAlert('error', 'El colaborador ya esta registrado');
                                    $alertsCheckEmployeeSave = Employee::getAlerts();
                                } else{
                                    $resultEmployee =  $employee->saveElement();

                                    if($resultEmployee){
                                        Employee::setAlert('success', 'El colaborador se registró con éxito');
                                        $alertsCheckEmployeeSave = Employee::getAlerts();
                                    } else{
                                        Employee::setAlert('error', 'El colaborador no se registró');
                                        $alertsCheckEmployeeSave = Employee::getAlerts();
                                    }
                                }

                                $financialsExists = FinancialsEmployee::where('employee_code', $financials->employee_code);
                                if($financialsExists){
                                    FinancialsEmployee::setAlert('error', 'La información financiera del colaborador ya existe');
                                    $alertsCheckFinancialsSave = FinancialsEmployee::getAlerts();
                                } else{
                                    $resultFinancials = $financials->saveElement();
                                    if($resultFinancials){
                                        FinancialsEmployee::setAlert('success', 'La información financiera del colaborador se registró con éxito');
                                        $alertsCheckFinancialsSave = FinancialsEmployee::getAlerts();
                                    } else{
                                        FinancialsEmployee::setAlert('error', 'La información financiera del colaborador no se registró');
                                        $alertsCheckFinancialsSave = FinancialsEmployee::getAlerts();
                                    }
                                }

                                $permissionsExists = PermissionsEmployee::where('employee_code', $permissions->employee_code);
                                if($permissionsExists){
                                    PermissionsEmployee::setAlert('error', 'La información de permisos del colaborador ya existe');
                                    $alertsCheckPermissionsSave = PermissionsEmployee::getAlerts();
                                } else{
                                    $resultPermissions = $permissions->saveElement();
                                    if($resultPermissions){
                                        PermissionsEmployee::setAlert('success', 'La información de permisos del colaborador se registró con éxito');
                                        $alertsCheckPermissionsSave = PermissionsEmployee::getAlerts();
                                    } else{
                                        PermissionsEmployee::setAlert('error', 'La información de permisos del colaborador no se registró');
                                        $alertsCheckPermissionsSave = PermissionsEmployee::getAlerts();
                                    }
                                }

                                $ratingsExists = RatingsEmployee::where('employee_code', $ratings->employee_code);
                                if($ratingsExists){
                                    RatingsEmployee::setAlert('error', 'La información de permisos del colaborador ya existe');
                                    $alertsCheckRatingsSave = RatingsEmployee::getAlerts();
                                } else{
                                    $resultRatings = $ratings->saveElement();
                                    if($resultRatings){
                                        RatingsEmployee::setAlert('success', 'La información de permisos del colaborador se registró con éxito');
                                        $alertsCheckRatingsSave = RatingsEmployee::getAlerts();
                                    } else{
                                        RatingsEmployee::setAlert('error', 'La información de permisos del colaborador no se registró');
                                        $alertsCheckRatingsSave = RatingsEmployee::getAlerts();
                                    }
                                }
                            }   
                        } else{
                            User::setAlert('error', 'El usuario no se registró');
                            $alertsCheckUserSave = User::getAlerts();
                        }
                    }

                    $alertsChecks = [];
                    $alertsChecks['error'] = $alertsCheckUserSave['error'];
                    $alertsChecks['error'] = $alertsCheckEmployeeSave['error'];
                    $alertsChecks['error'] = $alertsCheckFinancialsSave['error'];
                    $alertsChecks['error'] = $alertsCheckPermissionsSave['error'];
                    $alertsChecks['error'] = $alertsCheckRatingsSave['error'];
                    $alertsChecks['success'] = $alertsCheckUserSave['success'];
                    $alertsChecks['success'] = $alertsCheckEmployeeSave['success'];
                    $alertsChecks['success'] = $alertsCheckFinancialsSave['success'];
                    $alertsChecks['success'] = $alertsCheckPermissionsSave['success'];
                    $alertsChecks['success'] = $alertsCheckRatingsSave['success'];

                    if(empty($alertsChecks['error'])){
                        // Send email
                        $email = new Email($us->email, $us->name, $us->token);
                        $email->sendConfirmation();

                        header('Location: /message');
                    }
                }
            }

            $router->render('admin/users/employees/create',[
                'title' => 'Registrar colaborador',
                'alerts' => $alerts,
                'us' => $us,
                'employee' => $employee,
                'user' => $user,
                'programs' => $programs,
                'roles' => $roles,
                'branches' => $branches,
                'relations' => $relations,
                'identifications' => $identifications,
                'template' => 'CR'
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function empEdit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);
            $alerts = [];
            $id = $_GET['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            $programs = SpecialProgram::allWhere('status', 'ACTIVE');
            $roles = EmployeeRole::allWhere('status', 'ACTIVE');
            $branches = Branch::allWhere('status', 'ACTIVE');
            $relations = Relation::allWhere('status', 'ACTIVE');
            $identifications = Identification::allWhere('status', 'ACTIVE');
            
            if(!$id){
                header('Location: /dashboard/users/employees');
            }

            $us = User::find($id);
            $employee = Employee::where('userId', $id);

            if(!$us || !$us instanceof User || !$employee || !$employee instanceof Employee){
                header('Location: /dashboard/users/employees');
            } else{
                $role = getUserRoleAlt($us);
                $us->currentImage = $us->image;
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $role = getDatabaseRoles("EMPLOYEE");
                    $imageFolder = 'public/build/img/users/';
                    $savePicture = false;
                    $imagesToSave = [];
                    $imageName = md5(uniqid(rand(),true));

                    // Read image
                    if (!empty($_FILES['user_image']['tmp_name'])) {
                        $manager = new ImageManager(new Driver());
                        $tmpNameFiles = $_FILES['user_image']['tmp_name'];
                        $imagesToSave = [];
                    
                        $tmpNameFile = trim($tmpNameFiles);
                
                        $image = $manager->read($tmpNameFile)->resize(800, 600);
                        $pngImage = $image->encode(new PngEncoder(80));
                        $webpImage = $image->encode(new WebpEncoder(80));
                
                        // Guardar en array temporal
                        $imagesToSave[] = [
                            'name' => $imageName,
                            'png' => $pngImage,
                            'webp' => $webpImage
                        ];
                    
                        $_POST['image'] = $imageName;
                        $savePicture = true;
                    } else {
                        $_POST['image'] = $us->image;
                    }
                    
                    $_POST['status'] = $us->status;
                    $_POST['registerOrigin'] = $us->registerOrigin;
                    $_POST['isAdmin'] = $us->isAdmin;
                    $_POST['isEmployee'] = $us->isEmployee;
                    $_POST['emergency_contact_relation'] = "NONE" === strtoupper($_POST['emergency_contact_relation']) ? 0 : $_POST['emergency_contact_relation'];
                    
                    $us->sincronize($_POST);
                    $alertsUser = $us->validateAccount();
                    
                    $employee->sincronize($_POST);
                    $alertsEmployee = $employee->validateEmployee();

                    $alerts = [];
                    $alerts['error'] = $alertsUser['error'];
                    $alerts['error'] = $alertsEmployee['error'];

                    if(!$alerts['error']) {
                        if($savePicture){
                            // Create folder if does not exist
                            if(!is_dir(trim($imageFolder))){
                                mkdir(trim($imageFolder),0777,true);
                            }
        
                            // Make the foldar ALWAYS writable
                            chmod($imageFolder, 0777);

                            // Delete previous images before saving the new ones
                            $oldPngPath  = $imageFolder . $us->currentImage . '.png';
                            $oldWebpPath = $imageFolder . $us->currentImage . '.webp';

                            if (file_exists($oldPngPath)) {
                                unlink($oldPngPath);
                            }
                            if (file_exists($oldWebpPath)) {
                                unlink($oldWebpPath);
                            }
        
                            // Put image on server
                            foreach($imagesToSave as $imageToSave){
                                $currentPngImage = $imageToSave['png'];
                                $currentWebpImage = $imageToSave['webp'];
                                $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                                $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                            }
                        }
    
                        $result =  $us->saveElement();
                        if($result) {
                            User::setAlert('success', 'El usuario se registró con éxito');
                            $alertsCheckUserSave = User::getAlerts();
                        } else{
                            User::setAlert('error', 'El usuario no se registró');
                            $alertsCheckUserSave = User::getAlerts();
                        }

                        $resultEmployee =  $employee->saveElement();
                        if($resultEmployee) {
                            Employee::setAlert('success', 'El empleado se registró con éxito');
                            $alertsCheckEmployeeSave = Employee::getAlerts();
                        } else{
                            Employee::setAlert('error', 'El empleado no se registró');
                            $alertsCheckEmployeeSave = Employee::getAlerts();
                        }

                        $alertsChecks = [];
                        $alertsChecks['error'] = $alertsCheckUserSave['error'];
                        $alertsChecks['error'] = $alertsCheckEmployeeSave['error'];
                        $alertsChecks['success'] = $alertsCheckUserSave['success'];
                        $alertsChecks['success'] = $alertsCheckEmployeeSave['success'];
    
                        if(empty($alertsChecks['error'])){
                            header('Location: /dashboard/users/employees');
                        }
                    }
                }

                $router->render('admin/users/employees/edit',[
                    'title' => 'Editar colaborador',
                    'alerts' => $alerts,
                    'us' => $us ?? null,
                    'employee' => $employee,
                    'user' => $user,
                    'role' => $role,
                    'programs' => $programs,
                    'roles' => $roles,
                    'branches' => $branches,
                    'relations' => $relations,
                    'identifications' => $identifications,
                    'template' => 'ED'
                ]);
            }   
        } else{
            header('Location: /404');
        }
    }

    public static function empDelete(){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST' === $_SERVER['REQUEST_METHOD']){
            $id = $_POST['id'];
            $user = User::find($id);
            if(!isset($user) || !$user instanceof User){
                header('Location: /dashboard/users/employees');
            }
            
            $result = $user->deleteNElement();
            if($result){
                header('Location: /dashboard/users/employees');
            }
        }
    }

    public static function othDashboard(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);

            $currentPage = $_GET['page'];
            $currentPage = filter_var($currentPage, FILTER_VALIDATE_INT);

            if(!$currentPage || $currentPage < 1){
                header('Location: /dashboard/users/others?page=1');
            }

            $totalRecords = User::countRecords();
            $recordsPerPage = $_ENV['ITEMS_PER_PAGE']; // Ajustar a 10
            
            $pagination = new Pagination($currentPage,$recordsPerPage,$totalRecords);

            if('0' !== $totalRecords && $pagination->totalPages() < $currentPage){
                header('Location: /dashboard/users/others?page=1');
            }

            $users = User::paginateWhereStatus($recordsPerPage, $pagination->calculateOffset(), ['isAdmin' => 0, 'isEmployee' => 0], 'ACTIVE');

            $router->render('admin/users/others/index',[
                'title' => 'Usuarios registrados',
                'users' => $users,
                'pagination' => $pagination->pagination(),
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function othCreate(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user =  User::find($_SESSION['id']);
            $alerts = [];
            $us = new User;

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $role = getDatabaseRoles($_POST['role']);
                $imageFolder='../public/build/img/users/';
                $savePicture = false;
                $imagesToSave = [];
                $imageName = md5(uniqid(rand(),true));

                // Read image
                if (!empty($_FILES['user_image']['tmp_name'])) {
                    $manager = new ImageManager(new Driver());
                    $tmpNameFiles = $_FILES['user_image']['tmp_name'];
                    $imagesToSave = [];
                
                    $tmpNameFile = trim($tmpNameFiles);
            
                    $image = $manager->read($tmpNameFile)->resize(800, 600);
                    $pngImage = $image->encode(new PngEncoder(80));
                    $webpImage = $image->encode(new WebpEncoder(80));
            
                    // Guardar en array temporal
                    $imagesToSave[] = [
                        'name' => $imageName,
                        'png' => $pngImage,
                        'webp' => $webpImage
                    ];
                
                    $_POST['image'] = $imageName;
                    $savePicture = true;
                } else {
                    $_POST['image'] = $us->image;
                }

                $_POST['status'] = "ACTIVE";
                $_POST['registerOrigin'] = "1";
                $_POST['isAdmin'] = $role['isAdmin'];
                $_POST['isEmployee'] = $role['isEmployee'];
                $us->sincronize($_POST);
                
                $alerts = $us->validateAccount();

                if(empty($alerts)) {
                    if($savePicture){
                        // Create folder if does not exist
                        if(!is_dir(trim($imageFolder))){
                            mkdir(trim($imageFolder),0777,true);
                        }
    
                        // Make the foldar ALWAYS writable
                        chmod($imageFolder, 0777);

                        // Delete previous images before saving the new ones
                        $oldPngPath  = $imageFolder . $us->currentImage . '.png';
                        $oldWebpPath = $imageFolder . $us->currentImage . '.webp';

                        if (file_exists($oldPngPath)) {
                            unlink($oldPngPath);
                        }
                        if (file_exists($oldWebpPath)) {
                            unlink($oldWebpPath);
                        }
    
                        // Put image on server
                        foreach($imagesToSave as $imageToSave){
                            $currentPngImage = $imageToSave['png'];
                            $currentWebpImage = $imageToSave['webp'];
                            $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                            $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                        }
                    }

                    $userExists = User::where('email', $us->email);

                    if($userExists) {
                        User::setAlert('error', 'El Usuario ya esta registrado');
                        $alerts = User::getAlerts();
                    } else {
                        // Hashear el password
                        $us->hashPassword();

                        // Eliminar password2
                        unset($us->password2);

                        // Generar el Token
                        $us->createToken();

                        // Crear un nuevo usuario
                        $resultado =  $us->saveElement();

                        // Enviar email
                        $email = new Email($us->email, $us->name, $us->token);
                        $email->sendConfirmation();
                        

                        if($resultado) {
                            header('Location: /message');
                        }
                    }
                }
            }

            $router->render('admin/users/others/create',[
                'title' => 'Registrar usuario',
                'alerts' => $alerts,
                'user' => $user,
                'us' => $us,
                'template' => 'CR'
            ]);
        } else{
            header('Location: /404');
        }
    }

    public static function othEdit(Router $router){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);
            $alerts = [];
            $id = $_GET['id'];
            $id = filter_var($id,FILTER_VALIDATE_INT);
            
            if(!$id){
                header('Location: /dashboard/users/others');
            }

            $us = User::find($id);

            if(!$us || !$us instanceof User){
                header('Location: /dashboard/users/others');
            } else{
                $role = getUserRoleAlt($us);
                $us->currentImage = $us->image;
                if('POST' === $_SERVER['REQUEST_METHOD']){
                    $role = getDatabaseRoles($role);
                    $imageFolder = 'public/build/img/users/';
                    $savePicture = false;
                    $imagesToSave = [];
                    $imageName = md5(uniqid(rand(),true));

                    // Read image
                    if (!empty($_FILES['user_image']['tmp_name'])) {
                        $manager = new ImageManager(new Driver());
                        $tmpNameFiles = $_FILES['user_image']['tmp_name'];
                        $imagesToSave = [];
                    
                        $tmpNameFile = trim($tmpNameFiles);
                
                        $image = $manager->read($tmpNameFile)->resize(800, 600);
                        $pngImage = $image->encode(new PngEncoder(80));
                        $webpImage = $image->encode(new WebpEncoder(80));
                
                        // Guardar en array temporal
                        $imagesToSave[] = [
                            'name' => $imageName,
                            'png' => $pngImage,
                            'webp' => $webpImage
                        ];
                    
                        $_POST['image'] = $imageName;
                        $savePicture = true;
                    } else {
                        $_POST['image'] = $us->image;
                    }
                    
                    $_POST['status'] = $us->status;
                    $_POST['registerOrigin'] = $us->registerOrigin;
                    $_POST['isAdmin'] = $us->isAdmin;
                    $_POST['isEmployee'] = $us->isEmployee;
                    
                    $us->sincronize($_POST);
                    $alertsUser = $us->validateAccount();

                    $alerts = [];
                    $alerts['error'] = $alertsUser['error'];

                    if(!$alerts['error']) {
                        if($savePicture){
                            // Create folder if does not exist
                            if(!is_dir(trim($imageFolder))){
                                mkdir(trim($imageFolder),0777,true);
                            }
        
                            // Make the foldar ALWAYS writable
                            chmod($imageFolder, 0777);

                            // Delete previous images before saving the new ones
                            $oldPngPath  = $imageFolder . $us->currentImage . '.png';
                            $oldWebpPath = $imageFolder . $us->currentImage . '.webp';

                            if (file_exists($oldPngPath)) {
                                unlink($oldPngPath);
                            }
                            if (file_exists($oldWebpPath)) {
                                unlink($oldWebpPath);
                            }
        
                            // Put image on server
                            foreach($imagesToSave as $imageToSave){
                                $currentPngImage = $imageToSave['png'];
                                $currentWebpImage = $imageToSave['webp'];
                                $currentPngImage->save(trim($imageFolder.$imageToSave['name']).'.png');
                                $currentWebpImage->save(trim($imageFolder.$imageToSave['name']).'.webp');
                            }
                        }
    
                        $result =  $us->saveElement();
                        if($result) {
                            User::setAlert('success', 'El usuario se registró con éxito');
                            $alertsCheckUserSave = User::getAlerts();
                        } else{
                            User::setAlert('error', 'El usuario no se registró');
                            $alertsCheckUserSave = User::getAlerts();
                        }

                        $alertsChecks = [];
                        $alertsChecks['error'] = $alertsCheckUserSave['error'];
                        $alertsChecks['success'] = $alertsCheckUserSave['success'];
    
                        if(empty($alertsChecks['error'])){
                            header('Location: /dashboard/users/others');
                        }
                    }
                }

                $router->render('admin/users/others/edit',[
                    'title' => 'Editar colaborador',
                    'alerts' => $alerts,
                    'us' => $us ?? null,
                    'user' => $user,
                    'role' => $role,
                    'template' => 'ED'
                ]);
            }   
        } else{
            header('Location: /404');
        }
    }

    public static function othDelete(){
        session_start();

        if(isAuth() && !isAdmin()){
            header('Location: /login');
        }
        
        if('POST' === $_SERVER['REQUEST_METHOD']){
            $id = $_POST['id'];
            $user = User::find($id);
            if(!isset($user) || !$user instanceof User){
                header('Location: /dashboard/users/others');
            }
            
            $result = $user->deleteNElement();
            if($result){
                header('Location: /dashboard/users/others');
            }
        }
    }

    public static function updatePassword(Router $router){
        session_start();

        if(!isAuth()){
            header('Location: /login');
        }

        if(isset($_SESSION['id'])){
            $user = User::find($_SESSION['id']);

            if('POST' === $_SERVER['REQUEST_METHOD']){
                $password = new Password;
                $password->sincronize($_POST);
                $alerts = $password->validatePassword();
                if(empty($alerts)){
                    unset($password->password2);
                    unset($_POST['password2']);
                    $password->hashPassword();
                    $_POST['password'] = $password->password;
                    $_POST['registerOrigin'] = 0;
                    $user->sincronize($_POST);
                    $result = $user->saveElement();
                    if($result){
                        $_SESSION = [];
                        session_destroy();
                        header('Location: /');
                        exit();
                    }
                }
            }

            $router->render('admin/users/updatePassword',[
                'title' => 'Actualizar contraseña',
                'user' => $user
            ]);
        } else{
            header('Location: /404');
        }
    }
}