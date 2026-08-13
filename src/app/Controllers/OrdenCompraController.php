<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\OrdenCompra;
use App\Models\Producto;
use App\Models\Proveedor;

class OrdenCompraController extends Controller
{
    private OrdenCompra $modelo;
    private Proveedor $proveedores;
    private Producto $productos;

    public function __construct()
    {
        $this->requireRole(['Administrador']);
        $this->modelo = new OrdenCompra();
        $this->proveedores = new Proveedor();
        $this->productos = new Producto();
    }

    public function Inicio(): void
    {
        $estado = trim($_GET['estado'] ?? '');
        $this->render('ordencompra/index', [
            'ordenes' => $this->modelo->listar($estado ?: null),
            'estado' => $estado,
            'error' => $_SESSION['orden_error'] ?? null,
        ]);
        unset($_SESSION['orden_error']);
    }

    public function Nueva(): void
    {
        $this->render('ordencompra/nueva', [
            'proveedores' => $this->proveedores->listarActivos(),
            'productos' => $this->productos->listarActivos(),
        ]);
    }

    public function Guardar(): void
    {
        $proveedorId = intval($_POST['proveedor_id'] ?? 0);
        $productoIds = $_POST['producto_id'] ?? [];
        $cantidades = $_POST['cantidad'] ?? [];
        $costos = $_POST['costo'] ?? [];

        $lineas = [];
        foreach ($productoIds as $i => $productoId) {
            $productoId = intval($productoId);
            $cantidad = intval($cantidades[$i] ?? 0);
            $costo = floatval($costos[$i] ?? 0);
            if ($productoId > 0 && $cantidad > 0) {
                $lineas[] = ['producto_id' => $productoId, 'cantidad' => $cantidad, 'costo' => $costo];
            }
        }

        if ($proveedorId > 0 && !empty($lineas)) {
            $usuario = Auth::user();
            $ordenId = $this->modelo->crear($proveedorId, $usuario['usuario_id'], $lineas);
            header("location:?c=ordencompra&a=Ver&id=$ordenId");
            exit;
        }

        header('location:?c=ordencompra&a=Nueva');
        exit;
    }

    public function Ver(): void
    {
        $id = intval($_GET['id'] ?? 0);
        $orden = $id > 0 ? $this->modelo->obtenerConDetalle($id) : null;

        if ($orden === null) {
            header('location:?c=ordencompra');
            exit;
        }

        $this->render('ordencompra/ver', ['orden' => $orden]);
    }

    public function Recibir(): void
    {
        $id = intval($_GET['id'] ?? 0);
        $usuario = Auth::user();

        if ($id > 0) {
            try {
                $this->modelo->marcarRecibida($id, $usuario['usuario_id']);
            } catch (\Throwable $e) {
                $_SESSION['orden_error'] = 'No se pudo recibir la orden: ' . $e->getMessage();
            }
        }

        header("location:?c=ordencompra&a=Ver&id=$id");
        exit;
    }

    public function Cancelar(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->modelo->marcarCancelada($id);
        }
        header('location:?c=ordencompra');
        exit;
    }
}
