<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Usuario;

class LoginController extends Controller
{
    private Usuario $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
    }

    public function Inicio(): void
    {
        if (Auth::check()) {
            header('location:?c=home');
            exit;
        }

        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);

        $this->renderPartial('login/index', ['error' => $error]);
    }

    public function Ingresar(): void
    {
        $nick = trim($_POST['usuario_nick'] ?? '');
        $clave = $_POST['usuario_password'] ?? '';

        $usuario = ($nick !== '' && $clave !== '') ? $this->modelo->validarCredenciales($nick, $clave) : null;

        if ($usuario === null) {
            $_SESSION['login_error'] = 'Usuario o contraseña incorrectos.';
            header('location:?c=login');
            exit;
        }

        session_regenerate_id(true);
        Auth::login($usuario);

        header('location:?c=home');
        exit;
    }

    public function Salir(): void
    {
        Auth::logout();
        header('location:?c=login');
        exit;
    }
}
