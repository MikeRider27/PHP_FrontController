<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Producto;

class HomeController extends Controller
{
    private Producto $productos;

    public function __construct()
    {
        $this->productos = new Producto();
    }

    public function Inicio(): void
    {
        $error = $_SESSION['acceso_error'] ?? null;
        unset($_SESSION['acceso_error']);

        $this->render('home/index', [
            'totalProductos' => $this->productos->contarActivos(),
            'stockBajo' => $this->productos->listarStockBajo(),
            'error' => $error,
        ]);
    }
}
