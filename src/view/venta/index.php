<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Ventas
            <small>Historial de ventas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Ventas</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-9">
                <form method="get" class="form-inline">
                    <input type="hidden" name="c" value="venta">
                    <select name="estado" class="form-control" onchange="this.form.submit()">
                        <option value="" <?=$estado === '' ? 'selected' : ''?>>Todos los estados</option>
                        <option value="CONFIRMADA" <?=$estado === 'CONFIRMADA' ? 'selected' : ''?>>Confirmada</option>
                        <option value="ANULADA" <?=$estado === 'ANULADA' ? 'selected' : ''?>>Anulada</option>
                    </select>
                    <input type="date" name="desde" class="form-control" value="<?=htmlspecialchars($desde)?>">
                    <input type="date" name="hasta" class="form-control" value="<?=htmlspecialchars($hasta)?>">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Filtrar</button>
                </form>
            </div>
            <div class="col-xs-3 text-right">
                <a href="?c=venta&a=Nueva" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva Venta</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
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
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($ventas as $v): ?>
                                <tr>
                                    <td><?=htmlspecialchars($v['venta_numero'])?></td>
                                    <td><?=htmlspecialchars($v['cliente_razon_social'])?></td>
                                    <td><?=htmlspecialchars($v['venta_fecha'])?></td>
                                    <td><?=htmlspecialchars($v['venta_forma_pago'])?></td>
                                    <td class="text-center">
                                        <?php $badge = $v['venta_estado'] === 'CONFIRMADA' ? 'label-success' : 'label-default'; ?>
                                        <span class="label <?=$badge?>"><?=$v['venta_estado']?></span>
                                    </td>
                                    <td class="text-right"><?=number_format((float)$v['total'], 0, ',', '.')?></td>
                                    <td><?=htmlspecialchars($v['usuario_nick'])?></td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-flat" href="?c=venta&a=Ver&id=<?=$v['venta_id']?>">
                                            <i class="fa fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($ventas)): ?>
                                <tr><td colspan="8" class="text-center">Sin ventas</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
