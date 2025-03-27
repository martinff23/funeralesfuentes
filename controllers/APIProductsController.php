<?php

namespace Controllers;

use Model\Product;

class APIProductsController{

    public static function indexCoffins(){
        $coffins = Product::allWhere('tags','Ata');
        echo json_encode($coffins);
    }

    public static function indexUrns(){
        $urns = Product::allWhere('tags','Urn');
        echo json_encode($urns);
    }

}