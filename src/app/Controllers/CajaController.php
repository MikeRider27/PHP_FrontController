<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\TurnoCaja;

class CajaController extends Controller
{
    private TurnoCaja $modelo;

    public function __construct()
    {
        $this->requireRole(['Administrador', 'Operador']);
        $this->modelo = new TurnoCaja();
    }

    public function Inicio(): void
    {
        $abierto = $this->modelo->obtenerAbierto();
        $turno = $abierto ? $this->modelo->obtenerConDetalle($abierto['turno_id']) : null;

        $this->render('caja/index', [
            'turno' => $turno,
            'error' => $_SESSION['caja_error'] ?? null,
        ]);
        unset($_SESSION['caja_error']);
    }

    public function Abrir(): void
    {
        $montoInicial = floatval($_POST['monto_inicial'] ?? 0);
        $usuario = Auth::user();

        try {
            $this->modelo->abrir($usuario['usuario_id'], $montoInicial);
        } catch (\Throwable $e) {
            $_SESSION['caja_error'] = 'No se pudo abrir la caja: ya hay un turno abierto.';
        }

        header('location:?c=caja');
        exit;
    }

    public function Cerrar(): void
    {
        $abierto = $this->modelo->obtenerAbierto();
        $montoDeclarado = floatval($_POST['monto_declarado'] ?? 0);
        $observacion = trim($_POST['observacion'] ?? '');
        $usuario = Auth::user();

        if ($abierto) {
            try {
                $this->modelo->cerrar((int) $abierto['turno_id'], $usuario['usuario_id'], $montoDeclarado, $observacion ?: null);
            } catch (\Throwable $e) {
                $_SESSION['caja_error'] = 'No se pudo cerrar la caja: ' . $e->getMessage();
            }
        }

        header('location:?c=caja');
        exit;
    }

    public function MovimientoNuevo(): void
    {
        $abierto = $this->modelo->obtenerAbierto();
        $tipo = trim($_POST['tipo'] ?? '');
        $monto = floatval($_POST['monto'] ?? 0);
        $motivo = trim($_POST['motivo'] ?? '');
        $usuario = Auth::user();

        if ($abierto && $monto > 0 && $motivo !== '' && in_array($tipo, ['INGRESO', 'EGRESO'], true)) {
            $this->modelo->registrarMovimiento((int) $abierto['turno_id'], $tipo, $monto, $motivo, $usuario['usuario_id']);
        }

        header('location:?c=caja');
        exit;
    }

    public function Historial(): void
    {
        $this->render('caja/historial', [
            'turnos' => $this->modelo->listar(),
        ]);
    }

    public function Ver(): void
    {
        $id = intval($_GET['id'] ?? 0);
        $turno = $id > 0 ? $this->modelo->obtenerConDetalle($id) : null;

        if ($turno === null) {
            header('location:?c=caja&a=Historial');
            exit;
        }

        $this->render('caja/ver', ['turno' => $turno]);
    }
}
