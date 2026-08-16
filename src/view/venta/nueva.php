<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Nueva Venta
            <small>Registrar una venta</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="?c=venta">Ventas</a></li>
            <li class="active">Nueva</li>
        </ol>
    </section>

    <section class="content">
        <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
        <?php endif; ?>

        <form method="post" action="?c=venta&a=Guardar">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cliente</h3>
                        </div>
                        <div class="box-body">
                            <select name="cliente_id" class="form-control">
                                <option value="">Consumidor Final</option>
                                <?php foreach ($clientes as $c): ?>
                                <option value="<?=$c['cliente_id']?>">
                                    <?=htmlspecialchars($c['cliente_razon_social'])?><?=$c['cliente_documento'] ? ' - ' . htmlspecialchars($c['cliente_documento']) : ''?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Forma de Pago</h3>
                        </div>
                        <div class="box-body">
                            <select name="forma_pago" class="form-control" required>
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="TARJETA">Tarjeta</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Líneas de Productos</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-condensed" id="tabla_lineas">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th style="width: 100px;">Stock</th>
                                        <th style="width: 120px;">Cantidad</th>
                                        <th style="width: 150px;">Precio Unit.</th>
                                        <th style="width: 40px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="lineas_body"></tbody>
                            </table>
                            <button type="button" class="btn btn-default" onclick="agregarLinea()">
                                <i class="fa fa-plus"></i> Agregar línea
                            </button>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Registrar Venta</button>
                            <a href="?c=venta" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<script>
var PRODUCTOS = <?=json_encode($productos)?>;

function opcionesProducto() {
    var html = '<option value="">-- Seleccionar --</option>';
    PRODUCTOS.forEach(function (p) {
        html += '<option value="' + p.producto_id + '" data-precio="' + p.producto_precio_venta + '" data-stock="' + p.producto_stock_actual + '">' +
            p.producto_codigo + ' - ' + p.producto_nombre + '</option>';
    });
    return html;
}

function productoSeleccionado(select) {
    var tr = select.closest('tr');
    var opcion = select.options[select.selectedIndex];
    var precio = opcion.getAttribute('data-precio') || 0;
    var stock = opcion.getAttribute('data-stock') || 0;
    tr.querySelector('.precio_unitario').value = precio;
    tr.querySelector('.stock_disponible').textContent = stock;
}

function agregarLinea() {
    var tr = document.createElement('tr');
    tr.innerHTML =
        '<td><select name="producto_id[]" class="form-control" required onchange="productoSeleccionado(this)">' + opcionesProducto() + '</select></td>' +
        '<td class="stock_disponible text-center">-</td>' +
        '<td><input type="number" name="cantidad[]" class="form-control" min="1" required></td>' +
        '<td><input type="number" name="precio[]" class="form-control precio_unitario" step="0.01" min="0" required></td>' +
        '<td><button type="button" class="btn btn-danger btn-flat" onclick="this.closest(\'tr\').remove()"><i class="fa fa-trash"></i></button></td>';
    document.getElementById('lineas_body').appendChild(tr);
}

agregarLinea();
</script>
