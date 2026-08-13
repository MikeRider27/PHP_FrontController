<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\MovimientoStock;
use App\Models\Producto;
use PDOException;

class MovimientoController extends Controller
{
    private MovimientoStock $modelo;
    private Producto $productos;

    private const TIPOS_VALIDOS = ['ENTRADA', 'SALIDA', 'AJUSTE'];

    public function __construct()
    {
        $this->modelo = new MovimientoStock();
        $this->productos = new Producto();
    }

    public function Inicio(): void
    {
        $productoId = !empty($_GET['producto_id']) ? intval($_GET['producto_id']) : null;

        $this->render('movimiento/index', [
            'movimientos' => $this->modelo->listar($productoId),
            'productos' => $this->productos->listarActivos(),
            'productoId' => $productoId,
            'error' => $_SESSION['movimiento_error'] ?? null,
        ]);
        unset($_SESSION['movimiento_error']);
    }

    public function Guardar(): void
    {
        $productoId = intval($_POST['producto_id'] ?? 0);
        $tipo = strtoupper(trim($_POST['movimiento_tipo'] ?? ''));
        $cantidad = intval($_POST['movimiento_cantidad'] ?? 0);
        $motivo = trim($_POST['movimiento_motivo'] ?? '');
        $usuario = Auth::user();

        if ($productoId > 0 && in_array($tipo, self::TIPOS_VALIDOS, true) && $cantidad >= 0) {
            try {
                $this->modelo->registrar($productoId, $tipo, $cantidad, $motivo, $usuario['usuario_id']);
            } catch (PDOException $e) {
                $_SESSION['movimiento_error'] = 'No se pudo registrar el movimiento: ' . $this->mensajeAmigable($e);
            }
        }

        header('location:?c=movimiento');
        exit;
    }

    private function mensajeAmigable(PDOException $e): string
    {
        // El trigger de la base de datos usa RAISE EXCEPTION con un mensaje legible;
        // PDO lo entrega dentro del texto del error de PostgreSQL.
        if (preg_match('/ERROR:\s*(.+?)(\n|$)/', $e->getMessage(), $m)) {
            return $m[1];
        }
        return 'Verifique los datos e intente nuevamente.';
    }
}
