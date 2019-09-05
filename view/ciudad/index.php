<div class="content-wrapper" style="min-height: 434px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="row">
            <div class="col-xs-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar por nombre" id="q" onkeyup="load(1);">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="load(1);"><i class="fa fa-search"></i></button>
                    </span>
                </div><!-- /input-group -->

            </div>
            <div class="col-xs-3"></div>
            <div class="col-xs-1">
                <div id="loader" class="text-center"></div>

            </div>

            <div class="col-xs-5 ">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal_register"><i class="fa fa-plus"></i> Nuevo</button>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mostrar
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right">
                        <li class="active" onclick="per_page(15);" id="15"><a href="#">15</a></li>
                        <li onclick="per_page(25);" id="25"><a href="#">25</a></li>
                        <li onclick="per_page(50);" id="50"><a href="#">50</a></li>
                        <li onclick="per_page(100);" id="100"><a href="#">100</a></li>
                        <li onclick="per_page(1000000);" id="1000000"><a href="#">Todos</a></li>
                    </ul>
                </div>
            </div>
            
        
            <input type="hidden" id="per_page" value="15">
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div id="resultados_ajax"></div>
        <div class="outer_div">


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Listado de Ciudad</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-hover table-striped">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">DESCRIPCION</th>
                                        <th class="text-center">ACCIONES</th>

                                    </tr>
                                    <?php foreach($this->modelo->carga_tabla() as $r):?>
                    <tr>
                      <td class="text-center"><?=$r->id_ciudad?></td>
                      <td class="text-center"><?=$r->ciu_descri?></td>
                      
                      <td class="text-center">
                          <a class="btn btn-info btn-flat" data-toggle="modal" data-target="#modal_update"><i class="fa fa-lg fa-refresh"></i></a>

                          <a class="btn btn-warning btn-flat" href="?c=producto&a=Borrar&id=<?=$r->id_ciudad?>"><i class="fa fa-lg fa-trash"></i></a>
                    
                    </td>
                    </tr>
                <?php endforeach;?>




                                    <tr>
                                        <td colspan="4"> 
                                            Mostrando 1 al 15 de 64 registros<ul class="pagination pagination-sm no-margin pull-right"><li class="disabled"><span><a>‹ Anterior</a></span></li><li class="active"><a>1</a></li><li><a href="javascript:void(0);" onclick="load(2)">2</a></li><li><a href="javascript:void(0);" onclick="load(3)">3</a></li><li><a href="javascript:void(0);" onclick="load(4)">4</a></li><li><a href="javascript:void(0);" onclick="load(5)">5</a></li><li><span><a href="javascript:void(0);" onclick="load(2)">Siguiente ›</a></span></li></ul>							</td>
                                    </tr>	
                                </table>
                            </div>
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->	
<?php 

?>

        </div><!-- Datos ajax Final -->         
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->