<?php

namespace Controllers;

use Model\ProductsInventory;

class APIInventoryController{

    public static function index(){
        $product_id = $_GET['product_id'] ?? '';

        $product_id = filter_var($product_id, FILTER_VALIDATE_INT);

        if(!$product_id){
            echo json_encode([]);
            return;
        }

        // Query the database
        $productInventory = ProductsInventory::find($product_id) ?? [];

        echo json_encode($productInventory);
    }

}