<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Categoria extends Model
{
    public function listar(string $filtro = ''): array
    {
        $consulta = "SELECT c.categoria_id, c.categoria_nombre, c.categoria_descripcion, e.estado_descripcion
                     FROM categorias c
                     INNER JOIN estados e ON e.estado_id = c.estado_id
                     WHERE c.categoria_nombre ILIKE ?
                     ORDER BY c.categoria_nombre";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute(['%' . $filtro . '%']);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarActivas(): array
    {
        $consulta = "SELECT categoria_id, categoria_nombre
                     FROM categorias c
                     INNER JOIN estados e ON e.estado_id = c.estado_id
                     WHERE e.estado_descripcion = 'Activo'
                     ORDER BY categoria_nombre";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener(int $id): ?array
    {
        $sentencia = $this->db->prepare('SELECT * FROM categorias WHERE categoria_id = ?');
        $sentencia->execute([$id]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function insertar(string $nombre, string $descripcion): void
    {
        $consulta = "INSERT INTO categorias (categoria_nombre, categoria_descripcion, estado_id)
                     VALUES (?, ?, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo'))";
        $this->db->prepare($consulta)->execute([$nombre, $descripcion]);
    }

    public function actualizar(int $id, string $nombre, string $descripcion): void
    {
        $consulta = 'UPDATE categorias SET categoria_nombre = ?, categoria_descripcion = ? WHERE categoria_id = ?';
        $this->db->prepare($consulta)->execute([$nombre, $descripcion, $id]);
    }

    public function eliminar(int $id): void
    {
        $consulta = "UPDATE categorias SET estado_id = (SELECT estado_id FROM estados WHERE estado_descripcion = 'Inactivo') WHERE categoria_id = ?";
        $this->db->prepare($consulta)->execute([$id]);
    }
}
