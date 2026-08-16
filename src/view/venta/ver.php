<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Venta <?=htmlspecialchars($venta['venta_numero'])?>
            <small><?=htmlspecialchars($venta['cliente_razon_social'])?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="?c=venta">Ventas</a></li>
            <li class="active"><?=htmlspecialchars($venta['venta_numero'])?></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="?c=venta&a=FacturaPdf&id=<?=$venta['venta_id']?>" target="_blank" class="btn btn-primary">
                    <i class="fa fa-print"></i> Imprimir Factura
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos de la Venta</h3>
                    </div>
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Cliente</dt>
                            <dd><?=htmlspecialchars($venta['cliente_razon_social'])?><?=$venta['cliente_documento'] ? ' - ' . htmlspecialchars($venta['cliente_documento']) : ''?></dd>
                            <dt>Estado</dt>
                            <dd>
                                <?php $badge = $venta['venta_estado'] === 'CONFIRMADA' ? 'label-success' : 'label-default'; ?>
                                <span class="label <?=$badge?>"><?=$venta['venta_estado']?></span>
                            </dd>
                            <dt>Forma de Pago</dt>
                            <dd><?=htmlspecialchars($venta['venta_forma_pago'])?></dd>
                            <dt>Fecha</dt>
                            <dd><?=htmlspecialchars($venta['venta_fecha'])?></dd>
                            <?php if ($venta['venta_estado'] === 'ANULADA'): ?>
                            <dt>Fecha de anulación</dt>
                            <dd><?=htmlspecialchars($venta['venta_fecha_anulacion'])?></dd>
                            <dt>Motivo de anulación</dt>
                            <dd><?=htmlspecialchars($venta['venta_motivo_anulacion'])?></dd>
                            <?php endif; ?>
                            <dt>Vendida por</dt>
                            <dd><?=htmlspecialchars($venta['usuario_nick'])?></dd>
                        </dl>

                        <?php if ($venta['venta_estado'] === 'CONFIRMADA'): ?>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_anular">
                            <i class="fa fa-times"></i> Anular Venta
                        </button>
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
                                    <th class="text-right">Precio Unit.</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                                <?php foreach ($venta['detalle'] as $d): ?>
                                <tr>
                                    <td><?=htmlspecialchars($d['producto_codigo'])?></td>
                                    <td><?=htmlspecialchars($d['producto_nombre'])?></td>
                                    <td class="text-right"><?=$d['detalle_venta_cantidad']?></td>
                                    <td class="text-right"><?=number_format((float)$d['detalle_venta_precio_unitario'], 0, ',', '.')?></td>
                                    <td class="text-right"><?=number_format((float)$d['subtotal'], 0, ',', '.')?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <th colspan="4" class="text-right">Total</th>
                                    <th class="text-right"><?=number_format((float)$venta['total'], 0, ',', '.')?></th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_anular" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="?c=venta&a=Anular">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Anular Venta <?=htmlspecialchars($venta['venta_numero'])?></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="venta_id" value="<?=$venta['venta_id']?>">
                    <p>Esto revertirá el stock de todas las líneas de esta venta.</p>
                    <div class="form-group">
                        <label>Motivo</label>
                        <textarea name="motivo" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Anular</button>
                </div>
            </div>
        </form>
    </div>
</div>
