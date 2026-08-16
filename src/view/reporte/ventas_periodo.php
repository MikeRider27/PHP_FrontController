<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Ventas por Período
            <small>Historial de ventas filtrado por rango de fechas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Reportes</li>
        </ol>
    </section>

    <section class="content">
        <?php $tabActiva = 'ventas_periodo'; require BASE_PATH . '/view/reporte/_tabs.php'; ?>

        <p class="visible-print-block">
            <strong>Rango:</strong> <?=htmlspecialchars($desde)?> a <?=htmlspecialchars($hasta)?>
        </p>

        <div class="row no-print">
            <div class="col-md-12">
                <form method="get" class="form-inline" style="margin-bottom: 15px;">
                    <input type="hidden" name="c" value="reporte">
                    <input type="hidden" name="a" value="VentasPorPeriodo">
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
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=count($ventas)?> venta(s)</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Número</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Forma de Pago</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-right">Total</th>
                                    <th>Vendida por</th>
                                </tr>
                                <?php foreach ($ventas as $v): ?>
                                <tr>
                                    <td><a href="?c=venta&a=Ver&id=<?=$v['venta_id']?>"><?=htmlspecialchars($v['venta_numero'])?></a></td>
                                    <td><?=htmlspecialchars($v['cliente_razon_social'])?></td>
                                    <td><?=htmlspecialchars($v['venta_fecha'])?></td>
                                    <td><?=htmlspecialchars($v['venta_forma_pago'])?></td>
                                    <td class="text-center">
                                        <?php $badge = $v['venta_estado'] === 'CONFIRMADA' ? 'label-success' : 'label-default'; ?>
                                        <span class="label <?=$badge?>"><?=$v['venta_estado']?></span>
                                    </td>
                                    <td class="text-right"><?=number_format((float)$v['total'], 0, ',', '.')?></td>
                                    <td><?=htmlspecialchars($v['usuario_nick'])?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($ventas)): ?>
                                <tr><td colspan="7" class="text-center">Sin ventas en el rango seleccionado</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
