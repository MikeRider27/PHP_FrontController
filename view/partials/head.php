<?php
/**
 * Template html de la cabecera
 * 
 * Esta template carga los elementos
 * estáticos como el header, css y las
 * etiquetas <nav> del menu.
 * 
 * Fichero head.php
 * 
 * @author Miguel Villalba <mike.mavc27@gmail.com>
 */
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sistema ZEUS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/font-awesome-4.4.0/css/font-awesome.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="assets/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="assets/css/dropdown-menu-custom.css">
        <link rel="icon" href="img/icon.png">
    </head>
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>S</b>Z</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Sistema </b>ZEUS</span>
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
                                    <img src="assets/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs">Miguel Villalba</span>
                                </a>
                                <ul class="dropdown-menu">

                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
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
                                            <a href="../views/login.php" class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i> Salir</a>
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
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>Miguel Villalba</p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">MENÚ</li>
                        <li class="active">
                            <a href="?c=home">
                                <i class="fa fa-home"></i> <span>Inicio</span> 
                            </a>

                        </li>

                        <li class=" treeview">
                            <a href="#">
                                <i class="fa fa-th-large"></i>
                                <span>Mantenimiento y Seguridad</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class=""><a href="?c=ciudad"><i class="glyphicon glyphicon-barcode"></i> Ciudad</a></li>

                                <li class=""><a href="manufacturers.php"><i class="fa fa-tag"></i> Fabricantes</a></li>

                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Categorías</a></li>

                            </ul>
                        </li>
                        <li class=" treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Gestion de Compras</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class=""><a href="?c=ciudad"><i class="glyphicon glyphicon-barcode"></i> Pedidos</a></li>

                                <li class=""><a href="manufacturers.php"><i class="fa fa-tag"></i> Orden de Compras</a></li>

                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Factura</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Ajustes</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Nota de Remision</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Nota de Credito</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Nota de Debito</a></li>

                            </ul>
                        </li>
                         <li class=" treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Gestion de Servicios</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class=""><a href="?c=ciudad"><i class="glyphicon glyphicon-barcode"></i> Recepcion</a></li>

                                <li class=""><a href="manufacturers.php"><i class="fa fa-tag"></i> Diagnostico</a></li>

                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Presupuesto</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Orden de Trabajo</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Materiales</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Trabajos Realizados</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Control de Calidad</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Garantia</a></li>

                            </ul>
                        </li>
 <li class=" treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Gestion de Facturacion</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class=""><a href="?c=ciudad"><i class="glyphicon glyphicon-barcode"></i> Apertura/ Cierre</a></li>

                                <li class=""><a href="manufacturers.php"><i class="fa fa-tag"></i> Factura</a></li>

                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Cobros</a></li>
                                <li class=""><a href="categories.php"><i class="fa fa-tags"></i> Arqueo</a></li>

                            </ul>
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

