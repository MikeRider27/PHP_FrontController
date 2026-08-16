<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Venta extends Model
{
    public function listar(?string $estado = null, ?string $desde = null, ?string $hasta = null): array
    {
        $consulta = "SELECT v.venta_id, v.venta_numero, v.venta_estado, v.venta_forma_pago, v.venta_fecha,
                            COALESCE(c.cliente_razon_social, 'Consumidor Final') AS cliente_razon_social,
                            u.usuario_nick,
                            COALESCE((SELECT SUM(dv.detalle_venta_cantidad * dv.detalle_venta_precio_unitario)
                                      FROM detalle_venta dv WHERE dv.venta_id = v.venta_id), 0) AS total
                     FROM ventas v
                     LEFT JOIN clientes c ON c.cliente_id = v.cliente_id
                     INNER JOIN usuarios u ON u.usuario_id = v.usuario_id
                     WHERE 1 = 1";

        $params = [];
        if ($estado !== null && $estado !== '') {
            $consulta .= ' AND v.venta_estado = ?';
            $params[] = $estado;
        }
        if ($desde !== null && $desde !== '') {
            $consulta .= " AND v.venta_fecha >= ?";
            $params[] = $desde;
        }
        if ($hasta !== null && $hasta !== '') {
            $consulta .= " AND v.venta_fecha < (?::date + INTERVAL '1 day')";
            $params[] = $hasta;
        }

        $consulta .= ' ORDER BY v.venta_fecha DESC, v.venta_id DESC';

        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute($params);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerConDetalle(int $id): ?array
    {
        $sentencia = $this->db->prepare(
            "SELECT v.venta_id, v.venta_numero, v.venta_estado, v.venta_forma_pago, v.venta_fecha,
                    v.venta_fecha_anulacion, v.venta_motivo_anulacion, v.turno_id,
                    COALESCE(c.cliente_razon_social, 'Consumidor Final') AS cliente_razon_social,
                    c.cliente_documento, c.cliente_telefono, c.cliente_direccion,
                    u.usuario_nick
             FROM ventas v
             LEFT JOIN clientes c ON c.cliente_id = v.cliente_id
             INNER JOIN usuarios u ON u.usuario_id = v.usuario_id
             WHERE v.venta_id = ?"
        );
        $sentencia->execute([$id]);
        $venta = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (!$venta) {
            return null;
        }

        $sentencia = $this->db->prepare(
            "SELECT dv.detalle_venta_id, dv.producto_id, pr.producto_codigo, pr.producto_nombre,
                    dv.detalle_venta_cantidad, dv.detalle_venta_precio_unitario, dv.detalle_venta_iva_tasa,
                    (dv.detalle_venta_cantidad * dv.detalle_venta_precio_unitario) AS subtotal
             FROM detalle_venta dv
             INNER JOIN productos pr ON pr.producto_id = dv.producto_id
             WHERE dv.venta_id = ?
             ORDER BY dv.detalle_venta_id"
        );
        $sentencia->execute([$id]);
        $venta['detalle'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $venta['total'] = array_sum(array_column($venta['detalle'], 'subtotal'));

        return $venta;
    }

    /**
     * @param array<int, array{producto_id: int, cantidad: int, precio: float}> $lineas
     * @throws \PDOException si el trigger de stock rechaza alguna linea (stock insuficiente)
     */
    public function crear(?int $clienteId, int $usuarioId, int $turnoId, string $formaPago, array $lineas): int
    {
        $this->db->beginTransaction();
        try {
            $this->db->prepare('INSERT INTO ventas (cliente_id, usuario_id, turno_id, venta_forma_pago) VALUES (?, ?, ?, ?)')
                ->execute([$clienteId, $usuarioId, $turnoId, $formaPago]);
            $ventaId = (int) $this->db->lastInsertId('ventas_venta_id_seq');

            $consulta = 'INSERT INTO detalle_venta (venta_id, producto_id, detalle_venta_cantidad, detalle_venta_precio_unitario, detalle_venta_iva_tasa)
                         VALUES (?, ?, ?, ?, (SELECT producto_iva_tasa FROM productos WHERE producto_id = ?))';
            $sentencia = $this->db->prepare($consulta);
            $movimientos = new MovimientoStock();
            foreach ($lineas as $linea) {
                $sentencia->execute([$ventaId, $linea['producto_id'], $linea['cantidad'], $linea['precio'], $linea['producto_id']]);
                $movimientos->registrar(
                    $linea['producto_id'],
                    'SALIDA',
                    $linea['cantidad'],
                    "Venta #$ventaId",
                    $usuarioId
                );
            }

            $numero = 'VTA-' . str_pad((string) $ventaId, 6, '0', STR_PAD_LEFT);
            $this->db->prepare('UPDATE ventas SET venta_numero = ? WHERE venta_id = ?')->execute([$numero, $ventaId]);

            $this->db->commit();
            return $ventaId;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function anular(int $id, int $usuarioId, string $motivo): void
    {
        $this->db->beginTransaction();
        try {
            $sentencia = $this->db->prepare("SELECT venta_estado, venta_numero FROM ventas WHERE venta_id = ? FOR UPDATE");
            $sentencia->execute([$id]);
            $venta = $sentencia->fetch(PDO::FETCH_ASSOC);

            if (!$venta || $venta['venta_estado'] !== 'CONFIRMADA') {
                throw new \RuntimeException('La venta ya fue anulada o no existe.');
            }

            $sentencia = $this->db->prepare('SELECT producto_id, detalle_venta_cantidad FROM detalle_venta WHERE venta_id = ?');
            $sentencia->execute([$id]);
            $lineas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            $movimientos = new MovimientoStock();
            foreach ($lineas as $linea) {
                $movimientos->registrar(
                    (int) $linea['producto_id'],
                    'ENTRADA',
                    (int) $linea['detalle_venta_cantidad'],
                    "Reversión anulación venta #{$venta['venta_numero']}",
                    $usuarioId
                );
            }

            $this->db->prepare(
                "UPDATE ventas SET venta_estado = 'ANULADA', venta_fecha_anulacion = now(), venta_motivo_anulacion = ? WHERE venta_id = ?"
            )->execute([$motivo, $id]);

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
