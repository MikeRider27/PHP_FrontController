<?php

namespace App\Core;

use App\Controllers\LoginController;
use App\Controllers\HomeController;
use App\Controllers\CategoriaController;
use App\Controllers\ProveedorController;
use App\Controllers\ProductoController;
use App\Controllers\MovimientoController;
use App\Controllers\ReporteController;
use App\Controllers\UsuarioController;
use App\Controllers\OrdenCompraController;

class Router
{
    private const MAP = [
        'login' => LoginController::class,
        'home' => HomeController::class,
        'categoria' => CategoriaController::class,
        'proveedor' => ProveedorController::class,
        'producto' => ProductoController::class,
        'movimiento' => MovimientoController::class,
        'reporte' => ReporteController::class,
        'usuario' => UsuarioController::class,
        'ordencompra' => OrdenCompraController::class,
    ];

    private const PUBLIC_CONTROLLERS = ['login'];

    public static function dispatch(): void
    {
        $controllerName = $_GET['c'] ?? 'home';
        $action = $_GET['a'] ?? 'Inicio';

        if (!isset(self::MAP[$controllerName])) {
            header('location:?c=home');
            exit;
        }

        if (!in_array($controllerName, self::PUBLIC_CONTROLLERS, true) && !Auth::check()) {
            header('location:?c=login');
            exit;
        }

        $class = self::MAP[$controllerName];
        $controller = new $class();

        if (!method_exists($controller, $action)) {
            header('location:?c=home');
            exit;
        }

        call_user_func([$controller, $action]);
    }
}
