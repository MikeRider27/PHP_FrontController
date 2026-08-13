<div class="content-wrapper" style="min-height: 434px;">
    <section class="content-header">
        <h1>
            Categorías
            <small>Gestión de categorías de productos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="?c=home"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Categorías</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-6">
                <form method="get" class="input-group">
                    <input type="hidden" name="c" value="categoria">
                    <input type="text" name="q" class="form-control" placeholder="Buscar por nombre" value="<?=htmlspecialchars($q)?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                    </span>
                </form>
            </div>
            <div class="col-xs-6 text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_categoria" onclick="nuevaCategoria()">
                    <i class="fa fa-plus"></i> Nueva Categoría
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
                                    <th>Descripción</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                                <?php foreach ($categorias as $c): ?>
                                <tr>
                                    <td><?=htmlspecialchars($c['categoria_nombre'])?></td>
                                    <td><?=htmlspecialchars($c['categoria_descripcion'] ?? '')?></td>
                                    <td class="text-center"><?=htmlspecialchars($c['estado_descripcion'])?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-info btn-flat"
                                                data-toggle="modal" data-target="#modal_categoria"
                                                onclick='editarCategoria(<?=json_encode($c)?>)'>
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <a class="btn btn-warning btn-flat" href="?c=categoria&a=Eliminar&id=<?=$c['categoria_id']?>"
                                           onclick="return confirm('¿Desactivar esta categoría?');">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($categorias)): ?>
                                <tr><td colspan="4" class="text-center">Sin resultados</td></tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal_categoria" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form method="post" action="?c=categoria&a=Guardar">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal_categoria_titulo">Nueva Categoría</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="categoria_id" id="categoria_id" value="0">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="categoria_nombre" id="categoria_nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea name="categoria_descripcion" id="categoria_descripcion" class="form-control"></textarea>
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
function nuevaCategoria() {
    document.getElementById('modal_categoria_titulo').textContent = 'Nueva Categoría';
    document.getElementById('categoria_id').value = 0;
    document.getElementById('categoria_nombre').value = '';
    document.getElementById('categoria_descripcion').value = '';
}
function editarCategoria(c) {
    document.getElementById('modal_categoria_titulo').textContent = 'Modificar Categoría';
    document.getElementById('categoria_id').value = c.categoria_id;
    document.getElementById('categoria_nombre').value = c.categoria_nombre;
    document.getElementById('categoria_descripcion').value = c.categoria_descripcion || '';
}
</script>
