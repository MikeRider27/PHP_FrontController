-- Esquema completo del Sistema de Inventario
-- PostgreSQL. Script canonico para una instalacion nueva (base vacia).
-- Para aplicar cambios incrementales sobre una base ya existente, ver
-- las migraciones bd/migration_*.sql.

-- =========================================================
-- Autenticacion / usuarios
-- =========================================================

CREATE TABLE estados (
    estado_id SERIAL PRIMARY KEY,
    estado_descripcion VARCHAR(200) NOT NULL
);

CREATE TABLE roles (
    rol_id SERIAL PRIMARY KEY,
    rol_descripcion VARCHAR(200) NOT NULL
);

CREATE TABLE personas (
    persona_id SERIAL PRIMARY KEY,
    persona_cedula VARCHAR(20) NOT NULL,
    persona_nombre VARCHAR(200) NOT NULL,
    persona_apellido VARCHAR(200) NOT NULL,
    persona_genero CHAR(1),
    persona_fechanacimiento DATE
);

CREATE TABLE usuarios (
    usuario_id SERIAL PRIMARY KEY,
    persona_id INTEGER NOT NULL REFERENCES personas(persona_id),
    usuario_nick VARCHAR(50) NOT NULL UNIQUE,
    usuario_email VARCHAR(300) NOT NULL,
    usuario_password VARCHAR(250) NOT NULL,
    rol_id INTEGER NOT NULL REFERENCES roles(rol_id),
    estado_id INTEGER NOT NULL REFERENCES estados(estado_id)
);

-- =========================================================
-- Inventario
-- =========================================================

CREATE TABLE categorias (
    categoria_id SERIAL PRIMARY KEY,
    categoria_nombre VARCHAR(100) NOT NULL,
    categoria_descripcion VARCHAR(300),
    estado_id INTEGER NOT NULL REFERENCES estados(estado_id)
);

CREATE TABLE proveedores (
    proveedor_id SERIAL PRIMARY KEY,
    proveedor_razon_social VARCHAR(200) NOT NULL,
    proveedor_ruc VARCHAR(20),
    proveedor_telefono VARCHAR(50),
    proveedor_email VARCHAR(200),
    proveedor_direccion VARCHAR(300),
    estado_id INTEGER NOT NULL REFERENCES estados(estado_id)
);

CREATE TABLE productos (
    producto_id SERIAL PRIMARY KEY,
    producto_codigo VARCHAR(50) NOT NULL UNIQUE,
    producto_nombre VARCHAR(200) NOT NULL,
    producto_descripcion VARCHAR(500),
    categoria_id INTEGER NOT NULL REFERENCES categorias(categoria_id),
    proveedor_id INTEGER REFERENCES proveedores(proveedor_id),
    producto_precio_costo NUMERIC(12,2) NOT NULL DEFAULT 0,
    producto_precio_venta NUMERIC(12,2) NOT NULL DEFAULT 0,
    producto_stock_actual INTEGER NOT NULL DEFAULT 0,
    producto_stock_minimo INTEGER NOT NULL DEFAULT 0,
    estado_id INTEGER NOT NULL REFERENCES estados(estado_id)
);

CREATE TYPE tipo_movimiento AS ENUM ('ENTRADA', 'SALIDA', 'AJUSTE');

CREATE TABLE movimientos_stock (
    movimiento_id SERIAL PRIMARY KEY,
    producto_id INTEGER NOT NULL REFERENCES productos(producto_id),
    movimiento_tipo tipo_movimiento NOT NULL,
    -- Para ENTRADA/SALIDA: cantidad a sumar/restar. Para AJUSTE: stock final absoluto.
    movimiento_cantidad INTEGER NOT NULL CHECK (movimiento_cantidad >= 0),
    movimiento_stock_anterior INTEGER NOT NULL,
    movimiento_stock_nuevo INTEGER NOT NULL,
    movimiento_motivo VARCHAR(300),
    usuario_id INTEGER NOT NULL REFERENCES usuarios(usuario_id),
    movimiento_fecha TIMESTAMP NOT NULL DEFAULT now()
);

CREATE INDEX idx_movimientos_producto ON movimientos_stock(producto_id);

-- Mantiene productos.producto_stock_actual siempre consistente con el
-- historial de movimientos: se calcula aca, no en el codigo PHP.
CREATE OR REPLACE FUNCTION fn_registrar_movimiento_stock() RETURNS TRIGGER AS $$
DECLARE
    v_stock_actual INTEGER;
BEGIN
    SELECT producto_stock_actual INTO v_stock_actual
    FROM productos
    WHERE producto_id = NEW.producto_id
    FOR UPDATE;

    IF v_stock_actual IS NULL THEN
        RAISE EXCEPTION 'Producto % no existe', NEW.producto_id;
    END IF;

    NEW.movimiento_stock_anterior := v_stock_actual;

    IF NEW.movimiento_tipo = 'ENTRADA' THEN
        NEW.movimiento_stock_nuevo := v_stock_actual + NEW.movimiento_cantidad;
    ELSIF NEW.movimiento_tipo = 'SALIDA' THEN
        IF v_stock_actual < NEW.movimiento_cantidad THEN
            RAISE EXCEPTION 'Stock insuficiente: disponible %, solicitado %', v_stock_actual, NEW.movimiento_cantidad;
        END IF;
        NEW.movimiento_stock_nuevo := v_stock_actual - NEW.movimiento_cantidad;
    ELSE -- AJUSTE: la cantidad representa el nuevo stock absoluto
        NEW.movimiento_stock_nuevo := NEW.movimiento_cantidad;
    END IF;

    UPDATE productos
    SET producto_stock_actual = NEW.movimiento_stock_nuevo
    WHERE producto_id = NEW.producto_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_movimiento_stock
    BEFORE INSERT ON movimientos_stock
    FOR EACH ROW
    EXECUTE FUNCTION fn_registrar_movimiento_stock();

-- =========================================================
-- Compras
-- =========================================================

CREATE TYPE estado_orden_compra AS ENUM ('PENDIENTE', 'RECIBIDA', 'CANCELADA');

CREATE TABLE ordenes_compra (
    orden_id SERIAL PRIMARY KEY,
    proveedor_id INTEGER NOT NULL REFERENCES proveedores(proveedor_id),
    usuario_id INTEGER NOT NULL REFERENCES usuarios(usuario_id),
    orden_estado estado_orden_compra NOT NULL DEFAULT 'PENDIENTE',
    orden_fecha TIMESTAMP NOT NULL DEFAULT now(),
    orden_fecha_recepcion TIMESTAMP
);

CREATE TABLE detalle_orden_compra (
    detalle_id SERIAL PRIMARY KEY,
    orden_id INTEGER NOT NULL REFERENCES ordenes_compra(orden_id),
    producto_id INTEGER NOT NULL REFERENCES productos(producto_id),
    detalle_cantidad INTEGER NOT NULL CHECK (detalle_cantidad > 0),
    detalle_precio_costo_unitario NUMERIC(12,2) NOT NULL DEFAULT 0
);

CREATE INDEX idx_detalle_orden ON detalle_orden_compra(orden_id);

-- =========================================================
-- Datos base
-- =========================================================

INSERT INTO estados (estado_descripcion) VALUES ('Activo'), ('Inactivo');
INSERT INTO roles (rol_descripcion) VALUES ('Administrador'), ('Operador');

INSERT INTO personas (persona_cedula, persona_nombre, persona_apellido, persona_genero, persona_fechanacimiento)
VALUES ('0000000', 'Miguel', 'Villalba', 'M', '1991-05-01');

-- Usuario de prueba -> nick: admin / password: admin123
-- Hash generado con password_hash('admin123', PASSWORD_BCRYPT)
INSERT INTO usuarios (persona_id, usuario_nick, usuario_email, usuario_password, rol_id, estado_id)
VALUES (
    (SELECT persona_id FROM personas WHERE persona_cedula = '0000000'),
    'admin',
    'admin@example.com',
    '$2y$10$yKeglBVW0zOriBNbkPFe.eWcXuJXWkpH9YN/jLmBXYrQ3yB8cSF8W',
    (SELECT rol_id FROM roles WHERE rol_descripcion = 'Administrador'),
    (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo')
);

INSERT INTO categorias (categoria_nombre, categoria_descripcion, estado_id)
VALUES ('General', 'Categoria por defecto', (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo'));
