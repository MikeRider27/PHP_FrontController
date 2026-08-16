<div class="no-print" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 15px;">
    <ul class="nav nav-tabs" style="margin-bottom: 0; flex: 1;">
        <li class="<?=$tabActiva === 'stock_bajo' ? 'active' : ''?>"><a href="?c=reporte"><i class="fa fa-exclamation-triangle"></i> Stock Bajo</a></li>
        <li class="<?=$tabActiva === 'valor_inventario' ? 'active' : ''?>"><a href="?c=reporte&a=ValorInventario"><i class="fa fa-dollar"></i> Valor de Inventario</a></li>
        <li class="<?=$tabActiva === 'movimientos_fecha' ? 'active' : ''?>"><a href="?c=reporte&a=MovimientosPorFecha"><i class="fa fa-calendar"></i> Movimientos por Fecha</a></li>
        <li class="<?=$tabActiva === 'productos_mas_movidos' ? 'active' : ''?>"><a href="?c=reporte&a=ProductosMasMovidos"><i class="fa fa-line-chart"></i> Productos más Movidos</a></li>
        <li class="<?=$tabActiva === 'ventas_periodo' ? 'active' : ''?>"><a href="?c=reporte&a=VentasPorPeriodo"><i class="fa fa-money"></i> Ventas por Período</a></li>
        <li class="<?=$tabActiva === 'cierres_caja' ? 'active' : ''?>"><a href="?c=reporte&a=CierresCaja"><i class="fa fa-calculator"></i> Cierres de Caja</a></li>
    </ul>
    <a class="btn btn-default" style="margin-left: 10px;" href="<?=$pdfHref?>" target="_blank">
        <i class="fa fa-file-pdf-o"></i> Descargar PDF
    </a>
</div>
