<?php

require_once "core/database.php";

if(!isset($_GET['c'])){
    require_once "controller/home.controller.php";
    $controlador = new HomeController();
    call_user_func(array($controlador,"Inicio"));
}else{
    $controlador = $_GET['c'];
    require_once "controller/$controlador.controller.php";
    $controlador = ucwords($controlador)."Controller";
    $controlador = new $controlador;
    $accion = isset($_GET['a']) ? $_GET['a'] : "Inicio";
    call_user_func(array($controlador,$accion));
}