<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Productos
            <small>Gestión de productos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Productos</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <form method="get" class="input-group">
                    <input type="hidden" name="c" value="producto">
                    <input type="text" name="q" class="form-control" placeholder="Buscar por nombre o código" value="<?=htmlspecialchars($q)?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </form>
            </div>
            <?php if ($esAdmin): ?>
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_producto" onclick="nuevoProducto()">
                    <i class="fa fa-plus"></i> Nuevo Producto
                </button>
            </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Proveedor</th>
                                    <th class="text-right">Costo</th>
                                    <th class="text-right">Venta</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($productos as $p): ?>
                                <tr>
                                    <td><?=htmlspecialchars($p['producto_codigo'])?></td>
                                    <td><?=htmlspecialchars($p['producto_nombre'])?></td>
                                    <td><?=htmlspecialchars($p['categoria_nombre'])?></td>
                                    <td><?=htmlspecialchars($p['proveedor_razon_social'] ?? '-')?></td>
                                    <td class="text-right"><?=number_format((float)$p['producto_precio_costo'], 0, ',', '.')?></td>
                                    <td class="text-right"><?=number_format((float)$p['producto_precio_venta'], 0, ',', '.')?></td>
                                    <td class="text-center">
                                        <span class="label <?=$p['producto_stock_actual'] <= $p['producto_stock_minimo'] ? 'label-danger' : 'label-success'?>">
                                            <?=$p['producto_stock_actual']?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-flat" href="?c=movimiento&producto_id=<?=$p['producto_id']?>" title="Movimientos">
                                            <i class="fa fa-exchange"></i>
                                        </a>
                                        <?php if ($esAdmin): ?>
                                        <button type="button" class="btn btn-info btn-flat"
                                                data-toggle="modal" data-target="#modal_producto"
                                                onclick='editarProducto(<?=json_encode($p)?>)'>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <a class="btn btn-warning btn-flat" href="?c=producto&a=Eliminar&id=<?=$p['producto_id']?>"
                                           onclick="return confirm('¿Desactivar este producto?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($productos)): ?>
                                <tr><td colspan="8" class="text-center">Sin resultados</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php if ($esAdmin): ?>
<div class="modal fade" id="modal_producto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="?c=producto&a=Guardar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_producto_titulo">Nuevo Producto</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="producto_id" id="producto_id" value="0">
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" name="producto_codigo" id="producto_codigo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="producto_nombre" id="producto_nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="producto_descripcion" id="producto_descripcion" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-control" required>
                            <?php foreach ($categorias as $c): ?>
                            <option value="<?=$c['categoria_id']?>"><?=htmlspecialchars($c['categoria_nombre'])?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Proveedor</label>
                        <select name="proveedor_id" id="proveedor_id" class="form-control">
                            <option value="">-- Sin proveedor --</option>
                            <?php foreach ($proveedores as $pr): ?>
                            <option value="<?=$pr['proveedor_id']?>"><?=htmlspecialchars($pr['proveedor_razon_social'])?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Precio Costo</label>
                                <input type="number" step="0.01" min="0" name="producto_precio_costo" id="producto_precio_costo" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>Precio Venta</label>
                                <input type="number" step="0.01" min="0" name="producto_precio_venta" id="producto_precio_venta" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Stock Mínimo</label>
                        <input type="number" min="0" name="producto_stock_minimo" id="producto_stock_minimo" class="form-control" required>
                    </div>
                    <p class="text-muted" id="producto_stock_actual_info"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function nuevoProducto() {
    document.getElementById('modal_producto_titulo').textContent = 'Nuevo Producto';
    document.getElementById('producto_id').value = 0;
    document.getElementById('producto_codigo').value = '';
    document.getElementById('producto_nombre').value = '';
    document.getElementById('producto_descripcion').value = '';
    document.getElementById('producto_precio_costo').value = '0';
    document.getElementById('producto_precio_venta').value = '0';
    document.getElementById('producto_stock_minimo').value = '0';
    document.getElementById('producto_stock_actual_info').textContent = 'El stock se administra desde Movimientos de Stock.';
}
function editarProducto(p) {
    document.getElementById('modal_producto_titulo').textContent = 'Modificar Producto';
    document.getElementById('producto_id').value = p.producto_id;
    document.getElementById('producto_codigo').value = p.producto_codigo;
    document.getElementById('producto_nombre').value = p.producto_nombre;
    document.getElementById('producto_descripcion').value = p.producto_descripcion || '';
    document.getElementById('categoria_id').value = p.categoria_id;
    document.getElementById('proveedor_id').value = p.proveedor_id || '';
    document.getElementById('producto_precio_costo').value = p.producto_precio_costo;
    document.getElementById('producto_precio_venta').value = p.producto_precio_venta;
    document.getElementById('producto_stock_minimo').value = p.producto_stock_minimo;
    document.getElementById('producto_stock_actual_info').textContent = 'Stock actual: ' + p.producto_stock_actual + ' (se administra desde Movimientos de Stock).';
}
</script>
<?php endif; ?>
