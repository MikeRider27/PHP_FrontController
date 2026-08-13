<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class MovimientoStock extends Model
{
    public function listar(?int $productoId = null): array
    {
        $consulta = "SELECT m.movimiento_id, m.producto_id, pr.producto_nombre, m.movimiento_tipo,
                            m.movimiento_cantidad, m.movimiento_stock_anterior, m.movimiento_stock_nuevo,
                            m.movimiento_motivo, m.movimiento_fecha, u.usuario_nick
                     FROM movimientos_stock m
                     INNER JOIN productos pr ON pr.producto_id = m.producto_id
                     INNER JOIN usuarios u ON u.usuario_id = m.usuario_id";

        $params = [];
        if ($productoId !== null) {
            $consulta .= ' WHERE m.producto_id = ?';
            $params[] = $productoId;
        }

        $consulta .= ' ORDER BY m.movimiento_fecha DESC, m.movimiento_id DESC LIMIT 200';

        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute($params);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @throws \PDOException si el trigger de la base de datos rechaza el movimiento
     *         (por ejemplo, stock insuficiente para una SALIDA).
     */
    public function registrar(int $productoId, string $tipo, int $cantidad, string $motivo, int $usuarioId): void
    {
        $consulta = "INSERT INTO movimientos_stock
                        (producto_id, movimiento_tipo, movimiento_cantidad, movimiento_stock_anterior, movimiento_stock_nuevo, movimiento_motivo, usuario_id)
                     VALUES (?, ?, ?, 0, 0, ?, ?)";
        $this->db->prepare($consulta)->execute([$productoId, $tipo, $cantidad, $motivo, $usuarioId]);
    }

    public function listarPorFecha(string $desde, string $hasta, ?string $tipo = null): array
    {
        $consulta = "SELECT m.movimiento_id, m.producto_id, pr.producto_nombre, m.movimiento_tipo,
                            m.movimiento_cantidad, m.movimiento_stock_anterior, m.movimiento_stock_nuevo,
                            m.movimiento_motivo, m.movimiento_fecha, u.usuario_nick
                     FROM movimientos_stock m
                     INNER JOIN productos pr ON pr.producto_id = m.producto_id
                     INNER JOIN usuarios u ON u.usuario_id = m.usuario_id
                     WHERE m.movimiento_fecha >= ? AND m.movimiento_fecha < (?::date + INTERVAL '1 day')";

        $params = [$desde, $hasta];
        if ($tipo !== null && $tipo !== '') {
            $consulta .= ' AND m.movimiento_tipo = ?';
            $params[] = $tipo;
        }

        $consulta .= ' ORDER BY m.movimiento_fecha DESC, m.movimiento_id DESC';

        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute($params);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function productosMasMovidos(string $desde, string $hasta, int $limite = 10): array
    {
        // Se usa la diferencia real de stock (no movimiento_cantidad cruda), porque en un
        // AJUSTE esa columna guarda el stock absoluto final, no una cantidad movida.
        $consulta = "SELECT pr.producto_id, pr.producto_codigo, pr.producto_nombre,
                            SUM(ABS(m.movimiento_stock_nuevo - m.movimiento_stock_anterior)) AS total_movido,
                            COUNT(*) AS cantidad_movimientos
                     FROM movimientos_stock m
                     INNER JOIN productos pr ON pr.producto_id = m.producto_id
                     WHERE m.movimiento_fecha >= ? AND m.movimiento_fecha < (?::date + INTERVAL '1 day')
                     GROUP BY pr.producto_id, pr.producto_codigo, pr.producto_nombre
                     ORDER BY total_movido DESC
                     LIMIT ?";
        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute([$desde, $hasta, $limite]);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
}
