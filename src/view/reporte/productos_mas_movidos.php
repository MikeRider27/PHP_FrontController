<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Productos más Movidos
            <small>Ranking por cantidad movida en el periodo</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>

    <section class="content">
        <?php $tabActiva = 'productos_mas_movidos'; require BASE_PATH . '/view/reporte/_tabs.php'; ?>

        <p class="visible-print-block">
            <strong>Rango:</strong> <?=htmlspecialchars($desde)?> a <?=htmlspecialchars($hasta)?>
        </p>

        <div class="row no-print">
            <div class="col-md-12">
                <form method="get" class="form-inline" style="margin-bottom: 15px;">
                    <input type="hidden" name="c" value="reporte">
                    <input type="hidden" name="a" value="ProductosMasMovidos">
                    <div class="form-group">
                        <label>Desde</label>
                        <input type="date" name="desde" class="form-control" value="<?=htmlspecialchars($desde)?>">
                    </div>
                    <div class="form-group">
                        <label>Hasta</label>
                        <input type="date" name="hasta" class="form-control" value="<?=htmlspecialchars($hasta)?>">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th class="text-right">Cantidad Movida</th>
                                    <th class="text-right">Cantidad de Movimientos</th>
                                </tr>
                                <?php $pos = 1; foreach ($productos as $p): ?>
                                <tr>
                                    <td><?=$pos++?></td>
                                    <td><?=htmlspecialchars($p['producto_codigo'])?></td>
                                    <td><a href="?c=movimiento&producto_id=<?=$p['producto_id']?>"><?=htmlspecialchars($p['producto_nombre'])?></a></td>
                                    <td class="text-right"><span class="label label-primary"><?=$p['total_movido']?></span></td>
                                    <td class="text-right"><?=$p['cantidad_movimientos']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($productos)): ?>
                                <tr><td colspan="5" class="text-center">Sin movimientos en el rango seleccionado</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
