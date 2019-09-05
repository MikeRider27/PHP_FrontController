<html><head>
	    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestión de fabricantes | Sistema de Pedidos</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fa/css/font-awesome.min.css">
    <!-- Select2 -->
	<link rel="stylesheet" href="plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="dist/css/dropdown-menu-custom.css">
  	<link rel="icon" href="img/icon.png">
	  <style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style></head>
  <body class="skin-blue sidebar-mini">
	 
<form class="form-horizontal" method="post" id="new_register" name="new_register">
<!-- Modal -->
<div class="modal fade" id="modal_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Nuevo Fabricante</h4>
      </div>
      <div class="modal-body">
	  
      <div class="form-group">
		<label for="name" class="col-sm-3 control-label">Nombre</label>
		<div class="col-sm-6">
		  <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el fabricante" required="">
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
</form> <form class="form-horizontal" method="post" id="update_register" name="update_register">
<!-- Modal -->
<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Editar Fabricante</h4>
      </div>
      <div class="modal-body">
		<div id="loader2" class="text-center"></div>
		<div class="outer_div2"></div>

	  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" id="actualizar_datos" class="btn btn-primary">Actualizar datos</button>
      </div>
    </div>
  </div>
</div>
</form>  
    <div class="wrapper">
      <header class="main-header">
		        <!-- Logo -->
        <a href="index.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>P</b>O</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Sistema </b>Pedidos</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="dist/img/admin.png" class="user-image" alt="User Image">
                  <span class="hidden-xs">Miguel Villalba</span>
                </a>
                <ul class="dropdown-menu">
				
                  <!-- User image -->
                  <li class="user-header">
                    <img src="dist/img/admin.png" class="img-circle" alt="User Image">
                    <p>
						Miguel Villalba		
                      <small>Usuario</small>
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      
                    </div>
                    <div class="pull-right">
                      <a href="login.php?logout" class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i> Salir</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>
        </nav>      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
		        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar" style="height: auto;">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/admin.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Miguel Villalba</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MENÚ</li>
            <li class="">
              <a href="index.php">
                <i class="fa fa-home"></i> <span>Inicio</span> 
              </a>
              
            </li>
			
						<li class="">
              <a href="purchase_order.php">
                <i class="fa fa-shopping-cart"></i> <span>Pedidos</span>
              </a>
            </li>
						
			            <li class="active treeview">
              <a href="#">
                <i class="fa fa-th-large"></i>
                <span>Catálogo</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				
               	<li class=""><a href="products.php"><i class="glyphicon glyphicon-barcode"></i> Productos</a></li>
							
							 <li class="active"><a href="manufacturers.php"><i class="fa fa-tag"></i> Fabricantes</a></li>
            			
							 <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Categorías</a></li>
              
			  </ul>
            </li>
						
			
			
						
			<li class="">
              <a href="supplier.php">
                <i class="fa fa-users"></i> <span>Proveedores</span>
              </a>
            </li>
			
          
						
			
			
			
			
			
			
			
			            <li class=" treeview">
              <a href="#">
                <i class="glyphicon glyphicon-signal"></i> <span>Reportes</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				<li class=""><a href="purchases_order_report.php"><i class="fa fa-pie-chart "></i> Pedidos</a></li>
              	
			 </ul>
            </li>
									
			<li class=" treeview">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Configuración</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			                  <li class=""><a href="business_profile.php"><i class="glyphicon glyphicon-briefcase"></i> Perfil de la empresa</a></li>
			  					   
				<li class=""><a href="branch_offices.php"><i class="fa fa-shopping-bag "></i> Sucursales</a></li>
								
              </ul>
            </li>
			
									<li class=" treeview">
              <a href="#">
                <i class="fa fa-lock"></i> <span>Administrar accesos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  
                <li class=""><a href="group_list.php"><i class="glyphicon glyphicon-briefcase"></i> Grupos de usuarios</a></li>
				
							<li class=""><a href="user_list.php"><i class="fa fa-users"></i> Usuarios</a></li>
				
              </ul>
            </li>
                        
           
          </ul>
        </section>
        <!-- /.sidebar -->      </aside>
      <!-- Content Wrapper. Contains page content -->
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
				<h3 class="box-title">Listado de Fabricantes</h3>
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					<table class="table table-condensed table-hover table-striped">
						<tbody><tr>
							<th>ID</th>
							<th>Fabricante </th>
							<th>Nº de productos</th>
							<th>Estado</th>
							<th>Agregado</th>
							<th></th>
						</tr>
							
						<tr>
							<td>1</td>
							<td>Prueba Fabricantes</td>
							<td>10.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>24-06-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('1');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('1')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>18</td>
							<td>GUBAL</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>01-07-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('18');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('18')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>20</td>
							<td>Mensajeria2017</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>31-07-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('20');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('20')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>21</td>
							<td>PARTNER</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>02-08-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('21');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('21')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>24</td>
							<td>Ica</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>07-08-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('24');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('24')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>25</td>
							<td>sony</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>07-08-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('25');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('25')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>26</td>
							<td>gdfgdfg</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>24-08-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('26');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('26')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>27</td>
							<td>SFK</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>26-08-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('27');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('27')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>29</td>
							<td>link bitsss</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>04-09-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('29');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('29')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>30</td>
							<td>ascsac</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>20-10-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('30');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('30')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>31</td>
							<td>aa</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>20-10-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('31');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('31')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>32</td>
							<td>metrito</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>20-10-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('32');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('32')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>33</td>
							<td>Bellota</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>11-11-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('33');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('33')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>35</td>
							<td>Wtf</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>13-12-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('35');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('35')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td>36</td>
							<td>teste</td>
							<td>0.00</td>
							<td>
								<span class="label label-success">Activo</span>
							</td>
							<td>18-12-2017</td>
							<td>
							<div class="btn-group pull-right">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acciones <span class="fa fa-caret-down"></span></button>
								<ul class="dropdown-menu">
																		<li><a href="#" data-toggle="modal" data-target="#modal_update" onclick="editar('36');"><i class="fa fa-edit"></i> Editar</a></li>
																		<li><a href="#" onclick="eliminar('36')"><i class="fa fa-trash"></i> Borrar</a></li>
																	</ul>
							</div><!-- /btn-group -->
                    		</td>
						</tr>
							
						<tr>
							<td colspan="6"> 
								Mostrando 1 al 15 de 51 registros<ul class="pagination pagination-sm no-margin pull-right"><li class="disabled"><span><a>‹ Anterior</a></span></li><li class="active"><a>1</a></li><li><a href="javascript:void(0);" onclick="load(2)">2</a></li><li><a href="javascript:void(0);" onclick="load(3)">3</a></li><li><a href="javascript:void(0);" onclick="load(4)">4</a></li><li><span><a href="javascript:void(0);" onclick="load(2)">Siguiente ›</a></span></li></ul>							</td>
						</tr>	
					</tbody></table>
					</div>
				</div><!-- /.box-body -->
				
			</div><!-- /.box -->
		</div><!-- /.col -->
	</div><!-- /.row -->	
	          
		  
</div><!-- Datos ajax Final -->         
        </section><!-- /.content -->
		      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
	<div class="pull-right hidden-xs">
		<b>Versión</b> 1.0
	</div>
	<strong>Copyright © 2016-2019 <a href="http://obedalvarado.pw" target="_blank"> Sistemas Web</a></strong> All rights reserved.
</footer>    </div><!-- ./wrapper -->
	    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/app.min.js"></script>
   
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
	<script src="dist/js/VentanaCentrada.js"></script>
  

	<script>
	$(function() {
		load(1);
	});
	function load(page){
		var query=$("#q").val();
		var per_page=$("#per_page").val();
		var parametros = {"action":"ajax","page":page,'query':query,'per_page':per_page};
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'./ajax/fabricantes_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='./img/ajax-loader.gif'>");
		  },
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	
	function per_page(valor){
		$("#per_page").val(valor);
		load(1);
		$('.dropdown-menu li' ).removeClass( "active" );
		$("#"+valor).addClass( "active" );
	}

	
	</script>

		<script>
		function eliminar(id){
			if(confirm('Esta acción  eliminará de forma permanente el fabricante \n\n Desea continuar?')){
				var page=1;
				var query=$("#q").val();
				var per_page=$("#per_page").val();
				var parametros = {"action":"ajax","page":page,"query":query,"per_page":per_page,"id":id};
				
				$.ajax({
					url:'./ajax/fabricantes_ajax.php',
					data: parametros,
					 beforeSend: function(objeto){
					$("#loader").html("<img src='./img/ajax-loader.gif'>");
				  },
					success:function(data){
						$(".outer_div").html(data).fadeIn('slow');
						$("#loader").html("");
						window.setTimeout(function() {
						$(".alert").fadeTo(500, 0).slideUp(500, function(){
						$(this).remove();});}, 5000);
					}
				})
			}
		}
	</script>
	



<script>
$( "#new_register" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro/agregar_fabricante.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Enviando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
			window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();});}, 5000);
			$('#modal_register').modal('hide');
		  }
	});
  event.preventDefault();
})
</script>

<script>
$( "#update_register" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/modificar/fabricante.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Enviando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
			window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();});}, 5000);
			$('#modal_update').modal('hide');
		  }
	});
  event.preventDefault();
});



</script>
<script>
		function editar(id){
			var parametros = {"action":"ajax","id":id};
			$.ajax({
					url:'modal/editar/fabricante.php',
					data: parametros,
					 beforeSend: function(objeto){
					$("#loader2").html("<img src='./img/ajax-loader.gif'>");
				  },
					success:function(data){
						$(".outer_div2").html(data).fadeIn('slow');
						$("#loader2").html("");
					}
				})
		}
		
		
</script></body></html>