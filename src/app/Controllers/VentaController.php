<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Pdf;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\TurnoCaja;
use App\Models\Venta;

class VentaController extends Controller
{
    private Venta $modelo;
    private Cliente $clientes;
    private Producto $productos;
    private TurnoCaja $caja;

    public function __construct()
    {
        $this->requireRole(['Administrador', 'Operador']);
        $this->modelo = new Venta();
        $this->clientes = new Cliente();
        $this->productos = new Producto();
        $this->caja = new TurnoCaja();
    }

    public function Inicio(): void
    {
        $estado = trim($_GET['estado'] ?? '');
        $desde = trim($_GET['desde'] ?? '');
        $hasta = trim($_GET['hasta'] ?? '');

        $this->render('venta/index', [
            'ventas' => $this->modelo->listar($estado ?: null, $desde ?: null, $hasta ?: null),
            'estado' => $estado,
            'desde' => $desde,
            'hasta' => $hasta,
        ]);
    }

    public function Nueva(): void
    {
        $turnoAbierto = $this->caja->obtenerAbierto();

        if (!$turnoAbierto) {
            $_SESSION['caja_error'] = 'No se puede vender sin una caja abierta. Abrí un turno primero.';
            header('location:?c=caja');
            exit;
        }

        $this->render('venta/nueva', [
            'clientes' => $this->clientes->listarActivos(),
            'productos' => $this->productos->listarActivos(),
            'error' => $_SESSION['venta_error'] ?? null,
        ]);
        unset($_SESSION['venta_error']);
    }

    public function Guardar(): void
    {
        $turnoAbierto = $this->caja->obtenerAbierto();
        if (!$turnoAbierto) {
            $_SESSION['caja_error'] = 'No se puede vender sin una caja abierta. Abrí un turno primero.';
            header('location:?c=caja');
            exit;
        }

        $clienteId = intval($_POST['cliente_id'] ?? 0) ?: null;
        $formaPago = trim($_POST['forma_pago'] ?? '');
        $productoIds = $_POST['producto_id'] ?? [];
        $cantidades = $_POST['cantidad'] ?? [];
        $precios = $_POST['precio'] ?? [];

        $lineas = [];
        foreach ($productoIds as $i => $productoId) {
            $productoId = intval($productoId);
            $cantidad = intval($cantidades[$i] ?? 0);
            $precio = floatval($precios[$i] ?? 0);
            if ($productoId > 0 && $cantidad > 0) {
                $lineas[] = ['producto_id' => $productoId, 'cantidad' => $cantidad, 'precio' => $precio];
            }
        }

        if (in_array($formaPago, ['EFECTIVO', 'TARJETA'], true) && !empty($lineas)) {
            $usuario = Auth::user();
            try {
                $ventaId = $this->modelo->crear($clienteId, $usuario['usuario_id'], (int) $turnoAbierto['turno_id'], $formaPago, $lineas);
                header("location:?c=venta&a=Ver&id=$ventaId");
                exit;
            } catch (\Throwable $e) {
                $_SESSION['venta_error'] = 'No se pudo registrar la venta: ' . $e->getMessage();
            }
        }

        header('location:?c=venta&a=Nueva');
        exit;
    }

    public function Ver(): void
    {
        $id = intval($_GET['id'] ?? 0);
        $venta = $id > 0 ? $this->modelo->obtenerConDetalle($id) : null;

        if ($venta === null) {
            header('location:?c=venta');
            exit;
        }

        $this->render('venta/ver', [
            'venta' => $venta,
            'error' => $_SESSION['venta_error'] ?? null,
        ]);
        unset($_SESSION['venta_error']);
    }

    public function FacturaPdf(): void
    {
        $id = intval($_GET['id'] ?? 0);
        $venta = $id > 0 ? $this->modelo->obtenerConDetalle($id) : null;

        if ($venta === null) {
            header('location:?c=venta');
            exit;
        }

        Pdf::render('factura_venta', [
            'venta' => $venta,
        ], $venta['venta_numero'] . '.pdf');
    }

    public function Anular(): void
    {
        $id = intval($_POST['venta_id'] ?? 0);
        $motivo = trim($_POST['motivo'] ?? '');
        $usuario = Auth::user();

        if ($id > 0 && $motivo !== '') {
            try {
                $this->modelo->anular($id, $usuario['usuario_id'], $motivo);
            } catch (\Throwable $e) {
                $_SESSION['venta_error'] = 'No se pudo anular la venta: ' . $e->getMessage();
            }
        }

        header("location:?c=venta&a=Ver&id=$id");
        exit;
    }
}
