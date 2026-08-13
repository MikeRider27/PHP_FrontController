<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    private Usuario $modelo;

    public function __construct()
    {
        $this->requireRole(['Administrador']);
        $this->modelo = new Usuario();
    }

    public function Inicio(): void
    {
        $this->render('usuario/index', [
            'usuarios' => $this->modelo->listar(),
            'roles' => $this->modelo->listarRoles(),
        ]);
    }

    public function Guardar(): void
    {
        $id = intval($_POST['usuario_id'] ?? 0);
        $cedula = trim($_POST['persona_cedula'] ?? '');
        $nombre = trim($_POST['persona_nombre'] ?? '');
        $apellido = trim($_POST['persona_apellido'] ?? '');
        $nick = trim($_POST['usuario_nick'] ?? '');
        $email = trim($_POST['usuario_email'] ?? '');
        $password = $_POST['usuario_password'] ?? '';
        $rolId = intval($_POST['rol_id'] ?? 0);

        if ($nombre !== '' && $apellido !== '' && $nick !== '' && $email !== '' && $rolId > 0) {
            if ($id > 0) {
                $this->modelo->actualizar($id, $cedula, $nombre, $apellido, $nick, $email, $password ?: null, $rolId);
            } elseif ($password !== '') {
                $this->modelo->insertar($cedula, $nombre, $apellido, $nick, $email, $password, $rolId);
            }
        }

        header('location:?c=usuario');
        exit;
    }

    public function Eliminar(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->modelo->eliminar($id);
        }
        header('location:?c=usuario');
        exit;
    }
}
