<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Movimientos de Stock
            <small>Entradas, salidas y ajustes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Movimientos de Stock</li>
        </ol>
    </section>

    <section class="content">
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Registrar Movimiento</h3>
                    </div>
                    <form method="post" action="?c=movimiento&a=Guardar">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Producto</label>
                                <select name="producto_id" class="form-control" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php foreach ($productos as $p): ?>
                                    <option value="<?=$p['producto_id']?>" <?=$productoId == $p['producto_id'] ? 'selected' : ''?>>
                                        <?=htmlspecialchars($p['producto_codigo'] . ' - ' . $p['producto_nombre'])?> (stock: <?=$p['producto_stock_actual']?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipo de Movimiento</label>
                                <select name="movimiento_tipo" class="form-control" required>
                                    <option value="ENTRADA">Entrada</option>
                                    <option value="SALIDA">Salida</option>
                                    <option value="AJUSTE">Ajuste (fija el stock absoluto)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cantidad</label>
                                <input type="number" min="0" name="movimiento_cantidad" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Motivo</label>
                                <textarea name="movimiento_motivo" class="form-control" placeholder="Ej: compra a proveedor, venta, inventario físico..."></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Registrar</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Historial (Kardex)
                            <?php if ($productoId): ?>
                            <small>— filtrado por producto <a href="?c=movimiento">(quitar filtro)</a></small>
                            <?php endif; ?>
                        </h3>
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
                                <tr><td colspan="8" class="text-center">Sin movimientos registrados</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
