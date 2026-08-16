<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Pdf;
use App\Models\MovimientoStock;
use App\Models\Producto;
use App\Models\TurnoCaja;
use App\Models\Venta;

class ReporteController extends Controller
{
    private Producto $productos;
    private MovimientoStock $movimientos;
    private Venta $ventas;
    private TurnoCaja $caja;

    public function __construct()
    {
        $this->productos = new Producto();
        $this->movimientos = new MovimientoStock();
        $this->ventas = new Venta();
        $this->caja = new TurnoCaja();
    }

    public function Inicio(): void
    {
        $this->render('reporte/stock_bajo', [
            'productos' => $this->productos->listarStockBajo(),
            'pdfHref' => '?c=reporte&a=StockBajoPdf',
        ]);
    }

    public function StockBajoPdf(): void
    {
        Pdf::render('stock_bajo', [
            'productos' => $this->productos->listarStockBajo(),
        ], 'stock_bajo.pdf', 'landscape');
    }

    public function ValorInventario(): void
    {
        $productos = $this->productos->valorInventario();

        $this->render('reporte/valor_inventario', [
            'productos' => $productos,
            'totalCosto' => array_sum(array_column($productos, 'valor_costo')),
            'totalVenta' => array_sum(array_column($productos, 'valor_venta')),
            'pdfHref' => '?c=reporte&a=ValorInventarioPdf',
        ]);
    }

    public function ValorInventarioPdf(): void
    {
        $productos = $this->productos->valorInventario();

        Pdf::render('valor_inventario', [
            'productos' => $productos,
            'totalCosto' => array_sum(array_column($productos, 'valor_costo')),
            'totalVenta' => array_sum(array_column($productos, 'valor_venta')),
        ], 'valor_inventario.pdf', 'landscape');
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
            'pdfHref' => "?c=reporte&a=MovimientosPorFechaPdf&desde=$desde&hasta=$hasta&tipo=$tipo",
        ]);
    }

    public function MovimientosPorFechaPdf(): void
    {
        [$desde, $hasta] = $this->rangoFechas();
        $tipo = trim($_GET['tipo'] ?? '');

        Pdf::render('movimientos_fecha', [
            'movimientos' => $this->movimientos->listarPorFecha($desde, $hasta, $tipo ?: null),
            'desde' => $desde,
            'hasta' => $hasta,
            'tipo' => $tipo,
        ], 'movimientos_fecha.pdf', 'landscape');
    }

    public function ProductosMasMovidos(): void
    {
        [$desde, $hasta] = $this->rangoFechas();

        $this->render('reporte/productos_mas_movidos', [
            'productos' => $this->movimientos->productosMasMovidos($desde, $hasta, 10),
            'desde' => $desde,
            'hasta' => $hasta,
            'pdfHref' => "?c=reporte&a=ProductosMasMovidosPdf&desde=$desde&hasta=$hasta",
        ]);
    }

    public function ProductosMasMovidosPdf(): void
    {
        [$desde, $hasta] = $this->rangoFechas();

        Pdf::render('productos_mas_movidos', [
            'productos' => $this->movimientos->productosMasMovidos($desde, $hasta, 10),
            'desde' => $desde,
            'hasta' => $hasta,
        ], 'productos_mas_movidos.pdf');
    }

    public function VentasPorPeriodo(): void
    {
        [$desde, $hasta] = $this->rangoFechas();

        $this->render('reporte/ventas_periodo', [
            'ventas' => $this->ventas->listar(null, $desde, $hasta),
            'desde' => $desde,
            'hasta' => $hasta,
            'pdfHref' => "?c=reporte&a=VentasPorPeriodoPdf&desde=$desde&hasta=$hasta",
        ]);
    }

    public function VentasPorPeriodoPdf(): void
    {
        [$desde, $hasta] = $this->rangoFechas();

        Pdf::render('ventas_periodo', [
            'ventas' => $this->ventas->listar(null, $desde, $hasta),
            'desde' => $desde,
            'hasta' => $hasta,
        ], 'ventas_periodo.pdf', 'landscape');
    }

    public function CierresCaja(): void
    {
        $this->render('reporte/cierres_caja', [
            'turnos' => $this->caja->listar(),
            'pdfHref' => '?c=reporte&a=CierresCajaPdf',
        ]);
    }

    public function CierresCajaPdf(): void
    {
        Pdf::render('cierres_caja', [
            'turnos' => $this->caja->listar(),
        ], 'cierres_caja.pdf', 'landscape');
    }

    private function rangoFechas(): array
    {
        $desde = trim($_GET['desde'] ?? '') ?: date('Y-m-d', strtotime('-30 days'));
        $hasta = trim($_GET['hasta'] ?? '') ?: date('Y-m-d');
        return [$desde, $hasta];
    }
}
