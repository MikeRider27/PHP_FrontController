<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    private Categoria $modelo;

    public function __construct()
    {
        $this->requireRole(['Administrador']);
        $this->modelo = new Categoria();
    }

    public function Inicio(): void
    {
        $q = trim($_GET['q'] ?? '');
        $this->render('categoria/index', [
            'categorias' => $this->modelo->listar($q),
            'q' => $q,
        ]);
    }

    public function Guardar(): void
    {
        $id = intval($_POST['categoria_id'] ?? 0);
        $nombre = trim($_POST['categoria_nombre'] ?? '');
        $descripcion = trim($_POST['categoria_descripcion'] ?? '');

        if ($nombre !== '') {
            if ($id > 0) {
                $this->modelo->actualizar($id, $nombre, $descripcion);
            } else {
                $this->modelo->insertar($nombre, $descripcion);
            }
        }

        header('location:?c=categoria');
        exit;
    }

    public function Eliminar(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->modelo->eliminar($id);
        }
        header('location:?c=categoria');
        exit;
    }
}
