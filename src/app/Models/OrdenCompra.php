<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class OrdenCompra extends Model
{
    public function listar(?string $estado = null): array
    {
        $consulta = "SELECT o.orden_id, o.orden_estado, o.orden_fecha, o.orden_fecha_recepcion,
                            p.proveedor_razon_social, u.usuario_nick,
                            COALESCE((SELECT SUM(d.detalle_cantidad * d.detalle_precio_costo_unitario)
                                      FROM detalle_orden_compra d WHERE d.orden_id = o.orden_id), 0) AS total
                     FROM ordenes_compra o
                     INNER JOIN proveedores p ON p.proveedor_id = o.proveedor_id
                     INNER JOIN usuarios u ON u.usuario_id = o.usuario_id";

        $params = [];
        if ($estado !== null && $estado !== '') {
            $consulta .= ' WHERE o.orden_estado = ?';
            $params[] = $estado;
        }

        $consulta .= ' ORDER BY o.orden_fecha DESC, o.orden_id DESC';

        $sentencia = $this->db->prepare($consulta);
        $sentencia->execute($params);
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerConDetalle(int $id): ?array
    {
        $sentencia = $this->db->prepare(
            "SELECT o.orden_id, o.orden_estado, o.orden_fecha, o.orden_fecha_recepcion,
                    o.proveedor_id, p.proveedor_razon_social, u.usuario_nick
             FROM ordenes_compra o
             INNER JOIN proveedores p ON p.proveedor_id = o.proveedor_id
             INNER JOIN usuarios u ON u.usuario_id = o.usuario_id
             WHERE o.orden_id = ?"
        );
        $sentencia->execute([$id]);
        $orden = $sentencia->fetch(PDO::FETCH_ASSOC);

        if (!$orden) {
            return null;
        }

        $sentencia = $this->db->prepare(
            "SELECT d.detalle_id, d.producto_id, pr.producto_codigo, pr.producto_nombre,
                    d.detalle_cantidad, d.detalle_precio_costo_unitario,
                    (d.detalle_cantidad * d.detalle_precio_costo_unitario) AS subtotal
             FROM detalle_orden_compra d
             INNER JOIN productos pr ON pr.producto_id = d.producto_id
             WHERE d.orden_id = ?
             ORDER BY d.detalle_id"
        );
        $sentencia->execute([$id]);
        $orden['detalle'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $orden['total'] = array_sum(array_column($orden['detalle'], 'subtotal'));

        return $orden;
    }

    /**
     * @param array<int, array{producto_id: int, cantidad: int, costo: float}> $lineas
     */
    public function crear(int $proveedorId, int $usuarioId, array $lineas): int
    {
        $this->db->beginTransaction();
        try {
            $this->db->prepare('INSERT INTO ordenes_compra (proveedor_id, usuario_id) VALUES (?, ?)')
                ->execute([$proveedorId, $usuarioId]);
            $ordenId = (int) $this->db->lastInsertId('ordenes_compra_orden_id_seq');

            $consulta = 'INSERT INTO detalle_orden_compra (orden_id, producto_id, detalle_cantidad, detalle_precio_costo_unitario) VALUES (?, ?, ?, ?)';
            $sentencia = $this->db->prepare($consulta);
            foreach ($lineas as $linea) {
                $sentencia->execute([$ordenId, $linea['producto_id'], $linea['cantidad'], $linea['costo']]);
            }

            $this->db->commit();
            return $ordenId;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function marcarRecibida(int $id, int $usuarioId): void
    {
        $this->db->beginTransaction();
        try {
            $sentencia = $this->db->prepare("SELECT orden_estado FROM ordenes_compra WHERE orden_id = ? FOR UPDATE");
            $sentencia->execute([$id]);
            $estado = $sentencia->fetchColumn();

            if ($estado !== 'PENDIENTE') {
                throw new \RuntimeException('La orden ya fue procesada.');
            }

            $sentencia = $this->db->prepare('SELECT producto_id, detalle_cantidad FROM detalle_orden_compra WHERE orden_id = ?');
            $sentencia->execute([$id]);
            $lineas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            $movimientos = new MovimientoStock();
            foreach ($lineas as $linea) {
                $movimientos->registrar(
                    (int) $linea['producto_id'],
                    'ENTRADA',
                    (int) $linea['detalle_cantidad'],
                    "Recepción orden de compra #$id",
                    $usuarioId
                );
            }

            $this->db->prepare("UPDATE ordenes_compra SET orden_estado = 'RECIBIDA', orden_fecha_recepcion = now() WHERE orden_id = ?")
                ->execute([$id]);

            $this->db->commit();
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function marcarCancelada(int $id): void
    {
        $this->db->prepare("UPDATE ordenes_compra SET orden_estado = 'CANCELADA' WHERE orden_id = ? AND orden_estado = 'PENDIENTE'")
            ->execute([$id]);
    }
}
