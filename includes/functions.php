<?php

use Model\Category;

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