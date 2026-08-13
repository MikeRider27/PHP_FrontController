<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MovimientoStock;
use App\Models\Producto;

class ReporteController extends Controller
{
    private Producto $productos;
    private MovimientoStock $movimientos;

    public function __construct()
    {
        $this->productos = new Producto();
        $this->movimientos = new MovimientoStock();
    }

    public function Inicio(): void
    {
        $this->render('reporte/stock_bajo', [
            'productos' => $this->productos->listarStockBajo(),
        ]);
    }

    public function ValorInventario(): void
    {
        $productos = $this->productos->valorInventario();

        $this->render('reporte/valor_inventario', [
            'productos' => $productos,
            'totalCosto' => array_sum(array_column($productos, 'valor_costo')),
            'totalVenta' => array_sum(array_column($productos, 'valor_venta')),
        ]);
    }

    public function MovimientosPorFecha(): void
    {
        [$desde, $hasta] = $this->rangoFechas();
        $tipo = trim($_GET['tipo'] ?? '');

        $this->render('reporte/movimientos_fecha', [
            'movimientos' => $this->movimientos->listarPorFecha($desde, $hasta, $tipo ?: null),
            'desde' => $desde,
            'hasta' => $hasta,
            'tipo' => $tipo,
        ]);
    }

    public function ProductosMasMovidos(): void
    {
        [$desde, $hasta] = $this->rangoFechas();

        $this->render('reporte/productos_mas_movidos', [
            'productos' => $this->movimientos->productosMasMovidos($desde, $hasta, 10),
            'desde' => $desde,
            'hasta' => $hasta,
        ]);
    }

    private function rangoFechas(): array
    {
        $desde = trim($_GET['desde'] ?? '') ?: date('Y-m-d', strtotime('-30 days'));
        $hasta = trim($_GET['hasta'] ?? '') ?: date('Y-m-d');
        return [$desde, $hasta];
    }
}
