<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Órdenes de Compra
            <small>Compras a proveedores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Órdenes de Compra</li>
        </ol>
    </section>

    <section class="content">
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-xs-6">
                <form method="get" class="form-inline">
                    <input type="hidden" name="c" value="ordencompra">
                    <select name="estado" class="form-control" onchange="this.form.submit()">
                        <option value="" <?=$estado === '' ? 'selected' : ''?>>Todos los estados</option>
                        <option value="PENDIENTE" <?=$estado === 'PENDIENTE' ? 'selected' : ''?>>Pendiente</option>
                        <option value="RECIBIDA" <?=$estado === 'RECIBIDA' ? 'selected' : ''?>>Recibida</option>
                        <option value="CANCELADA" <?=$estado === 'CANCELADA' ? 'selected' : ''?>>Cancelada</option>
                    </select>
                </form>
            </div>
            <div class="col-xs-6 text-right">
                <a href="?c=ordencompra&a=Nueva" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva Orden</a>
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
                                    <th>Proveedor</th>
                                    <th>Fecha</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-right">Total</th>
                                    <th>Creada por</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($ordenes as $o): ?>
                                <tr>
                                    <td>#<?=$o['orden_id']?></td>
                                    <td><?=htmlspecialchars($o['proveedor_razon_social'])?></td>
                                    <td><?=htmlspecialchars($o['orden_fecha'])?></td>
                                    <td class="text-center">
                                        <?php
                                        $badge = ['PENDIENTE' => 'label-warning', 'RECIBIDA' => 'label-success', 'CANCELADA' => 'label-default'][$o['orden_estado']] ?? 'label-default';
                                        ?>
                                        <span class="label <?=$badge?>"><?=$o['orden_estado']?></span>
                                    </td>
                                    <td class="text-right"><?=number_format((float)$o['total'], 0, ',', '.')?></td>
                                    <td><?=htmlspecialchars($o['usuario_nick'])?></td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-flat" href="?c=ordencompra&a=Ver&id=<?=$o['orden_id']?>">
                                            <i class="fa fa-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($ordenes)): ?>
                                <tr><td colspan="7" class="text-center">Sin órdenes de compra</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
