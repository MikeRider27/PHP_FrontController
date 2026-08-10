<?php
require_once "model/Usuario.php";

class LoginController{

    private $modelo;

    public function __CONSTRUCT(){
        $this->modelo = new Usuario();
    }

    public function Inicio(){
        if(isset($_SESSION['usuario'])){
            header("location:?c=home");
            exit;
        }

        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);

        require_once "view/login/index.php";
    }

    public function Ingresar(){
        $nick = trim($_POST['usuario_nick'] ?? '');
        $clave = $_POST['usuario_password'] ?? '';

        if($nick === '' || $clave === '' || !$this->modelo->ValidarCredenciales($nick, $clave)){
            $_SESSION['login_error'] = "Usuario o contraseña incorrectos.";
            header("location:?c=login");
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['usuario'] = array(
            'usuario_id' => $this->modelo->getUsuarioId(),
            'usuario_nick' => $this->modelo->getUsuarioNick(),
            'usuario_email' => $this->modelo->getUsuarioEmail(),
            'rol_id' => $this->modelo->getRolId(),
            'rol_descripcion' => $this->modelo->getRolDescripcion(),
            'nombre_completo' => trim($this->modelo->getPersonaNombre()." ".$this->modelo->getPersonaApellido()),
        );

        header("location:?c=home");
        exit;
    }

    public function Salir(){
        $_SESSION = array();
        session_destroy();
        header("location:?c=login");
        exit;
    }

}
