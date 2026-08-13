<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Reporte de Stock Bajo
            <small>Productos que llegaron o están por debajo del stock mínimo</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Stock Bajo</li>
        </ol>
    </section>

    <section class="content">
        <?php $tabActiva = 'stock_bajo'; require BASE_PATH . '/view/reporte/_tabs.php'; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=count($productos)?> producto(s) en alerta</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th class="text-center">Stock Actual</th>
                                    <th class="text-center">Stock Mínimo</th>
                                    <th class="text-center no-print">Acciones</th>
                                </tr>
                                <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td><?=htmlspecialchars($p['producto_codigo'])?></td>
                                    <td><?=htmlspecialchars($p['producto_nombre'])?></td>
                                    <td><?=htmlspecialchars($p['categoria_nombre'])?></td>
                                    <td class="text-center"><span class="label label-danger"><?=$p['producto_stock_actual']?></span></td>
                                    <td class="text-center"><?=$p['producto_stock_minimo']?></td>
                                    <td class="text-center no-print">
                                        <a class="btn btn-primary btn-flat" href="?c=movimiento&producto_id=<?=$p['producto_id']?>">
                                            <i class="fa fa-exchange"></i> Registrar entrada
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($productos)): ?>
                                <tr><td colspan="6" class="text-center">No hay productos con stock bajo</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
