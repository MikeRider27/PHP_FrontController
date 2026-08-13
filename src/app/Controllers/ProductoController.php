<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;

class ProductoController extends Controller
{
    private Producto $modelo;
    private Categoria $categorias;
    private Proveedor $proveedores;

    public function __construct()
    {
        $this->modelo = new Producto();
        $this->categorias = new Categoria();
        $this->proveedores = new Proveedor();
    }

    public function Inicio(): void
    {
        $q = trim($_GET['q'] ?? '');
        $usuario = Auth::user();
        $this->render('producto/index', [
            'productos' => $this->modelo->listar($q),
            'categorias' => $this->categorias->listarActivas(),
            'proveedores' => $this->proveedores->listarActivos(),
            'q' => $q,
            'esAdmin' => $usuario['rol_descripcion'] === 'Administrador',
        ]);
    }

    public function Guardar(): void
    {
        $this->requireRole(['Administrador']);

        $id = intval($_POST['producto_id'] ?? 0);
        $codigo = trim($_POST['producto_codigo'] ?? '');
        $nombre = trim($_POST['producto_nombre'] ?? '');
        $descripcion = trim($_POST['producto_descripcion'] ?? '');
        $categoriaId = intval($_POST['categoria_id'] ?? 0);
        $proveedorId = !empty($_POST['proveedor_id']) ? intval($_POST['proveedor_id']) : null;
        $precioCosto = floatval($_POST['producto_precio_costo'] ?? 0);
        $precioVenta = floatval($_POST['producto_precio_venta'] ?? 0);
        $stockMinimo = intval($_POST['producto_stock_minimo'] ?? 0);

        if ($codigo !== '' && $nombre !== '' && $categoriaId > 0) {
            if ($id > 0) {
                $this->modelo->actualizar($id, $codigo, $nombre, $descripcion, $categoriaId, $proveedorId, $precioCosto, $precioVenta, $stockMinimo);
            } else {
                $this->modelo->insertar($codigo, $nombre, $descripcion, $categoriaId, $proveedorId, $precioCosto, $precioVenta, $stockMinimo);
            }
        }

        header('location:?c=producto');
        exit;
    }

    public function Eliminar(): void
    {
        $this->requireRole(['Administrador']);

        $id = intval($_GET['id'] ?? 0);
        if ($id > 0) {
            $this->modelo->eliminar($id);
        }
        header('location:?c=producto');
        exit;
    }
}
