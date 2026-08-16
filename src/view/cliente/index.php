<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Clientes
            <small>Gestión de clientes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Clientes</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <form method="get" class="input-group">
                    <input type="hidden" name="c" value="cliente">
                    <input type="text" name="q" class="form-control" placeholder="Buscar por razón social" value="<?=htmlspecialchars($q)?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </form>
            </div>
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_cliente" onclick="nuevoCliente()">
                    <i class="fa fa-plus"></i> Nuevo Cliente
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
                                    <th>RUC/CI</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($clientes as $c): ?>
                                <tr>
                                    <td><?=htmlspecialchars($c['cliente_razon_social'])?></td>
                                    <td><?=htmlspecialchars($c['cliente_documento'] ?? '')?></td>
                                    <td><?=htmlspecialchars($c['cliente_telefono'] ?? '')?></td>
                                    <td><?=htmlspecialchars($c['cliente_email'] ?? '')?></td>
                                    <td class="text-center"><?=htmlspecialchars($c['estado_descripcion'])?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-flat"
                                                data-toggle="modal" data-target="#modal_cliente"
                                                onclick='editarCliente(<?=json_encode($c)?>)'>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <a class="btn btn-warning btn-flat" href="?c=cliente&a=Eliminar&id=<?=$c['cliente_id']?>"
                                           onclick="return confirm('¿Desactivar este cliente?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($clientes)): ?>
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

<div class="modal fade" id="modal_cliente" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="?c=cliente&a=Guardar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_cliente_titulo">Nuevo Cliente</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cliente_id" id="cliente_id" value="0">
                    <div class="form-group">
                        <label>Razón Social</label>
                        <input type="text" name="cliente_razon_social" id="cliente_razon_social" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>RUC / CI</label>
                        <input type="text" name="cliente_documento" id="cliente_documento" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="cliente_telefono" id="cliente_telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="cliente_email" id="cliente_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea name="cliente_direccion" id="cliente_direccion" class="form-control"></textarea>
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
function nuevoCliente() {
    document.getElementById('modal_cliente_titulo').textContent = 'Nuevo Cliente';
    document.getElementById('cliente_id').value = 0;
    ['razon_social', 'documento', 'telefono', 'email', 'direccion'].forEach(function (campo) {
        document.getElementById('cliente_' + campo).value = '';
    });
}
function editarCliente(c) {
    document.getElementById('modal_cliente_titulo').textContent = 'Modificar Cliente';
    document.getElementById('cliente_id').value = c.cliente_id;
    document.getElementById('cliente_razon_social').value = c.cliente_razon_social || '';
    document.getElementById('cliente_documento').value = c.cliente_documento || '';
    document.getElementById('cliente_telefono').value = c.cliente_telefono || '';
    document.getElementById('cliente_email').value = c.cliente_email || '';
    document.getElementById('cliente_direccion').value = c.cliente_direccion || '';
}
</script>
