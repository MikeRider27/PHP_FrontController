<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Historial de Caja
            <small>Turnos abiertos y cerrados</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="?c=caja">Caja</a></li>
            <li class="active">Historial</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Estado</th>
                                    <th>Apertura</th>
                                    <th>Cierre</th>
                                    <th class="text-right">Monto Inicial</th>
                                    <th class="text-right">Monto Declarado</th>
                                    <th class="text-right">Diferencia</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($turnos as $t): ?>
                                <tr>
                                    <td>#<?=$t['turno_id']?></td>
                                    <td class="text-center">
                                        <?php $badge = $t['turno_estado'] === 'ABIERTO' ? 'label-success' : 'label-default'; ?>
                                        <span class="label <?=$badge?>"><?=$t['turno_estado']?></span>
                                    </td>
                                    <td><?=htmlspecialchars($t['turno_fecha_apertura'])?> (<?=htmlspecialchars($t['usuario_apertura_nick'])?>)</td>
                                    <td><?=$t['turno_fecha_cierre'] ? htmlspecialchars($t['turno_fecha_cierre']) . ' (' . htmlspecialchars($t['usuario_cierre_nick']) . ')' : '-'?></td>
                                    <td class="text-right"><?=number_format((float)$t['turno_monto_inicial'], 0, ',', '.')?></td>
                                    <td class="text-right"><?=$t['turno_monto_declarado'] !== null ? number_format((float)$t['turno_monto_declarado'], 0, ',', '.') : '-'?></td>
                                    <td class="text-right">
                                        <?php if ($t['turno_diferencia'] !== null): ?>
                                        <span class="<?=abs((float)$t['turno_diferencia']) < 0.01 ? 'text-green' : 'text-red'?>">
                                            <?=number_format((float)$t['turno_diferencia'], 0, ',', '.')?>
                                        </span>
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-flat" href="?c=caja&a=Ver&id=<?=$t['turno_id']?>">
                                            <i class="fa fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($turnos)): ?>
                                <tr><td colspan="8" class="text-center">Sin turnos registrados</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
