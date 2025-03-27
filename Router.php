<?php

namespace MVC;

class Router{
    public array $getRoutes = [];
    public array $setRoutes = [];

    public function get($url, $fn){
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn){
        $this->setRoutes[$url] = $fn;
    }

    public function verifyRoutes(){

        $currentURL = $_SERVER['PATH_INFO'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ('GET'===$method) {
            $fn = $this->getRoutes[$currentURL] ?? null;
        } else {
            $fn = $this->setRoutes[$currentURL] ?? null;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    public function render($view, $data = []){
        foreach ($data as $key => $value){
            $$key = $value; 
        }

        ob_start(); 

        include_once __DIR__ . "/views/$view.php";

        $content = ob_get_clean();

        //Use layout according to URL
        $currentURL = $_SERVER['PATH_INFO'] ?? '/';

        if(str_contains($currentURL,'/dashboard')){
            include_once __DIR__ . '/views/adminLayout.php';
        } else{
            include_once __DIR__ . '/views/layout.php';
        }
    }
}
