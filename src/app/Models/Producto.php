<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Producto extends Model
{
    public function listar(string $filtro = ''): array
    {
        $consulta = "SELECT pr.producto_id, pr.producto_codigo, pr.producto_nombre, pr.producto_descripcion,
                            pr.categoria_id, c.categoria_nombre,
                            pr.proveedor_id, prov.proveedor_razon_social,
                            pr.producto_precio_costo, pr.producto_precio_venta,
                            pr.producto_stock_actual, pr.producto_stock_minimo,
                            e.estado_descripcion
                     FROM productos pr
                     INNER JOIN categorias c ON c.categoria_id = pr.categoria_id
                     LEFT JOIN proveedores prov ON prov.proveedor_id = pr.proveedor_id
                     INNER JOIN estados e ON e.estado_id = pr.estado_id
                     WHERE pr.producto_nombre ILIKE ? OR pr.producto_codigo ILIKE ?
                     ORDER BY pr.producto_nombre";
        $sentencia = $this->db->prepare($consulta);
        $like = '%' . $filtro . '%';
        $sentencia->execute([$like, $like]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos(): array
    {
        $consulta = "SELECT producto_id, producto_codigo, producto_nombre, producto_stock_actual, producto_precio_venta
                     FROM productos pr
                     INNER JOIN estados e ON e.estado_id = pr.estado_id
                     WHERE e.estado_descripcion = 'Activo'
                     ORDER BY producto_nombre";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarStockBajo(): array
    {
        $consulta = "SELECT pr.producto_id, pr.producto_codigo, pr.producto_nombre, c.categoria_nombre,
                            pr.producto_stock_actual, pr.producto_stock_minimo
                     FROM productos pr
                     INNER JOIN categorias c ON c.categoria_id = pr.categoria_id
                     INNER JOIN estados e ON e.estado_id = pr.estado_id
                     WHERE e.estado_descripcion = 'Activo'
                       AND pr.producto_stock_actual <= pr.producto_stock_minimo
                     ORDER BY pr.producto_stock_actual ASC";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function valorInventario(): array
    {
        $consulta = "SELECT pr.producto_id, pr.producto_codigo, pr.producto_nombre, c.categoria_nombre,
                            pr.producto_stock_actual, pr.producto_precio_costo, pr.producto_precio_venta,
                            (pr.producto_stock_actual * pr.producto_precio_costo) AS valor_costo,
                            (pr.producto_stock_actual * pr.producto_precio_venta) AS valor_venta
                     FROM productos pr
                     INNER JOIN categorias c ON c.categoria_id = pr.categoria_id
                     INNER JOIN estados e ON e.estado_id = pr.estado_id
                     WHERE e.estado_descripcion = 'Activo'
                     ORDER BY valor_costo DESC";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarActivos(): int
    {
        $consulta = "SELECT COUNT(*) FROM productos pr
                     INNER JOIN estados e ON e.estado_id = pr.estado_id
                     WHERE e.estado_descripcion = 'Activo'";
        return (int) $this->db->query($consulta)->fetchColumn();
    }

    public function obtener(int $id): ?array
    {
        $sentencia = $this->db->prepare('SELECT * FROM productos WHERE producto_id = ?');
        $sentencia->execute([$id]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function insertar(
        string $codigo,
        string $nombre,
        string $descripcion,
        int $categoriaId,
        ?int $proveedorId,
        float $precioCosto,
        float $precioVenta,
        int $stockMinimo
    ): void {
        $consulta = "INSERT INTO productos
                        (producto_codigo, producto_nombre, producto_descripcion, categoria_id, proveedor_id,
                         producto_precio_costo, producto_precio_venta, producto_stock_actual, producto_stock_minimo, estado_id)
                     VALUES (?, ?, ?, ?, ?, ?, ?, 0, ?, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo'))";
        $this->db->prepare($consulta)->execute([
            $codigo, $nombre, $descripcion, $categoriaId, $proveedorId, $precioCosto, $precioVenta, $stockMinimo,
        ]);
    }

    public function actualizar(
        int $id,
        string $codigo,
        string $nombre,
        string $descripcion,
        int $categoriaId,
        ?int $proveedorId,
        float $precioCosto,
        float $precioVenta,
        int $stockMinimo
    ): void {
        $consulta = "UPDATE productos SET
                        producto_codigo = ?, producto_nombre = ?, producto_descripcion = ?,
                        categoria_id = ?, proveedor_id = ?, producto_precio_costo = ?,
                        producto_precio_venta = ?, producto_stock_minimo = ?
                     WHERE producto_id = ?";
        $this->db->prepare($consulta)->execute([
            $codigo, $nombre, $descripcion, $categoriaId, $proveedorId, $precioCosto, $precioVenta, $stockMinimo, $id,
        ]);
    }

    public function eliminar(int $id): void
    {
        $consulta = "UPDATE productos SET estado_id = (SELECT estado_id FROM estados WHERE estado_descripcion = 'Inactivo') WHERE producto_id = ?";
        $this->db->prepare($consulta)->execute([$id]);
    }
}
