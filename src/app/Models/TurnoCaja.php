<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class TurnoCaja extends Model
{
    public function obtenerAbierto(): ?array
    {
        $sentencia = $this->db->prepare(
            "SELECT t.turno_id, t.turno_monto_inicial, t.turno_fecha_apertura, u.usuario_nick AS usuario_apertura_nick
             FROM turnos_caja t
             INNER JOIN usuarios u ON u.usuario_id = t.usuario_apertura_id
             WHERE t.turno_estado = 'ABIERTO'"
        );
        $sentencia->execute();
        $fila = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $fila ?: null;
    }

    /**
     * @throws \PDOException si ya hay un turno abierto (indice unico ux_turno_caja_abierto)
     */
    public function abrir(int $usuarioId, float $montoInicial): int
    {
        $this->db->prepare('INSERT INTO turnos_caja (usuario_apertura_id, turno_monto_inicial) VALUES (?, ?)')
            ->execute([$usuarioId, $montoInicial]);
        return (int) $this->db->lastInsertId('turnos_caja_turno_id_seq');
    }

    public function cerrar(int $turnoId, int $usuarioId, float $montoDeclarado, ?string $observacion): void
    {
        $this->db->beginTransaction();
        try {
            $sentencia = $this->db->prepare("SELECT turno_estado, turno_monto_inicial FROM turnos_caja WHERE turno_id = ? FOR UPDATE");
            $sentencia->execute([$turnoId]);
            $turno = $sentencia->fetch(PDO::FETCH_ASSOC);

            if (!$turno || $turno['turno_estado'] !== 'ABIERTO') {
                throw new \RuntimeException('El turno no está abierto.');
            }

            $sentencia = $this->db->prepare(
                "SELECT COALESCE(SUM(v.total), 0) FROM (
                    SELECT dv.venta_id, SUM(dv.detalle_venta_cantidad * dv.detalle_venta_precio_unitario) AS total
                    FROM ventas ve
                    INNER JOIN detalle_venta dv ON dv.venta_id = ve.venta_id
                    WHERE ve.turno_id = ? AND ve.venta_estado = 'CONFIRMADA' AND ve.venta_forma_pago = 'EFECTIVO'
                    GROUP BY dv.venta_id
                 ) v"
            );
            $sentencia->execute([$turnoId]);
            $totalVentasEfectivo = (float) $sentencia->fetchColumn();

            $sentencia = $this->db->prepare(
                "SELECT COALESCE(SUM(CASE WHEN movimiento_caja_tipo = 'INGRESO' THEN movimiento_caja_monto ELSE -movimiento_caja_monto END), 0)
                 FROM movimientos_caja WHERE turno_id = ?"
            );
            $sentencia->execute([$turnoId]);
            $netoMovimientos = (float) $sentencia->fetchColumn();

            $montoSistema = (float) $turno['turno_monto_inicial'] + $totalVentasEfectivo + $netoMovimientos;
            $diferencia = $montoDeclarado - $montoSistema;

            $this->db->prepare(
                "UPDATE turnos_caja
                 SET turno_estado = 'CERRADO', usuario_cierre_id = ?, turno_monto_declarado = ?,
                     turno_monto_sistema = ?, turno_diferencia = ?, turno_observacion = ?, turno_fecha_cierre = now()
                 WHERE turno_id = ?"
            )->execute([$usuarioId, $montoDeclarado, $montoSistema, $diferencia, $observacion, $turnoId]);

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function registrarMovimiento(int $turnoId, string $tipo, float $monto, string $motivo, int $usuarioId): void
    {
        $consulta = 'INSERT INTO movimientos_caja (turno_id, movimiento_caja_tipo, movimiento_caja_monto, movimiento_caja_motivo, usuario_id) VALUES (?, ?, ?, ?, ?)';
        $this->db->prepare($consulta)->execute([$turnoId, $tipo, $monto, $motivo, $usuarioId]);
    }

    public function listar(): array
    {
        $consulta = "SELECT t.turno_id, t.turno_estado, t.turno_monto_inicial, t.turno_monto_declarado,
                            t.turno_monto_sistema, t.turno_diferencia, t.turno_fecha_apertura, t.turno_fecha_cierre,
                            ua.usuario_nick AS usuario_apertura_nick, uc.usuario_nick AS usuario_cierre_nick
                     FROM turnos_caja t
                     INNER JOIN usuarios ua ON ua.usuario_id = t.usuario_apertura_id
                     LEFT JOIN usuarios uc ON uc.usuario_id = t.usuario_cierre_id
                     ORDER BY t.turno_fecha_apertura DESC";
        return $this->db->query($consulta)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerConDetalle(int $id): ?array
    {
        $sentencia = $this->db->prepare(
            "SELECT t.turno_id, t.turno_estado, t.turno_monto_inicial, t.turno_monto_declarado,
                    t.turno_monto_sistema, t.turno_diferencia, t.turno_observacion,
                    t.turno_fecha_apertura, t.turno_fecha_cierre,
                    ua.usuario_nick AS usuario_apertura_nick, uc.usuario_nick AS usuario_cierre_nick
             FROM turnos_caja t
             INNER JOIN usuarios ua ON ua.usuario_id = t.usuario_apertura_id
             LEFT JOIN usuarios uc ON uc.usuario_id = t.usuario_cierre_id
             WHERE t.turno_id = ?"
        );
        $sentencia->execute([$id]);
        $turno = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (!$turno) {
            return null;
        }

        $sentencia = $this->db->prepare(
            "SELECT ve.venta_id, ve.venta_numero, ve.venta_estado, ve.venta_forma_pago, ve.venta_fecha,
                    COALESCE((SELECT SUM(dv.detalle_venta_cantidad * dv.detalle_venta_precio_unitario)
                              FROM detalle_venta dv WHERE dv.venta_id = ve.venta_id), 0) AS total
             FROM ventas ve
             WHERE ve.turno_id = ?
             ORDER BY ve.venta_fecha"
        );
        $sentencia->execute([$id]);
        $turno['ventas'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        $sentencia = $this->db->prepare(
            "SELECT mc.movimiento_caja_id, mc.movimiento_caja_tipo, mc.movimiento_caja_monto,
                    mc.movimiento_caja_motivo, mc.movimiento_caja_fecha, u.usuario_nick
             FROM movimientos_caja mc
             INNER JOIN usuarios u ON u.usuario_id = mc.usuario_id
             WHERE mc.turno_id = ?
             ORDER BY mc.movimiento_caja_fecha"
        );
        $sentencia->execute([$id]);
        $turno['movimientos'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

        return $turno;
    }
}
