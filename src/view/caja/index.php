<?php
if ($turno) {
    $ventasEfectivo = array_filter($turno['ventas'], function ($v) {
        return $v['venta_forma_pago'] === 'EFECTIVO' && $v['venta_estado'] === 'CONFIRMADA';
    });
    $totalVentasEfectivo = array_sum(array_column($ventasEfectivo, 'total'));
    $totalVentas = array_sum(array_column(array_filter($turno['ventas'], fn($v) => $v['venta_estado'] === 'CONFIRMADA'), 'total'));

    $ingresos = array_filter($turno['movimientos'], fn($m) => $m['movimiento_caja_tipo'] === 'INGRESO');
    $egresos = array_filter($turno['movimientos'], fn($m) => $m['movimiento_caja_tipo'] === 'EGRESO');
    $totalIngresos = array_sum(array_column($ingresos, 'movimiento_caja_monto'));
    $totalEgresos = array_sum(array_column($egresos, 'movimiento_caja_monto'));

    $esperado = (float)$turno['turno_monto_inicial'] + $totalVentasEfectivo + $totalIngresos - $totalEgresos;
}
?>
<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Caja
            <small>Apertura y cierre de turno</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Caja</li>
        </ol>
    </section>

    <section class="content">
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xs-12 text-right">
                <a href="?c=caja&a=Historial" class="btn btn-default"><i class="fa fa-history"></i> Historial de Cierres</a>
            </div>
        </div>
        <br>

        <?php if (!$turno): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">No hay una caja abierta</h3>
                    </div>
                    <form method="post" action="?c=caja&a=Abrir">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Monto Inicial</label>
                                <input type="number" name="monto_inicial" class="form-control" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-unlock"></i> Abrir Caja</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="row">
            <div class="col-md-6">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Turno #<?=$turno['turno_id']?> - Abierto</h3>
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Abierto por</dt>
                            <dd><?=htmlspecialchars($turno['usuario_apertura_nick'])?></dd>
                            <dt>Fecha apertura</dt>
                            <dd><?=htmlspecialchars($turno['turno_fecha_apertura'])?></dd>
                            <dt>Monto inicial</dt>
                            <dd><?=number_format((float)$turno['turno_monto_inicial'], 0, ',', '.')?></dd>
                            <dt>Ventas totales</dt>
                            <dd><?=number_format((float)$totalVentas, 0, ',', '.')?> (<?=count($turno['ventas'])?> ventas)</dd>
                            <dt>Ventas en efectivo</dt>
                            <dd><?=number_format((float)$totalVentasEfectivo, 0, ',', '.')?></dd>
                            <dt>Ingresos manuales</dt>
                            <dd><?=number_format((float)$totalIngresos, 0, ',', '.')?></dd>
                            <dt>Egresos manuales</dt>
                            <dd><?=number_format((float)$totalEgresos, 0, ',', '.')?></dd>
                            <dt>Efectivo esperado</dt>
                            <dd><strong><?=number_format($esperado, 0, ',', '.')?></strong></dd>
                        </dl>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Movimiento Manual</h3>
                    </div>
                    <form method="post" action="?c=caja&a=MovimientoNuevo">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Tipo</label>
                                <select name="tipo" class="form-control" required>
                                    <option value="INGRESO">Ingreso</option>
                                    <option value="EGRESO">Egreso</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Monto</label>
                                <input type="number" name="monto" class="form-control" step="0.01" min="0.01" required>
                            </div>
                            <div class="form-group">
                                <label>Motivo</label>
                                <input type="text" name="motivo" class="form-control" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-default"><i class="fa fa-plus"></i> Registrar</button>
                        </div>
                    </form>
                </div>

                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cerrar Caja</h3>
                    </div>
                    <form method="post" action="?c=caja&a=Cerrar" onsubmit="return confirm('¿Cerrar la caja? Esta acción no se puede deshacer.');">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Monto contado (efectivo)</label>
                                <input type="number" name="monto_declarado" class="form-control" step="0.01" min="0" required>
                            </div>
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea name="observacion" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-warning"><i class="fa fa-lock"></i> Cerrar Caja</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Movimientos del Turno</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Tipo</th>
                                    <th class="text-right">Monto</th>
                                    <th>Motivo</th>
                                    <th>Usuario</th>
                                    <th>Fecha</th>
                                </tr>
                                <?php foreach ($turno['movimientos'] as $m): ?>
                                <tr>
                                    <td><?=htmlspecialchars($m['movimiento_caja_tipo'])?></td>
                                    <td class="text-right"><?=number_format((float)$m['movimiento_caja_monto'], 0, ',', '.')?></td>
                                    <td><?=htmlspecialchars($m['movimiento_caja_motivo'])?></td>
                                    <td><?=htmlspecialchars($m['usuario_nick'])?></td>
                                    <td><?=htmlspecialchars($m['movimiento_caja_fecha'])?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($turno['movimientos'])): ?>
                                <tr><td colspan="5" class="text-center">Sin movimientos manuales</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ventas del Turno</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Número</th>
                                    <th>Forma de Pago</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                <?php foreach ($turno['ventas'] as $v): ?>
                                <tr>
                                    <td><a href="?c=venta&a=Ver&id=<?=$v['venta_id']?>"><?=htmlspecialchars($v['venta_numero'])?></a></td>
                                    <td><?=htmlspecialchars($v['venta_forma_pago'])?></td>
                                    <td class="text-center"><?=htmlspecialchars($v['venta_estado'])?></td>
                                    <td class="text-right"><?=number_format((float)$v['total'], 0, ',', '.')?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($turno['ventas'])): ?>
                                <tr><td colspan="4" class="text-center">Sin ventas en este turno</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>
