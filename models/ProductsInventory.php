<?php

namespace Model;

class ProductsInventory extends ActiveRecord{
    protected static $table = 'products';
    protected static $databaseColumns = ['id', 'product_name', 'product_inventory'];

    public $id;
    public $product_name;
    public $product_inventory;
}