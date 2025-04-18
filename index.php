<?php 

error_reporting(0);
ini_set('display_errors', 0);

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ .'/includes/app.php';
// require_once getenv('HOST').'/includes/app.php';

use Controllers\AlliancesController;
use Controllers\APIBirthdaysController;
use Controllers\APICemeteriesController;
use Controllers\APIChapelsController;
use Controllers\APIComplementsController;
use Controllers\APIContactController;
use Controllers\APICrematoriesController;
use Controllers\APIHearsesController;
use Controllers\APIInventoryController;
use Controllers\APILocationsController;
use Controllers\APIProductsController;
use Controllers\APIServicesController;
use Controllers\APITaskController;
use Controllers\APIUsersController;
use MVC\Router;
use Controllers\AuthController;
use Controllers\BranchesController;
use Controllers\CemeteriesController;
use Controllers\ChapelsController;
use Controllers\ComplementsController;
use Controllers\ContactsController;
use Controllers\CotizationsController;
use Controllers\CrematoriesController;
use Controllers\DashboardController;
use Controllers\EmployeeRolesController;
use Controllers\FilesController;
use Controllers\HearsesController;
use Controllers\IdentificationsController;
use Controllers\IntranetController;
use Controllers\OpsCountriesController;
use Controllers\PackagesController;
use Controllers\PagesController;
use Controllers\ProductsController;
use Controllers\RelationsController;
use Controllers\ServicesController;
use Controllers\SpecialProgramsController;
use Controllers\TasksController;
use Controllers\UserPagesController;
use Controllers\UsersController;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

$router->get('/404', [PagesController::class, 'error']);

// Create account
$router->get('/register', [AuthController::class, 'register']);
$router->post('/register', [AuthController::class, 'register']);

// Forgot my password
$router->get('/forgot', [AuthController::class, 'forgot']);
$router->post('/forgot', [AuthController::class, 'forgot']);

// New password
$router->get('/reset', [AuthController::class, 'reset']);
$router->post('/reset', [AuthController::class, 'reset']);

// Account confirm
$router->get('/message', [AuthController::class, 'message']);
$router->get('/confirmAccount', [AuthController::class, 'confirmaccount']);

// Admin area
$router->get('/dashboard/start', [DashboardController::class, 'dashboard']);
$router->get('/dashboard/users', [DashboardController::class, 'usersMenu']);
$router->get('/dashboard/workElements', [DashboardController::class, 'workElementsMenu']);
$router->get('/dashboard/recordElements', [DashboardController::class, 'recordElementsMenu']);
$router->get('/dashboard/alliMenu', [DashboardController::class, 'alliancesMenu']);

$router->get('/dashboard/users/employees', [UsersController::class, 'empDashboard']);
$router->get('/dashboard/users/employees/create', [UsersController::class, 'empCreate']);
$router->post('/dashboard/users/employees/create', [UsersController::class, 'empCreate']);
$router->get('/dashboard/users/employees/edit', [UsersController::class, 'empEdit']);
$router->post('/dashboard/users/employees/edit', [UsersController::class, 'empEdit']);
$router->post('/dashboard/users/employees/delete', [UsersController::class, 'empDelete']);
$router->get('/dashboard/users/others', [UsersController::class, 'othDashboard']);
$router->get('/dashboard/users/others/create', [UsersController::class, 'othCreate']);
$router->post('/dashboard/users/others/create', [UsersController::class, 'othCreate']);
$router->get('/dashboard/users/others/edit', [UsersController::class, 'othEdit']);
$router->post('/dashboard/users/others/edit', [UsersController::class, 'othEdit']);
$router->post('/dashboard/users/others/delete', [UsersController::class, 'othDelete']);
$router->get('/dashboard/users/reset', [UsersController::class, 'updatePassword']);
$router->post('/dashboard/users/reset', [UsersController::class, 'updatePassword']);

$router->get('/dashboard/services', [ServicesController::class, 'dashboard']);
$router->get('/dashboard/services/create', [ServicesController::class, 'create']);
$router->post('/dashboard/services/create', [ServicesController::class, 'create']);
$router->get('/dashboard/services/edit', [ServicesController::class, 'edit']);
$router->post('/dashboard/services/edit', [ServicesController::class, 'edit']);
$router->post('/dashboard/services/delete', [ServicesController::class, 'delete']);

$router->get('/dashboard/products', [ProductsController::class, 'dashboard']);
$router->get('/dashboard/products/create', [ProductsController::class, 'create']);
$router->post('/dashboard/products/create', [ProductsController::class, 'create']);
$router->get('/dashboard/products/edit', [ProductsController::class, 'edit']);
$router->post('/dashboard/products/edit', [ProductsController::class, 'edit']);
$router->post('/dashboard/products/delete', [ProductsController::class, 'delete']);

$router->get('/dashboard/complements', [ComplementsController::class, 'dashboard']);
$router->get('/dashboard/complements/create', [ComplementsController::class, 'create']);
$router->post('/dashboard/complements/create', [ComplementsController::class, 'create']);
$router->get('/dashboard/complements/edit', [ComplementsController::class, 'edit']);
$router->post('/dashboard/complements/edit', [ComplementsController::class, 'edit']);
$router->post('/dashboard/complements/delete', [ComplementsController::class, 'delete']);

$router->get('/dashboard/branches', [BranchesController::class, 'dashboard']);
$router->get('/dashboard/branches/create', [BranchesController::class, 'create']);
$router->post('/dashboard/branches/create', [BranchesController::class, 'create']);
$router->get('/dashboard/branches/edit', [BranchesController::class, 'edit']);
$router->post('/dashboard/branches/edit', [BranchesController::class, 'edit']);
$router->post('/dashboard/branches/delete', [BranchesController::class, 'delete']);

$router->get('/dashboard/chapels', [ChapelsController::class, 'dashboard']);
$router->get('/dashboard/chapels/create', [ChapelsController::class, 'create']);
$router->post('/dashboard/chapels/create', [ChapelsController::class, 'create']);
$router->get('/dashboard/chapels/edit', [ChapelsController::class, 'edit']);
$router->post('/dashboard/chapels/edit', [ChapelsController::class, 'edit']);
$router->post('/dashboard/chapels/delete', [ChapelsController::class, 'delete']);

$router->get('/dashboard/hearses', [HearsesController::class, 'dashboard']);
$router->get('/dashboard/hearses/create', [HearsesController::class, 'create']);
$router->post('/dashboard/hearses/create', [HearsesController::class, 'create']);
$router->get('/dashboard/hearses/edit', [HearsesController::class, 'edit']);
$router->post('/dashboard/hearses/edit', [HearsesController::class, 'edit']);
$router->post('/dashboard/hearses/delete', [HearsesController::class, 'delete']);

$router->get('/dashboard/cemeteries', [CemeteriesController::class, 'dashboard']);
$router->get('/dashboard/cemeteries/create', [CemeteriesController::class, 'create']);
$router->post('/dashboard/cemeteries/create', [CemeteriesController::class, 'create']);
$router->get('/dashboard/cemeteries/edit', [CemeteriesController::class, 'edit']);
$router->post('/dashboard/cemeteries/edit', [CemeteriesController::class, 'edit']);
$router->post('/dashboard/cemeteries/delete', [CemeteriesController::class, 'delete']);

$router->get('/dashboard/crematories', [CrematoriesController::class, 'dashboard']);
$router->get('/dashboard/crematories/create', [CrematoriesController::class, 'create']);
$router->post('/dashboard/crematories/create', [CrematoriesController::class, 'create']);
$router->get('/dashboard/crematories/edit', [CrematoriesController::class, 'edit']);
$router->post('/dashboard/crematories/edit', [CrematoriesController::class, 'edit']);
$router->post('/dashboard/crematories/delete', [CrematoriesController::class, 'delete']);

$router->get('/dashboard/packages', [PackagesController::class, 'dashboard']);
$router->get('/dashboard/packages/create', [PackagesController::class, 'create']);
$router->post('/dashboard/packages/create', [PackagesController::class, 'create']);
$router->get('/dashboard/packages/edit', [PackagesController::class, 'edit']);
$router->post('/dashboard/packages/edit', [PackagesController::class, 'edit']);
$router->post('/dashboard/packages/delete', [PackagesController::class, 'delete']);

$router->get('/dashboard/alliances', [AlliancesController::class, 'dashboard']);
$router->get('/dashboard/alliances/create', [AlliancesController::class, 'create']);
$router->post('/dashboard/alliances/create', [AlliancesController::class, 'create']);
$router->get('/dashboard/alliances/edit', [AlliancesController::class, 'edit']);
$router->post('/dashboard/alliances/edit', [AlliancesController::class, 'edit']);
$router->post('/dashboard/alliances/delete', [AlliancesController::class, 'delete']);

$router->get('/dashboard/files', [FilesController::class, 'dashboard']);
$router->get('/dashboard/files/create', [FilesController::class, 'create']);
$router->post('/dashboard/files/create', [FilesController::class, 'create']);
$router->get('/dashboard/files/edit', [FilesController::class, 'edit']);
$router->post('/dashboard/files/edit', [FilesController::class, 'edit']);
$router->post('/dashboard/files/delete', [FilesController::class, 'delete']);

$router->get('/dashboard/specialprograms', [SpecialProgramsController::class, 'dashboard']);
$router->get('/dashboard/specialprograms/create', [SpecialProgramsController::class, 'create']);
$router->post('/dashboard/specialprograms/create', [SpecialProgramsController::class, 'create']);
$router->get('/dashboard/specialprograms/edit', [SpecialProgramsController::class, 'edit']);
$router->post('/dashboard/specialprograms/edit', [SpecialProgramsController::class, 'edit']);
$router->post('/dashboard/specialprograms/delete', [SpecialProgramsController::class, 'delete']);

$router->get('/dashboard/opscountries', [OpsCountriesController::class, 'dashboard']);
$router->get('/dashboard/opscountries/create', [OpsCountriesController::class, 'create']);
$router->post('/dashboard/opscountries/create', [OpsCountriesController::class, 'create']);
$router->get('/dashboard/opscountries/edit', [OpsCountriesController::class, 'edit']);
$router->post('/dashboard/opscountries/edit', [OpsCountriesController::class, 'edit']);
$router->post('/dashboard/opscountries/delete', [OpsCountriesController::class, 'delete']);

$router->get('/dashboard/identifications', [IdentificationsController::class, 'dashboard']);
$router->get('/dashboard/identifications/create', [IdentificationsController::class, 'create']);
$router->post('/dashboard/identifications/create', [IdentificationsController::class, 'create']);
$router->get('/dashboard/identifications/edit', [IdentificationsController::class, 'edit']);
$router->post('/dashboard/identifications/edit', [IdentificationsController::class, 'edit']);
$router->post('/dashboard/identifications/delete', [IdentificationsController::class, 'delete']);

$router->get('/dashboard/relations', [RelationsController::class, 'dashboard']);
$router->get('/dashboard/relations/create', [RelationsController::class, 'create']);
$router->post('/dashboard/relations/create', [RelationsController::class, 'create']);
$router->get('/dashboard/relations/edit', [RelationsController::class, 'edit']);
$router->post('/dashboard/relations/edit', [RelationsController::class, 'edit']);
$router->post('/dashboard/relations/delete', [RelationsController::class, 'delete']);

$router->get('/dashboard/jobroles', [EmployeeRolesController::class, 'dashboard']);
$router->get('/dashboard/jobroles/create', [EmployeeRolesController::class, 'create']);
$router->post('/dashboard/jobroles/create', [EmployeeRolesController::class, 'create']);
$router->get('/dashboard/jobroles/edit', [EmployeeRolesController::class, 'edit']);
$router->post('/dashboard/jobroles/edit', [EmployeeRolesController::class, 'edit']);
$router->post('/dashboard/jobroles/delete', [EmployeeRolesController::class, 'delete']);

$router->get('/dashboard/contacts', [ContactsController::class, 'dashboard']);

$router->get('/dashboard/tasks', [TasksController::class, 'dashboard']);

// Intranet area
$router->get('/dashboard/intranet', [IntranetController::class, 'dashboard']);
$router->get('/dashboard/intranet/contract', [IntranetController::class, 'contract']);

// API to check product inventory
$router->get('/api/product-inventory', [APIInventoryController::class, 'index']);
$router->get('/api/coffins', [APIProductsController::class, 'indexCoffins']);
$router->get('/api/urns', [APIProductsController::class, 'indexUrns']);
$router->get('/api/services', [APIServicesController::class, 'index']);
$router->get('/api/complements', [APIComplementsController::class, 'index']);
$router->get('/api/chapels', [APIChapelsController::class, 'index']);
$router->get('/api/hearses', [APIHearsesController::class, 'index']);
$router->get('/api/cemeteries', [APICemeteriesController::class, 'index']);
$router->get('/api/crematories', [APICrematoriesController::class, 'index']);
$router->get('/api/birthdays', [APIBirthdaysController::class, 'index']);
$router->get('/api/locations', [APILocationsController::class, 'locations']);
$router->get('/api/contact', [APIContactController::class, 'contact']);
$router->post('/api/contact', [APIContactController::class, 'contact']);
$router->post('/api/deleteuser', [APIUsersController::class, 'deleteUserN']);
$router->post('/api/takecontact', [APITaskController::class, 'takeContact']);
$router->post('/api/gettaskinfo', [APITaskController::class, 'getTask']);
$router->post('/api/completetask', [APITaskController::class, 'completeTask']);
$router->post('/api/returntask', [APITaskController::class, 'returnTask']);

// Public areas
$router->get('/', [PagesController::class, 'index']);
$router->post('/', [PagesController::class, 'index']);
$router->get('/about', [PagesController::class, 'about']);
$router->get('/packages', [PagesController::class, 'packages']);
$router->get('/products', [PagesController::class, 'products']);
$router->get('/services', [PagesController::class, 'services']);
$router->get('/branches', [PagesController::class, 'branches']);
$router->get('/chapels', [PagesController::class, 'chapels']);
$router->get('/hearses', [PagesController::class, 'hearses']);
$router->get('/cemeteries', [PagesController::class, 'cemeteries']);
$router->get('/crematories', [PagesController::class, 'crematories']);
$router->get('/cotization', [PagesController::class, 'cotization']);

// User sites
$router->get('/user/menu', [UserPagesController::class, 'index']);
$router->get('/user/info', [UserPagesController::class, 'info']);
$router->post('/user/info', [UserPagesController::class, 'info']);
$router->get('/user/password', [UserPagesController::class, 'password']);
$router->post('/user/password', [UserPagesController::class, 'password']);
$router->get('/user/photo', [UserPagesController::class, 'photo']);
$router->post('/user/photo', [UserPagesController::class, 'photo']);
$router->get('/user/email', [UserPagesController::class, 'email']);
$router->post('/user/email', [UserPagesController::class, 'email']);
$router->get('/user/subscriptions', [UserPagesController::class, 'subscriptions']);
$router->post('/user/subscriptions', [UserPagesController::class, 'subscriptions']);
$router->get('/user/plans', [UserPagesController::class, 'plans']);
$router->post('/user/plans', [UserPagesController::class, 'plans']);
$router->get('/user/digitickets', [UserPagesController::class, 'digitickets']);
$router->post('/user/digitickets', [UserPagesController::class, 'digitickets']);
$router->get('/user/history', [UserPagesController::class, 'history']);

$router->verifyRoutes();