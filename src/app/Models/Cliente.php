<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Cliente extends Model
{
    public function listar(string $filtro = ''): array
    {
        $consulta = "SELECT c.cliente_id, c.cliente_documento, c.cliente_razon_social,
                            c.cliente_telefono, c.cliente_email, c.cliente_direccion,
                            e.estado_descripcion
                     FROM clientes c
                     INNER JOIN estados e ON e.estado_id = c.estado_id
                     WHERE c.cliente_razon_social ILIKE ?
                     ORDER BY c.cliente_razon_social";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute(['%' . $filtro . '%']);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivos(): array
    {
        $consulta = "SELECT cliente_id, cliente_documento, cliente_razon_social
                     FROM clientes c
                     INNER JOIN estados e ON e.estado_id = c.estado_id
                     WHERE e.estado_descripcion = 'Activo'
                     ORDER BY cliente_razon_social";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener(int $id): ?array
    {
        $sentencia = $this->db->prepare('SELECT * FROM clientes WHERE cliente_id = ?');
        $sentencia->execute([$id]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function insertar(string $razonSocial, string $documento, string $telefono, string $email, string $direccion): int
    {
        $consulta = "INSERT INTO clientes (cliente_razon_social, cliente_documento, cliente_telefono, cliente_email, cliente_direccion, estado_id)
                     VALUES (?, ?, ?, ?, ?, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo'))";
        $this->db->prepare($consulta)->execute([$razonSocial, $documento, $telefono, $email, $direccion]);
        return (int) $this->db->lastInsertId('clientes_cliente_id_seq');
    }

    public function actualizar(int $id, string $razonSocial, string $documento, string $telefono, string $email, string $direccion): void
    {
        $consulta = 'UPDATE clientes SET cliente_razon_social = ?, cliente_documento = ?, cliente_telefono = ?, cliente_email = ?, cliente_direccion = ? WHERE cliente_id = ?';
        $this->db->prepare($consulta)->execute([$razonSocial, $documento, $telefono, $email, $direccion, $id]);
    }

    public function eliminar(int $id): void
    {
        $consulta = "UPDATE clientes SET estado_id = (SELECT estado_id FROM estados WHERE estado_descripcion = 'Inactivo') WHERE cliente_id = ?";
        $this->db->prepare($consulta)->execute([$id]);
    }
}
