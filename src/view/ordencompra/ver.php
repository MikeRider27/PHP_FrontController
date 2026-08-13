<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Orden de Compra #<?=$orden['orden_id']?>
            <small><?=htmlspecialchars($orden['proveedor_razon_social'])?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="?c=ordencompra">Órdenes de Compra</a></li>
            <li class="active">#<?=$orden['orden_id']?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos de la Orden</h3>
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Proveedor</dt>
                            <dd><?=htmlspecialchars($orden['proveedor_razon_social'])?></dd>
                            <dt>Estado</dt>
                            <dd>
                                <?php
                                $badge = ['PENDIENTE' => 'label-warning', 'RECIBIDA' => 'label-success', 'CANCELADA' => 'label-default'][$orden['orden_estado']] ?? 'label-default';
                                ?>
                                <span class="label <?=$badge?>"><?=$orden['orden_estado']?></span>
                            </dd>
                            <dt>Fecha de creación</dt>
                            <dd><?=htmlspecialchars($orden['orden_fecha'])?></dd>
                            <?php if ($orden['orden_fecha_recepcion']): ?>
                            <dt>Fecha de recepción</dt>
                            <dd><?=htmlspecialchars($orden['orden_fecha_recepcion'])?></dd>
                            <?php endif; ?>
                            <dt>Creada por</dt>
                            <dd><?=htmlspecialchars($orden['usuario_nick'])?></dd>
                        </dl>

                        <?php if ($orden['orden_estado'] === 'PENDIENTE'): ?>
                        <a class="btn btn-success" href="?c=ordencompra&a=Recibir&id=<?=$orden['orden_id']?>"
                           onclick="return confirm('¿Marcar como recibida? Esto generará las entradas de stock correspondientes.');">
                            <i class="fa fa-check"></i> Marcar como Recibida
                        </a>
                        <a class="btn btn-warning" href="?c=ordencompra&a=Cancelar&id=<?=$orden['orden_id']?>"
                           onclick="return confirm('¿Cancelar esta orden?');">
                            <i class="fa fa-times"></i> Cancelar
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Líneas</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Código</th>
                                    <th>Producto</th>
                                    <th class="text-right">Cantidad</th>
                                    <th class="text-right">Costo Unit.</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                <?php foreach ($orden['detalle'] as $d): ?>
                                <tr>
                                    <td><?=htmlspecialchars($d['producto_codigo'])?></td>
                                    <td><?=htmlspecialchars($d['producto_nombre'])?></td>
                                    <td class="text-right"><?=$d['detalle_cantidad']?></td>
                                    <td class="text-right"><?=number_format((float)$d['detalle_precio_costo_unitario'], 2)?></td>
                                    <td class="text-right"><?=number_format((float)$d['subtotal'], 2)?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th class="text-right"><?=number_format((float)$orden['total'], 2)?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
