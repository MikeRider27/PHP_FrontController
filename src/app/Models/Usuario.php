<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Usuario extends Model
{
    public function validarCredenciales(string $nick, string $clave): ?array
    {
        $consulta = "SELECT u.usuario_id, u.usuario_nick, u.usuario_email, u.usuario_password,
                            r.rol_id, r.rol_descripcion,
                            p.persona_nombre, p.persona_apellido
                     FROM usuarios u
                     INNER JOIN roles r ON r.rol_id = u.rol_id
                     INNER JOIN personas p ON p.persona_id = u.persona_id
                     INNER JOIN estados e ON e.estado_id = u.estado_id
                     WHERE u.usuario_nick = ? AND e.estado_descripcion = 'Activo'";

        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([$nick]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($fila && password_verify($clave, $fila['usuario_password'])) {
            return [
                'usuario_id' => (int) $fila['usuario_id'],
                'usuario_nick' => $fila['usuario_nick'],
                'usuario_email' => $fila['usuario_email'],
                'rol_id' => (int) $fila['rol_id'],
                'rol_descripcion' => $fila['rol_descripcion'],
                'nombre_completo' => trim($fila['persona_nombre'] . ' ' . $fila['persona_apellido']),
            ];
        }

        return null;
    }

    public function listar(): array
    {
        $consulta = "SELECT u.usuario_id, u.usuario_nick, u.usuario_email, u.rol_id, r.rol_descripcion,
                            p.persona_id, p.persona_cedula, p.persona_nombre, p.persona_apellido,
                            e.estado_descripcion
                     FROM usuarios u
                     INNER JOIN roles r ON r.rol_id = u.rol_id
                     INNER JOIN personas p ON p.persona_id = u.persona_id
                     INNER JOIN estados e ON e.estado_id = u.estado_id
                     ORDER BY p.persona_nombre, p.persona_apellido";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarRoles(): array
    {
        return $this->db->query('SELECT rol_id, rol_descripcion FROM roles ORDER BY rol_descripcion')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtener(int $id): ?array
    {
        $consulta = "SELECT u.usuario_id, u.usuario_nick, u.usuario_email, u.rol_id,
                            p.persona_id, p.persona_cedula, p.persona_nombre, p.persona_apellido
                     FROM usuarios u
                     INNER JOIN personas p ON p.persona_id = u.persona_id
                     WHERE u.usuario_id = ?";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([$id]);
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    public function insertar(string $cedula, string $nombre, string $apellido, string $nick, string $email, string $password, int $rolId): void
    {
        $this->db->beginTransaction();
        try {
            $this->db->prepare('INSERT INTO personas (persona_cedula, persona_nombre, persona_apellido) VALUES (?, ?, ?)')
                ->execute([$cedula, $nombre, $apellido]);
            $personaId = (int) $this->db->lastInsertId('personas_persona_id_seq');

            $consulta = "INSERT INTO usuarios (persona_id, usuario_nick, usuario_email, usuario_password, rol_id, estado_id)
                         VALUES (?, ?, ?, ?, ?, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo'))";
            $this->db->prepare($consulta)->execute([
                $personaId, $nick, $email, password_hash($password, PASSWORD_BCRYPT), $rolId,
            ]);

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function actualizar(int $id, string $cedula, string $nombre, string $apellido, string $nick, string $email, ?string $password, int $rolId): void
    {
        $this->db->beginTransaction();
        try {
            $datos = $this->obtener($id);
            if ($datos === null) {
                throw new \RuntimeException("Usuario $id no existe");
            }

            $this->db->prepare('UPDATE personas SET persona_cedula = ?, persona_nombre = ?, persona_apellido = ? WHERE persona_id = ?')
                ->execute([$cedula, $nombre, $apellido, $datos['persona_id']]);

            if ($password !== null && $password !== '') {
                $this->db->prepare('UPDATE usuarios SET usuario_nick = ?, usuario_email = ?, rol_id = ?, usuario_password = ? WHERE usuario_id = ?')
                    ->execute([$nick, $email, $rolId, password_hash($password, PASSWORD_BCRYPT), $id]);
            } else {
                $this->db->prepare('UPDATE usuarios SET usuario_nick = ?, usuario_email = ?, rol_id = ? WHERE usuario_id = ?')
                    ->execute([$nick, $email, $rolId, $id]);
            }

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function eliminar(int $id): void
    {
        $consulta = "UPDATE usuarios SET estado_id = (SELECT estado_id FROM estados WHERE estado_descripcion = 'Inactivo') WHERE usuario_id = ?";
        $this->db->prepare($consulta)->execute([$id]);
    }
}
