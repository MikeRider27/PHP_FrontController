-- Migracion incremental: tasa de IVA por producto, y su registro historico en cada venta.
-- Se aplica sobre la base "inventario" ya existente (no recrea nada de lo actual).
-- Idempotente: se puede volver a correr sin duplicar datos ni romper si ya se aplico.

ALTER TABLE productos
    ADD COLUMN IF NOT EXISTS producto_iva_tasa SMALLINT NOT NULL DEFAULT 10;

DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.check_constraints
        WHERE constraint_name = 'productos_iva_tasa_check'
    ) THEN
        ALTER TABLE productos
            ADD CONSTRAINT productos_iva_tasa_check CHECK (producto_iva_tasa IN (0, 5, 10));
    END IF;
END $$;

-- Se registra la tasa vigente al momento de la venta, para que las facturas ya emitidas
-- no cambien si luego se modifica la clasificacion de IVA del producto.
ALTER TABLE detalle_venta
    ADD COLUMN IF NOT EXISTS detalle_venta_iva_tasa SMALLINT NOT NULL DEFAULT 10;

DO $$
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.check_constraints
        WHERE constraint_name = 'detalle_venta_iva_tasa_check'
    ) THEN
        ALTER TABLE detalle_venta
            ADD CONSTRAINT detalle_venta_iva_tasa_check CHECK (detalle_venta_iva_tasa IN (0, 5, 10));
    END IF;
END $$;
