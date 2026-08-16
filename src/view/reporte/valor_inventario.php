<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Valor de Inventario
            <small>Capital inmovilizado en stock, a precio de costo y de venta</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>

    <section class="content">
        <?php $tabActiva = 'valor_inventario'; require BASE_PATH . '/view/reporte/_tabs.php'; ?>

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?=number_format($totalCosto, 0, ',', '.')?></h3>
                        <p>Valor total a costo</p>
                    </div>
                    <div class="icon"><i class="fa fa-cubes"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?=number_format($totalVenta, 0, ',', '.')?></h3>
                        <p>Valor total a venta</p>
                    </div>
                    <div class="icon"><i class="fa fa-money"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-right">Costo Unit.</th>
                                    <th class="text-right">Venta Unit.</th>
                                    <th class="text-right">Valor Costo</th>
                                    <th class="text-right">Valor Venta</th>
                                </tr>
                                <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td><?=htmlspecialchars($p['producto_codigo'])?></td>
                                    <td><?=htmlspecialchars($p['producto_nombre'])?></td>
                                    <td><?=htmlspecialchars($p['categoria_nombre'])?></td>
                                    <td class="text-center"><?=$p['producto_stock_actual']?></td>
                                    <td class="text-right"><?=number_format((float)$p['producto_precio_costo'], 0, ',', '.')?></td>
                                    <td class="text-right"><?=number_format((float)$p['producto_precio_venta'], 0, ',', '.')?></td>
                                    <td class="text-right"><?=number_format((float)$p['valor_costo'], 0, ',', '.')?></td>
                                    <td class="text-right"><?=number_format((float)$p['valor_venta'], 0, ',', '.')?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($productos)): ?>
                                <tr><td colspan="8" class="text-center">Sin productos</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
