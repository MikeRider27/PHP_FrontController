<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Proveedores
            <small>Gestión de proveedores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Proveedores</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <form method="get" class="input-group">
                    <input type="hidden" name="c" value="proveedor">
                    <input type="text" name="q" class="form-control" placeholder="Buscar por razón social" value="<?=htmlspecialchars($q)?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </form>
            </div>
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_proveedor" onclick="nuevoProveedor()">
                    <i class="fa fa-plus"></i> Nuevo Proveedor
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover table-striped">
                                <tr>
                                    <th>Razón Social</th>
                                    <th>RUC</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($proveedores as $p): ?>
                                <tr>
                                    <td><?=htmlspecialchars($p['proveedor_razon_social'])?></td>
                                    <td><?=htmlspecialchars($p['proveedor_ruc'] ?? '')?></td>
                                    <td><?=htmlspecialchars($p['proveedor_telefono'] ?? '')?></td>
                                    <td><?=htmlspecialchars($p['proveedor_email'] ?? '')?></td>
                                    <td class="text-center"><?=htmlspecialchars($p['estado_descripcion'])?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-flat"
                                                data-toggle="modal" data-target="#modal_proveedor"
                                                onclick='editarProveedor(<?=json_encode($p)?>)'>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <a class="btn btn-warning btn-flat" href="?c=proveedor&a=Eliminar&id=<?=$p['proveedor_id']?>"
                                           onclick="return confirm('¿Desactivar este proveedor?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($proveedores)): ?>
                                <tr><td colspan="6" class="text-center">Sin resultados</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_proveedor" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="?c=proveedor&a=Guardar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_proveedor_titulo">Nuevo Proveedor</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="proveedor_id" id="proveedor_id" value="0">
                    <div class="form-group">
                        <label>Razón Social</label>
                        <input type="text" name="proveedor_razon_social" id="proveedor_razon_social" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>RUC</label>
                        <input type="text" name="proveedor_ruc" id="proveedor_ruc" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="proveedor_telefono" id="proveedor_telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="proveedor_email" id="proveedor_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea name="proveedor_direccion" id="proveedor_direccion" class="form-control"></textarea>
                    </div>
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
function nuevoProveedor() {
    document.getElementById('modal_proveedor_titulo').textContent = 'Nuevo Proveedor';
    document.getElementById('proveedor_id').value = 0;
    ['razon_social', 'ruc', 'telefono', 'email', 'direccion'].forEach(function (campo) {
        document.getElementById('proveedor_' + campo).value = '';
    });
}
function editarProveedor(p) {
    document.getElementById('modal_proveedor_titulo').textContent = 'Modificar Proveedor';
    document.getElementById('proveedor_id').value = p.proveedor_id;
    document.getElementById('proveedor_razon_social').value = p.proveedor_razon_social || '';
    document.getElementById('proveedor_ruc').value = p.proveedor_ruc || '';
    document.getElementById('proveedor_telefono').value = p.proveedor_telefono || '';
    document.getElementById('proveedor_email').value = p.proveedor_email || '';
    document.getElementById('proveedor_direccion').value = p.proveedor_direccion || '';
}
</script>
