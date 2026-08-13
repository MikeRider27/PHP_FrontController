<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Movimientos por Fecha
            <small>Kardex filtrado por rango de fechas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>

    <section class="content">
        <?php $tabActiva = 'movimientos_fecha'; require BASE_PATH . '/view/reporte/_tabs.php'; ?>

        <p class="visible-print-block">
            <strong>Rango:</strong> <?=htmlspecialchars($desde)?> a <?=htmlspecialchars($hasta)?>
            <?php if ($tipo): ?> — <strong>Tipo:</strong> <?=htmlspecialchars($tipo)?><?php endif; ?>
        </p>

        <div class="row no-print">
            <div class="col-md-12">
                <form method="get" class="form-inline" style="margin-bottom: 15px;">
                    <input type="hidden" name="c" value="reporte">
                    <input type="hidden" name="a" value="MovimientosPorFecha">
                    <div class="form-group">
                        <label>Desde</label>
                        <input type="date" name="desde" class="form-control" value="<?=htmlspecialchars($desde)?>">
                    </div>
                    <div class="form-group">
                        <label>Hasta</label>
                        <input type="date" name="hasta" class="form-control" value="<?=htmlspecialchars($hasta)?>">
                    </div>
                    <div class="form-group">
                        <label>Tipo</label>
                        <select name="tipo" class="form-control">
                            <option value="" <?=$tipo === '' ? 'selected' : ''?>>Todos</option>
                            <option value="ENTRADA" <?=$tipo === 'ENTRADA' ? 'selected' : ''?>>Entrada</option>
                            <option value="SALIDA" <?=$tipo === 'SALIDA' ? 'selected' : ''?>>Salida</option>
                            <option value="AJUSTE" <?=$tipo === 'AJUSTE' ? 'selected' : ''?>>Ajuste</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=count($movimientos)?> movimiento(s)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Stock Ant.</th>
                                    <th class="text-right">Stock Nuevo</th>
                                    <th>Motivo</th>
                                    <th>Usuario</th>
                                </tr>
                                <?php foreach ($movimientos as $m): ?>
                                <tr>
                                    <td><?=htmlspecialchars($m['movimiento_fecha'])?></td>
                                    <td><a href="?c=movimiento&producto_id=<?=$m['producto_id']?>"><?=htmlspecialchars($m['producto_nombre'])?></a></td>
                                    <td class="text-center">
                                        <?php
                                        $badge = ['ENTRADA' => 'label-success', 'SALIDA' => 'label-danger', 'AJUSTE' => 'label-warning'][$m['movimiento_tipo']] ?? 'label-default';
                                        ?>
                                        <span class="label <?=$badge?>"><?=$m['movimiento_tipo']?></span>
                                    </td>
                                    <td class="text-right"><?=$m['movimiento_cantidad']?></td>
                                    <td class="text-right"><?=$m['movimiento_stock_anterior']?></td>
                                    <td class="text-right"><?=$m['movimiento_stock_nuevo']?></td>
                                    <td><?=htmlspecialchars($m['movimiento_motivo'] ?? '')?></td>
                                    <td><?=htmlspecialchars($m['usuario_nick'])?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($movimientos)): ?>
                                <tr><td colspan="8" class="text-center">Sin movimientos en el rango seleccionado</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
