<?php

use Model\Category;
use Model\Employee;
use Model\EmployeeRole;

function debug($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function currentPageBool($path){
    return str_contains($_SERVER['PATH_INFO'], $path) ? true : false;
}

function currentPage($path){
    return str_contains($_SERVER['PATH_INFO'], $path) ? 'dashboard__link--current' : '';
}

function isAuth() : bool{
    if(!isset($_SESSION)){
        session_start();
    }
    return isset($_SESSION['name']) && !empty($_SESSION);
}

function isAdmin() : bool{
    session_start();
    return isset($_SESSION['isAdmin']) && !empty($_SESSION['isAdmin']);
}

function isEmployee() : bool{
    session_start();
    return isset($_SESSION['isEmployee']) && !empty($_SESSION['isEmployee']);
}

function groupCategories($categories = []){
    $categoriesIds = [];

    foreach($categories as $category){
        if(false !== strpos(strtolower($category->subtype), 'urn') && false !== strpos(strtolower($category->name), 'wooden')){
            $categoriesIds['wooden_urns'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'urn') && false !== strpos(strtolower($category->name), 'metallic')){
            $categoriesIds['metallic_urns'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'urn') && false !== strpos(strtolower($category->name), 'ecological')){
            $categoriesIds['ecological_urns'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'urn') && false !== strpos(strtolower($category->name), 'marble')){
            $categoriesIds['marble_urns'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'coffin') && false !== strpos(strtolower($category->name), 'wooden')){
            $categoriesIds['wooden_coffins'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'coffin') && false !== strpos(strtolower($category->name), 'metallic')){
            $categoriesIds['metallic_coffins'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'coffin') && false !== strpos(strtolower($category->name), 'ecological')){
            $categoriesIds['ecological_coffins'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'funeral')){
            $categoriesIds['funeral'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'legal')){
            $categoriesIds['legal'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'transport')){
            $categoriesIds['transport'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'own')){
            $categoriesIds['own'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'external')){
            $categoriesIds['external'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'fix')){
            $categoriesIds['fix'][] = $category->id;
        }
        if(false !== strpos(strtolower($category->subtype), 'pos')){
            $categoriesIds['pos'][] = $category->id;
        }
    }
    
    return $categoriesIds;
}

function groupProductsByCategory($products = [], $categoriesIds = []){
    $formatedProducts = [];

    foreach($products as $product){
        $product->category = Category::find($product->category_id);

        if(in_array($product->category_id, $categoriesIds["wooden_coffins"])){
            $formatedProducts['coffins']['wooden'][] = $product;
        }
        if(in_array($product->category_id, $categoriesIds["metallic_coffins"])){
            $formatedProducts['coffins']['metallic'][] = $product;
        }
        if(in_array($product->category_id, $categoriesIds["ecological_coffins"])){
            $formatedProducts['coffins']['ecological'][] = $product;
        }
        if(in_array($product->category_id, $categoriesIds["wooden_urns"])){
            $formatedProducts['urns']['wooden'][] = $product;
        }
        if(in_array($product->category_id, $categoriesIds["metallic_urns"])){
            $formatedProducts['urns']['metallic'][] = $product;
        }
        if(in_array($product->category_id, $categoriesIds["ecological_urns"])){
            $formatedProducts['urns']['ecological'][] = $product;
        }
        if(in_array($product->category_id, $categoriesIds["marble_urns"])){
            $formatedProducts['urns']['marble'][] = $product;
        }
    }

    return $formatedProducts;
}

function groupServicesByCategory($services = [], $categoriesIds = []){
    $formatedServices = [];

    foreach($services as $service){
        $service->category = Category::find($service->category_id);

        if(in_array($service->category_id, $categoriesIds["funeral"])){
            $formatedServices['funeral'][] = $service;
        }
        if(in_array($service->category_id, $categoriesIds["legal"])){
            $formatedServices['legal'][] = $service;
        }
        if(in_array($service->category_id, $categoriesIds["transport"])){
            $formatedServices['transport'][] = $service;
        }
    }

    return $formatedServices;
}

function groupBranchesByCategory($branches = [], $categoriesIds = []){
    $formatedBranches = [];

    foreach($branches as $branch){
        $branch->category = Category::find($branch->category_id);

        if(in_array($branch->category_id, $categoriesIds["fix"])){
            $formatedBranches['fix'][] = $branch;
        }
        if(in_array($branch->category_id, $categoriesIds["pos"])){
            $formatedBranches['pos'][] = $branch;
        }
    }

    return $formatedBranches;
}

function groupChapelsByCategory($chapels = [], $categoriesIds = []){
    $formatedChapels = [];

    foreach($chapels as $chapel){
        $chapel->category = Category::find($chapel->category_id);

        if(in_array($chapel->category_id, $categoriesIds["own"])){
            $formatedChapels['own'][] = $chapel;
        }
        if(in_array($chapel->category_id, $categoriesIds["external"])){
            $formatedChapels['external'][] = $chapel;
        }
    }

    return $formatedChapels;
}

function groupHearsesByCategory($hearses = [], $categoriesIds = []){
    $formatedHearses = [];

    foreach($hearses as $hearse){
        $hearse->category = Category::find($hearse->category_id);

        if(in_array($hearse->category_id, $categoriesIds["own"])){
            $formatedHearses['own'][] = $hearse;
        }
        if(in_array($hearse->category_id, $categoriesIds["external"])){
            $formatedHearses['external'][] = $hearse;
        }
    }

    return $formatedHearses;
}

function groupCemeteriesByCategory($cemeteries = [], $categoriesIds = []){
    $formatedCemeteries = [];

    foreach($cemeteries as $cemetery){
        $cemetery->category = Category::find($cemetery->category_id);

        if(in_array($cemetery->category_id, $categoriesIds["own"])){
            $formatedCemeteries['own'][] = $cemetery;
        }
        if(in_array($cemetery->category_id, $categoriesIds["external"])){
            $formatedCemeteries['external'][] = $cemetery;
        }
    }

    return $formatedCemeteries;
}

function groupCrematoriesByCategory($crematories = [], $categoriesIds = []){
    $formatedCrematories = [];

    foreach($crematories as $crematory){
        $crematory->category = Category::find($crematory->category_id);

        if(in_array($crematory->category_id, $categoriesIds["own"])){
            $formatedCrematories['own'][] = $crematory;
        }
        if(in_array($crematory->category_id, $categoriesIds["external"])){
            $formatedCrematories['external'][] = $crematory;
        }
    }

    return $formatedCrematories;
}

function aos_animations() {
    $effects = ['fade-up', 'fade-down', 'fade-left', 'fade-right', 'flip-left', 'flip-right', 'zoom-in', 'zoom-in-up', 'zoom-in-down', 'zoom-out'];
    $effect = array_rand($effects, 1);
    return ' data-aos="' . $effects[$effect] . '" ';
}

function create_mail_header(){
    $header  = '<table width="100%" cellpadding="0" cellspacing="0" style="background-color: #0A1433;">';
    $header .= '<tr>';
    $header .= '<td align="center" style="padding: 15px 0;">';
    $header .= '<a href="https://www.funeralesfuentes.com" target="_blank">';
    $header .= '<img src="' . $_ENV['HOST'] . '/public/build/img/title.png" alt="Logo Funerales Fuentes" width="175" height="50" style="display: block;">';
    $header .= '</a>';
    $header .= '</td>';
    $header .= '</tr>';
    $header .= '<tr>';
    $header .= '<td align="center" style="padding-bottom: 15px;">';
    $header .= '<p style="font-family: \'Charter\', Georgia, serif; font-size: 15px; font-weight: bold; color: white; margin: 0; text-transform: uppercase;">Conmemoramos la vida<br>dignificando la muerte</p>';
    $header .= '</td>';
    $header .= '</tr>';
    $header .= '</table>';

    return $header;
}

function create_mail_sign($author, $author_mail, $author_phones){
    $sign = '<table cellpadding="0" cellspacing="0" style="font-family: \'Charter\', Georgia, serif; font-size: 12px; color: #333; margin-top: 30px;">';
    $sign .= '<tr>';
    $sign .= '<td style="padding-right: 15px;">';
    $sign .= '<a href="https://www.funeralesfuentes.com" target="_blank">';
    $sign .= '<img src="' . $_ENV['HOST'] . '/public/build/img/firma.png" alt="Logo Funerales Fuentes" width="80" style="border-radius: 4px;">';
    $sign .= '</a>';
    $sign .= '</td>';
    $sign .= '<td>';
    $sign .= '<strong style="font-size: 12px;">'.$author.'</strong><br>';
    $sign .= 'Director General<br>';
    $sign .= '<span style="color: #555;">Funerales Fuentes</span><br>';
    $sign .= '<a href="mailto:'.$author_mail.'" style="color: #0066cc; text-decoration: none;">';
    $sign .= $author_mail.'</a><br>';
    $i = 1;
    foreach($author_phones as $author_phone){
        $sign .= '<span style="color: #333;">Teléfono '.$i.': '.$author_phone.'</span><br>';
    }
    $sign .= '<table cellpadding="0" cellspacing="0" style="margin-top: 10px;"><tr>';
    $sign .= '<td><a href="https://facebook.com/oficialfuneralesfuentes" target="_blank" style="margin-right: 8px;"><img src="' . $_ENV['HOST'] . '/build/img/facebook.png" alt="Facebook" width="18" height="18" style="border: none;"></a></td>';
    $sign .= '<td><a href="https://x.com/funefuentes" target="_blank" style="margin-right: 8px;"><img src="' . $_ENV['HOST'] . '/build/img/x.png" alt="X" width="18" height="18" style="border: none;"></a></td>';
    $sign .= '<td><a href="https://youtube.com/@funeralesfuentes" target="_blank" style="margin-right: 8px;"><img src="' . $_ENV['HOST'] . '/build/img/youtube.png" alt="YouTube" width="18" height="18" style="border: none;"></a></td>';
    $sign .= '<td><a href="https://instagram.com/_funeralesfuentes" target="_blank" style="margin-right: 8px;"><img src="' . $_ENV['HOST'] . '/build/img/instagram.png" alt="Instagram" width="18" height="18" style="border: none;"></a></td>';
    $sign .= '<td><a href="https://linkedin.com/company/funeralesfuentes" target="_blank"><img src="' . $_ENV['HOST'] . '/build/img/linkedin.png" alt="LinkedIn" width="18" height="18" style="border: none;"></a></td>';
    $sign .= '</tr></table>';
    $sign .= '</td></tr></table>';

    return $sign;
}

function getRandomImageFromFolder(string $folder, array $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif']){
    if (!is_dir($folder)) return null;

    $files = scandir($folder);
    $images = [];

    foreach ($files as $file) {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($extension, $allowedExtensions)) {
            $images[] = $file;
        }
    }

    if (empty($images)) return null;

    return $images[array_rand($images)];
}

function getTypeOfHeader($value, $isAdmin = false, $isEmployee = false){
    $result = "LARGE";
    $assigned = false;

    $adminElements = [
        '/dashboard',
        '/dashboard/products',
        '/dashboard/services',
        '/dashboard/hearses',
        '/dashboard/branches',
        '/dashboard/chapels',
        '/dashboard/cemeteries',
        '/dashboard/crematories'
    ];

    $loginElements = [
        '/login',
        '/register',
        '/forgot',
        '/404'
    ];

    $shortElements = [
        '/about',
        '/products',
        '/services',
        '/hearses',
        '/branches',
        '/chapels',
        '/cemeteries',
        '/crematories'
    ];

    if(str_contains($value, '/user')){
        if($isAdmin){
            $result = "ADMIN";
            $assigned = true;
        } else{
            $result = "LOGIN";
            $assigned = true;
        }
    }

    if(str_contains($value, '/message')){
        if($isAdmin){
            $result = "ADMIN";
            $assigned = true;
        } else{
            $result = "LOGIN";
            $assigned = true;
        }
    }

    if(str_contains($value, '/dashboard/users/reset')){
        if($isAdmin){
            $result = "ADMIN";
            $assigned = true;
        } else if($isEmployee){
            $result = "SHORT";
            $assigned = true;
        } else{
            $result = "LOGIN";
            $assigned = true;
        }
    }

    if(!$assigned){
        foreach($adminElements as $element){
            if(str_contains($value, $element)){
                $result = "ADMIN";
                $assigned = true;
            }
        } 
    }
    
    if(!$assigned){
        foreach($loginElements as $element){
            if(str_contains($value, $element)){
                $result = "LOGIN";
                $assigned = true;
            }
        }
    }
    
    if(!$assigned){
        foreach($shortElements as $element){
            if(str_contains($value, $element)){
                $result = "SHORT";
                $assigned = true;
            }
        }
    }

    return $result;
}

function getUserRole(){
    if(isEmployee()){
        return "EMPLOYEE";
    } else if(isAdmin()){
        return "ADMIN";
    } else{
        return "USER";
    }
}

function getUserRoleAlt($user){
    if("1" === $user->isAdmin){
        return "ADMIN";
    } else if("1" === $user->isEmployee){
        return "EMPLOYEE";
    } else{
        return "USER";
    }
}

function getDatabaseRoles($role){
    $dbroles = [];
    if("ADMIN" === strtoupper($role)){
        $dbroles = [
            'isAdmin' => 1,
            'isEmployee' => 0 
        ];
    } else if("EMPLOYEE" === strtoupper($role)){
        $dbroles = [
            'isAdmin' => 0,
            'isEmployee' => 1 
        ];
    } else{
        $dbroles = [
            'isAdmin' => 0,
            'isEmployee' => 0 
        ];
    }
    return $dbroles;
}

function getVisualValue($realValue){
    $result = "";
    switch(strtoupper($realValue)){
        case 'ACTIVE':
            $result = "Activo";
        break;
        case 'INACTIVE':
            $result = "Inhabilitado";
        break;
        case 'ADMIN':
            $result = "Administrador";
        break;
        case 'EMPLOYEE':
            $result = "Empleado";
        break;
        case 'USER':
            $result = "Usuario";
        break;
        default:
        $result = "Activo";
        break;
    }
    return $result;
}

function generateEmployeeCode(EmployeeRole $role){
    $count = (Employee::countRecords('positionId', $role->id)*1) + 1;
    return strtoupper($role->name).str_pad($count, 15, '0', STR_PAD_LEFT);
}

function lookForRoleId($roles, $id) {
    foreach ($roles as $rol) {
        if ($rol->id === $id) {
            return $rol;
        }
    }
    return null;
}

function getDateYear($dataDate){
    $date = new DateTime($dataDate);
    return $date->format('Y');
}

function getPeriod($date, $periods) {
    $timestamp = strtotime($date);
    $year = date('Y', $timestamp);
    $month = date('n', $timestamp);

    $periodo = ceil(($month / 12) * $periods);

    return $year . '/' . $periodo;
}