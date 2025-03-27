<?php

namespace Model;

class Category extends ActiveRecord{
    protected static $table = 'categories';
    protected static $databaseColumns = ['id', 'name', 'visible_name', 'type', 'subtype'];

    public $id;
    public $name;
    public $visible_name;
    public $type;
    public $subtype;
}

?>