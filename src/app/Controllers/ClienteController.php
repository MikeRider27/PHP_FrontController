<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Cliente;

class ClienteController extends Controller
{
    private Cliente $modelo;

    public function __construct()
    {
        $this->requireRole(['Administrador', 'Operador']);
        $this->modelo = new Cliente();
    }

    public function Inicio(): void
    {
        $q = trim($_GET['q'] ?? '');
        $this->render('cliente/index', [
            'clientes' => $this->modelo->listar($q),
            'q' => $q,
        ]);
    }

    public function Guardar(): void
    {
        $id = intval($_POST['cliente_id'] ?? 0);
        $razonSocial = trim($_POST['cliente_razon_social'] ?? '');
        $documento = trim($_POST['cliente_documento'] ?? '');
        $telefono = trim($_POST['cliente_telefono'] ?? '');
        $email = trim($_POST['cliente_email'] ?? '');
        $direccion = trim($_POST['cliente_direccion'] ?? '');

        if ($razonSocial !== '') {
            if ($id > 0) {
                $this->modelo->actualizar($id, $razonSocial, $documento, $telefono, $email, $direccion);
            } else {
                $this->modelo->insertar($razonSocial, $documento, $telefono, $email, $direccion);
            }
        }

        header('location:?c=cliente');
        exit;
    }

    public function Eliminar(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->modelo->eliminar($id);
        }
        header('location:?c=cliente');
        exit;
    }
}
