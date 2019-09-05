        <form class="form-horizontal" method="POST" action="?c=ciudad&a=Guardar">
            <div class="modal fade" id="modal_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title"><?=$titulo?> Ciudad</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                            <input class="form-control" name="ID" type="hidden" value="<?=$p->getId_ciudad()?>">
                            

                            <label class="col-lg-2 control-label" for="Nombre">DESCRIPCION</label>
                          <div class="col-lg-10">
                            <input required class="form-control" name="Nombre" type="text" placeholder="Nombre Producto" value="<?=$p->getCiu_descri()?>">
                          </div>
                        </div>




                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" id="guardar_datos" class="btn btn-primary">Registrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form> 