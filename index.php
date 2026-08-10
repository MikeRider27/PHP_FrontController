<?php

session_start();

require_once "core/database.php";

$controlador = isset($_GET['c']) ? $_GET['c'] : "home";

if($controlador !== "login" && !isset($_SESSION['usuario'])){
    header("location:?c=login");
    exit;
}

require_once "controller/$controlador.controller.php";
$controlador = ucwords($controlador)."Controller";
$controlador = new $controlador;
$accion = isset($_GET['a']) ? $_GET['a'] : "Inicio";
call_user_func(array($controlador,$accion));