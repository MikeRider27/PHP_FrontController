<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Nueva Orden de Compra
            <small>Compras a proveedores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="?c=ordencompra">Órdenes de Compra</a></li>
            <li class="active">Nueva</li>
        </ol>
    </section>

    <section class="content">
        <form method="post" action="?c=ordencompra&a=Guardar">
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Proveedor</h3>
                        </div>
                        <div class="box-body">
                            <select name="proveedor_id" class="form-control" required>
                                <option value="">-- Seleccionar --</option>
                                <?php foreach ($proveedores as $pr): ?>
                                <option value="<?=$pr['proveedor_id']?>"><?=htmlspecialchars($pr['proveedor_razon_social'])?></option>
                                <?php endforeach; ?>
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
                                        <th style="width: 120px;">Cantidad</th>
                                        <th style="width: 150px;">Costo Unit.</th>
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
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Orden</button>
                            <a href="?c=ordencompra" class="btn btn-default">Cancelar</a>
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
        html += '<option value="' + p.producto_id + '">' + p.producto_codigo + ' - ' + p.producto_nombre + '</option>';
    });
    return html;
}

function agregarLinea() {
    var tr = document.createElement('tr');
    tr.innerHTML =
        '<td><select name="producto_id[]" class="form-control" required>' + opcionesProducto() + '</select></td>' +
        '<td><input type="number" name="cantidad[]" class="form-control" min="1" required></td>' +
        '<td><input type="number" name="costo[]" class="form-control" step="0.01" min="0" required></td>' +
        '<td><button type="button" class="btn btn-danger btn-flat" onclick="this.closest(\'tr\').remove()"><i class="fa fa-trash"></i></button></td>';
    document.getElementById('lineas_body').appendChild(tr);
}

agregarLinea();
</script>
