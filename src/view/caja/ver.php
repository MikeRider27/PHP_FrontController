<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Turno de Caja #<?=$turno['turno_id']?>
            <small><?=htmlspecialchars($turno['turno_estado'])?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="?c=caja">Caja</a></li>
            <li><a href="?c=caja&a=Historial">Historial</a></li>
            <li class="active">#<?=$turno['turno_id']?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos del Turno</h3>
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Estado</dt>
                            <dd><?=htmlspecialchars($turno['turno_estado'])?></dd>
                            <dt>Abierto por</dt>
                            <dd><?=htmlspecialchars($turno['usuario_apertura_nick'])?> - <?=htmlspecialchars($turno['turno_fecha_apertura'])?></dd>
                            <?php if ($turno['turno_estado'] === 'CERRADO'): ?>
                            <dt>Cerrado por</dt>
                            <dd><?=htmlspecialchars($turno['usuario_cierre_nick'])?> - <?=htmlspecialchars($turno['turno_fecha_cierre'])?></dd>
                            <?php endif; ?>
                            <dt>Monto Inicial</dt>
                            <dd><?=number_format((float)$turno['turno_monto_inicial'], 0, ',', '.')?></dd>
                            <?php if ($turno['turno_monto_sistema'] !== null): ?>
                            <dt>Monto Sistema (esperado)</dt>
                            <dd><?=number_format((float)$turno['turno_monto_sistema'], 0, ',', '.')?></dd>
                            <dt>Monto Declarado</dt>
                            <dd><?=number_format((float)$turno['turno_monto_declarado'], 0, ',', '.')?></dd>
                            <dt>Diferencia</dt>
                            <dd>
                                <span class="<?=abs((float)$turno['turno_diferencia']) < 0.01 ? 'text-green' : 'text-red'?>">
                                    <?=number_format((float)$turno['turno_diferencia'], 0, ',', '.')?>
                                </span>
                            </dd>
                            <?php endif; ?>
                            <?php if (!empty($turno['turno_observacion'])): ?>
                            <dt>Observación</dt>
                            <dd><?=htmlspecialchars($turno['turno_observacion'])?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Movimientos Manuales</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Tipo</th>
                                    <th class="text-right">Monto</th>
                                    <th>Motivo</th>
                                </tr>
                                <?php foreach ($turno['movimientos'] as $m): ?>
                                <tr>
                                    <td><?=htmlspecialchars($m['movimiento_caja_tipo'])?></td>
                                    <td class="text-right"><?=number_format((float)$m['movimiento_caja_monto'], 0, ',', '.')?></td>
                                    <td><?=htmlspecialchars($m['movimiento_caja_motivo'])?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($turno['movimientos'])): ?>
                                <tr><td colspan="3" class="text-center">Sin movimientos</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
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
    </section>
</div>
