-- Migracion incremental: rol Operador + modulo de Ordenes de Compra.
-- Se aplica sobre la base "inventario" ya existente (no recrea nada de lo actual).
-- Idempotente: se puede volver a correr sin duplicar datos ni romper si ya se aplico.

INSERT INTO roles (rol_descripcion)
SELECT 'Operador'
WHERE NOT EXISTS (SELECT 1 FROM roles WHERE rol_descripcion = 'Operador');

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_orden_compra') THEN
        CREATE TYPE estado_orden_compra AS ENUM ('PENDIENTE', 'RECIBIDA', 'CANCELADA');
    END IF;
END $$;

CREATE TABLE IF NOT EXISTS ordenes_compra (
    orden_id SERIAL PRIMARY KEY,
    proveedor_id INTEGER NOT NULL REFERENCES proveedores(proveedor_id),
    usuario_id INTEGER NOT NULL REFERENCES usuarios(usuario_id),
    orden_estado estado_orden_compra NOT NULL DEFAULT 'PENDIENTE',
    orden_fecha TIMESTAMP NOT NULL DEFAULT now(),
    orden_fecha_recepcion TIMESTAMP
);

CREATE TABLE IF NOT EXISTS detalle_orden_compra (
    detalle_id SERIAL PRIMARY KEY,
    orden_id INTEGER NOT NULL REFERENCES ordenes_compra(orden_id),
    producto_id INTEGER NOT NULL REFERENCES productos(producto_id),
    detalle_cantidad INTEGER NOT NULL CHECK (detalle_cantidad > 0),
    detalle_precio_costo_unitario NUMERIC(12,2) NOT NULL DEFAULT 0
);

CREATE INDEX IF NOT EXISTS idx_detalle_orden ON detalle_orden_compra(orden_id);
