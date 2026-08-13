<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Usuarios
            <small>Gestión de usuarios y roles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Usuarios</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_usuario" onclick="nuevoUsuario()">
                    <i class="fa fa-plus"></i> Nuevo Usuario
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
                                    <th>Nombre</th>
                                    <th>Cédula</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th class="text-center">Rol</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><?=htmlspecialchars($u['persona_nombre'] . ' ' . $u['persona_apellido'])?></td>
                                    <td><?=htmlspecialchars($u['persona_cedula'])?></td>
                                    <td><?=htmlspecialchars($u['usuario_nick'])?></td>
                                    <td><?=htmlspecialchars($u['usuario_email'])?></td>
                                    <td class="text-center"><?=htmlspecialchars($u['rol_descripcion'])?></td>
                                    <td class="text-center"><?=htmlspecialchars($u['estado_descripcion'])?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-flat"
                                                data-toggle="modal" data-target="#modal_usuario"
                                                onclick='editarUsuario(<?=json_encode($u)?>)'>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php if ($u['usuario_nick'] !== 'admin'): ?>
                                        <a class="btn btn-warning btn-flat" href="?c=usuario&a=Eliminar&id=<?=$u['usuario_id']?>"
                                           onclick="return confirm('¿Desactivar este usuario?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($usuarios)): ?>
                                <tr><td colspan="7" class="text-center">Sin resultados</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_usuario" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="?c=usuario&a=Guardar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_usuario_titulo">Nuevo Usuario</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="usuario_id" id="usuario_id" value="0">
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="persona_nombre" id="persona_nombre" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-group">
                                <label>Cédula</label>
                                <input type="text" name="persona_cedula" id="persona_cedula" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="persona_apellido" id="persona_apellido" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Usuario (nick)</label>
                        <input type="text" name="usuario_nick" id="usuario_nick" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="usuario_email" id="usuario_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="usuario_password" id="usuario_password" class="form-control">
                        <p class="help-block" id="usuario_password_help"></p>
                    </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <select name="rol_id" id="rol_id" class="form-control" required>
                            <?php foreach ($roles as $r): ?>
                            <option value="<?=$r['rol_id']?>"><?=htmlspecialchars($r['rol_descripcion'])?></option>
                            <?php endforeach; ?>
                        </select>
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
function nuevoUsuario() {
    document.getElementById('modal_usuario_titulo').textContent = 'Nuevo Usuario';
    document.getElementById('usuario_id').value = 0;
    document.getElementById('persona_nombre').value = '';
    document.getElementById('persona_cedula').value = '';
    document.getElementById('persona_apellido').value = '';
    document.getElementById('usuario_nick').value = '';
    document.getElementById('usuario_email').value = '';
    document.getElementById('usuario_password').value = '';
    document.getElementById('usuario_password').required = true;
    document.getElementById('usuario_password_help').textContent = '';
}
function editarUsuario(u) {
    document.getElementById('modal_usuario_titulo').textContent = 'Modificar Usuario';
    document.getElementById('usuario_id').value = u.usuario_id;
    document.getElementById('persona_nombre').value = u.persona_nombre;
    document.getElementById('persona_cedula').value = u.persona_cedula || '';
    document.getElementById('persona_apellido').value = u.persona_apellido;
    document.getElementById('usuario_nick').value = u.usuario_nick;
    document.getElementById('usuario_email').value = u.usuario_email;
    document.getElementById('usuario_password').value = '';
    document.getElementById('usuario_password').required = false;
    document.getElementById('rol_id').value = u.rol_id;
    document.getElementById('usuario_password_help').textContent = 'Dejar en blanco para no cambiar la contraseña actual.';
}
</script>
