<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Panel de Control
            <small>Sistema de Inventario</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Inicio</li>
        </ol>
    </section>

    <section class="content">
        <?php if (!empty($error)): ?>
        <div class="alert alert-warning"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?=$totalProductos?></h3>
                        <p>Productos activos</p>
                    </div>
                    <div class="icon"><i class="fa fa-archive"></i></div>
                    <a href="?c=producto" class="small-box-footer">Ver productos <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?=count($stockBajo)?></h3>
                        <p>Productos con stock bajo</p>
                    </div>
                    <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                    <a href="?c=reporte" class="small-box-footer">Ver reporte <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <?php if (!empty($stockBajo)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Productos con stock bajo</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th class="text-center">Stock actual</th>
                                    <th class="text-center">Stock mínimo</th>
                                </tr>
                                <?php foreach ($stockBajo as $p): ?>
                                <tr>
                                    <td><?=htmlspecialchars($p['producto_codigo'])?></td>
                                    <td><?=htmlspecialchars($p['producto_nombre'])?></td>
                                    <td><?=htmlspecialchars($p['categoria_nombre'])?></td>
                                    <td class="text-center"><span class="label label-danger"><?=$p['producto_stock_actual']?></span></td>
                                    <td class="text-center"><?=$p['producto_stock_minimo']?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>
