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
$usuario_sesion = $_SESSION['usuario'] ?? null;
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
        <link rel="stylesheet" href="assets/css/print.css" media="print">
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
                                    <span class="hidden-xs"><?=htmlspecialchars($usuario_sesion['nombre_completo'] ?? '')?></span>
                                </a>
                                <ul class="dropdown-menu">

                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="assets/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            <?=htmlspecialchars($usuario_sesion['nombre_completo'] ?? '')?>
                                            <small><?=htmlspecialchars($usuario_sesion['rol_descripcion'] ?? 'Usuario')?></small>
                                        </p>
                                    </li>

                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">

                                        </div>
                                        <div class="pull-right">
                                            <a href="?c=login&a=Salir" class="btn btn-danger btn-flat"><i class="fa fa-power-off"></i> Salir</a>
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
                            <p><?=htmlspecialchars($usuario_sesion['nombre_completo'] ?? '')?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MENÚ</li>
                        <li class="active">
                            <a href="?c=home">
                                <i class="fa fa-home"></i> <span>Inicio</span>
                            </a>

                        </li>

                        <?php $esAdminMenu = ($usuario_sesion['rol_descripcion'] ?? '') === 'Administrador'; ?>

                        <li class=" treeview">
                            <a href="#">
                                <i class="fa fa-cubes"></i>
                                <span>Inventario</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">

                                <li class=""><a href="?c=producto"><i class="fa fa-archive"></i> Productos</a></li>

                                <?php if ($esAdminMenu): ?>
                                <li class=""><a href="?c=categoria"><i class="fa fa-tags"></i> Categorías</a></li>

                                <li class=""><a href="?c=proveedor"><i class="fa fa-truck"></i> Proveedores</a></li>
                                <?php endif; ?>

                                <li class=""><a href="?c=movimiento"><i class="fa fa-exchange"></i> Movimientos de Stock</a></li>

                            </ul>
                        </li>

                        <?php if ($esAdminMenu): ?>
                        <li class=" treeview">
                            <a href="#">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Compras</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class=""><a href="?c=ordencompra"><i class="fa fa-file-text"></i> Órdenes de Compra</a></li>
                            </ul>
                        </li>
                        <?php endif; ?>

                        <li class=" treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-signal"></i> <span>Reportes</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li class=""><a href="?c=reporte"><i class="fa fa-exclamation-triangle"></i> Stock Bajo</a></li>
                                <li class=""><a href="?c=reporte&a=ValorInventario"><i class="fa fa-dollar"></i> Valor de Inventario</a></li>
                                <li class=""><a href="?c=reporte&a=MovimientosPorFecha"><i class="fa fa-calendar"></i> Movimientos por Fecha</a></li>
                                <li class=""><a href="?c=reporte&a=ProductosMasMovidos"><i class="fa fa-line-chart"></i> Productos más Movidos</a></li>
                            </ul>
                        </li>

                        <?php if ($esAdminMenu): ?>
                        <li class="">
                            <a href="?c=usuario">
                                <i class="fa fa-users"></i> <span>Usuarios</span>
                            </a>
                        </li>
                        <?php endif; ?>

                    </ul>
                </section>
                <!-- /.sidebar -->      </aside>

