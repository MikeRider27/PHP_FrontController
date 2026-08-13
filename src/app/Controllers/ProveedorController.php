<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    private Proveedor $modelo;

    public function __construct()
    {
        $this->requireRole(['Administrador']);
        $this->modelo = new Proveedor();
    }

    public function Inicio(): void
    {
        $q = trim($_GET['q'] ?? '');
        $this->render('proveedor/index', [
            'proveedores' => $this->modelo->listar($q),
            'q' => $q,
        ]);
    }

    public function Guardar(): void
    {
        $id = intval($_POST['proveedor_id'] ?? 0);
        $razonSocial = trim($_POST['proveedor_razon_social'] ?? '');
        $ruc = trim($_POST['proveedor_ruc'] ?? '');
        $telefono = trim($_POST['proveedor_telefono'] ?? '');
        $email = trim($_POST['proveedor_email'] ?? '');
        $direccion = trim($_POST['proveedor_direccion'] ?? '');

        if ($razonSocial !== '') {
            if ($id > 0) {
                $this->modelo->actualizar($id, $razonSocial, $ruc, $telefono, $email, $direccion);
            } else {
                $this->modelo->insertar($razonSocial, $ruc, $telefono, $email, $direccion);
            }
        }

        header('location:?c=proveedor');
        exit;
    }

    public function Eliminar(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->modelo->eliminar($id);
        }
        header('location:?c=proveedor');
        exit;
    }
}
