<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Proveedor extends Model
{
    public function listar(string $filtro = ''): array
    {
        $consulta = "SELECT p.proveedor_id, p.proveedor_razon_social, p.proveedor_ruc,
                            p.proveedor_telefono, p.proveedor_email, p.proveedor_direccion,
                            e.estado_descripcion
                     FROM proveedores p
                     INNER JOIN estados e ON e.estado_id = p.estado_id
                     WHERE p.proveedor_razon_social ILIKE ?
                     ORDER BY p.proveedor_razon_social";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute(['%' . $filtro . '%']);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos(): array
    {
        $consulta = "SELECT proveedor_id, proveedor_razon_social
                     FROM proveedores p
                     INNER JOIN estados e ON e.estado_id = p.estado_id
                     WHERE e.estado_descripcion = 'Activo'
                     ORDER BY proveedor_razon_social";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener(int $id): ?array
    {
        $sentencia = $this->db->prepare('SELECT * FROM proveedores WHERE proveedor_id = ?');
        $sentencia->execute([$id]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function insertar(string $razonSocial, string $ruc, string $telefono, string $email, string $direccion): void
    {
        $consulta = "INSERT INTO proveedores (proveedor_razon_social, proveedor_ruc, proveedor_telefono, proveedor_email, proveedor_direccion, estado_id)
                     VALUES (?, ?, ?, ?, ?, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo'))";
        $this->db->prepare($consulta)->execute([$razonSocial, $ruc, $telefono, $email, $direccion]);
    }

    public function actualizar(int $id, string $razonSocial, string $ruc, string $telefono, string $email, string $direccion): void
    {
        $consulta = 'UPDATE proveedores SET proveedor_razon_social = ?, proveedor_ruc = ?, proveedor_telefono = ?, proveedor_email = ?, proveedor_direccion = ? WHERE proveedor_id = ?';
        $this->db->prepare($consulta)->execute([$razonSocial, $ruc, $telefono, $email, $direccion, $id]);
    }

    public function eliminar(int $id): void
    {
        $consulta = "UPDATE proveedores SET estado_id = (SELECT estado_id FROM estados WHERE estado_descripcion = 'Inactivo') WHERE proveedor_id = ?";
        $this->db->prepare($consulta)->execute([$id]);
    }
}
