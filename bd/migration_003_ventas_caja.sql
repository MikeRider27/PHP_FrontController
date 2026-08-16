-- Migracion incremental: modulos de Clientes, Caja (apertura/cierre de turno) y Ventas.
-- Se aplica sobre la base "inventario" ya existente (no recrea nada de lo actual).
-- Idempotente: se puede volver a correr sin duplicar datos ni romper si ya se aplico.

-- =========================================================
-- Clientes (opcional en la venta: NULL = Consumidor Final)
-- =========================================================

CREATE TABLE IF NOT EXISTS clientes (
    cliente_id SERIAL PRIMARY KEY,
    cliente_documento VARCHAR(20),
    cliente_razon_social VARCHAR(200) NOT NULL,
    cliente_telefono VARCHAR(50),
    cliente_email VARCHAR(200),
    cliente_direccion VARCHAR(300),
    estado_id INTEGER NOT NULL REFERENCES estados(estado_id)
);

-- =========================================================
-- Caja: turnos, movimientos manuales (ingresos/egresos)
-- =========================================================

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_turno_caja') THEN
        CREATE TYPE estado_turno_caja AS ENUM ('ABIERTO', 'CERRADO');
    END IF;
END $$;

CREATE TABLE IF NOT EXISTS turnos_caja (
    turno_id SERIAL PRIMARY KEY,
    usuario_apertura_id INTEGER NOT NULL REFERENCES usuarios(usuario_id),
    usuario_cierre_id INTEGER REFERENCES usuarios(usuario_id),
    turno_monto_inicial NUMERIC(12,2) NOT NULL DEFAULT 0,
    turno_monto_declarado NUMERIC(12,2),
    turno_monto_sistema NUMERIC(12,2),
    turno_diferencia NUMERIC(12,2),
    turno_estado estado_turno_caja NOT NULL DEFAULT 'ABIERTO',
    turno_fecha_apertura TIMESTAMP NOT NULL DEFAULT now(),
    turno_fecha_cierre TIMESTAMP,
    turno_observacion VARCHAR(300)
);

-- Solo puede existir un turno ABIERTO a la vez.
CREATE UNIQUE INDEX IF NOT EXISTS ux_turno_caja_abierto ON turnos_caja (turno_estado) WHERE turno_estado = 'ABIERTO';

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'tipo_movimiento_caja') THEN
        CREATE TYPE tipo_movimiento_caja AS ENUM ('INGRESO', 'EGRESO');
    END IF;
END $$;

CREATE TABLE IF NOT EXISTS movimientos_caja (
    movimiento_caja_id SERIAL PRIMARY KEY,
    turno_id INTEGER NOT NULL REFERENCES turnos_caja(turno_id),
    movimiento_caja_tipo tipo_movimiento_caja NOT NULL,
    movimiento_caja_monto NUMERIC(12,2) NOT NULL CHECK (movimiento_caja_monto > 0),
    movimiento_caja_motivo VARCHAR(300) NOT NULL,
    usuario_id INTEGER NOT NULL REFERENCES usuarios(usuario_id),
    movimiento_caja_fecha TIMESTAMP NOT NULL DEFAULT now()
);

CREATE INDEX IF NOT EXISTS idx_movimientos_caja_turno ON movimientos_caja(turno_id);

-- =========================================================
-- Ventas
-- =========================================================

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'estado_venta') THEN
        CREATE TYPE estado_venta AS ENUM ('CONFIRMADA', 'ANULADA');
    END IF;
END $$;

DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'forma_pago_venta') THEN
        CREATE TYPE forma_pago_venta AS ENUM ('EFECTIVO', 'TARJETA');
    END IF;
END $$;

CREATE TABLE IF NOT EXISTS ventas (
    venta_id SERIAL PRIMARY KEY,
    venta_numero VARCHAR(20) UNIQUE,
    cliente_id INTEGER REFERENCES clientes(cliente_id),
    usuario_id INTEGER NOT NULL REFERENCES usuarios(usuario_id),
    turno_id INTEGER NOT NULL REFERENCES turnos_caja(turno_id),
    venta_estado estado_venta NOT NULL DEFAULT 'CONFIRMADA',
    venta_forma_pago forma_pago_venta NOT NULL,
    venta_fecha TIMESTAMP NOT NULL DEFAULT now(),
    venta_fecha_anulacion TIMESTAMP,
    venta_motivo_anulacion VARCHAR(300)
);

CREATE INDEX IF NOT EXISTS idx_ventas_turno ON ventas(turno_id);

CREATE TABLE IF NOT EXISTS detalle_venta (
    detalle_venta_id SERIAL PRIMARY KEY,
    venta_id INTEGER NOT NULL REFERENCES ventas(venta_id),
    producto_id INTEGER NOT NULL REFERENCES productos(producto_id),
    detalle_venta_cantidad INTEGER NOT NULL CHECK (detalle_venta_cantidad > 0),
    detalle_venta_precio_unitario NUMERIC(12,2) NOT NULL DEFAULT 0
);

CREATE INDEX IF NOT EXISTS idx_detalle_venta ON detalle_venta(venta_id);
