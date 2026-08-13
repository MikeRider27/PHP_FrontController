<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sistema ZEUS | Iniciar sesión</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="assets/font-awesome-4.4.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/AdminLTE.min.css">
        <link rel="icon" href="img/icon.png">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="?c=login"><b>Sistema </b>ZEUS</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Ingresá tus credenciales para continuar</p>

                <?php if(!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?=htmlspecialchars($error)?>
                    </div>
                <?php endif; ?>

                <form action="?c=login&a=Ingresar" method="post">
                    <div class="form-group has-feedback">
                        <input type="text" name="usuario_nick" class="form-control" placeholder="Usuario" required autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="usuario_password" class="form-control" placeholder="Contraseña" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- jQuery 2.1.4 -->
        <script src="assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>
