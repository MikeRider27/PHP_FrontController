-- Datos de prueba (fake) para el Sistema de Inventario.
-- Se puede correr las veces que haga falta durante desarrollo; no toca
-- estados/roles/usuarios ni el registro de la categoria "General".

-- =========================================================
-- Categorias
-- =========================================================
INSERT INTO categorias (categoria_nombre, categoria_descripcion, estado_id)
SELECT v.nombre, v.descripcion, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo')
FROM (VALUES
    ('Electrónica', 'Equipos y accesorios electrónicos'),
    ('Oficina', 'Útiles e insumos de oficina'),
    ('Limpieza', 'Productos de limpieza e higiene'),
    ('Alimentos', 'Víveres y productos consumibles'),
    ('Ferretería', 'Herramientas y materiales de ferretería')
) AS v(nombre, descripcion)
WHERE NOT EXISTS (SELECT 1 FROM categorias c WHERE c.categoria_nombre = v.nombre);

-- =========================================================
-- Proveedores
-- =========================================================
INSERT INTO proveedores (proveedor_razon_social, proveedor_ruc, proveedor_telefono, proveedor_email, proveedor_direccion, estado_id)
SELECT v.razon_social, v.ruc, v.telefono, v.email, v.direccion, (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo')
FROM (VALUES
    ('Tecno Insumos S.A.', '80012345-6', '021-555-0101', 'ventas@tecnoinsumos.com.py', 'Av. Mcal. López 1234, Asunción'),
    ('Distribuidora Central', '80023456-7', '021-555-0202', 'contacto@districentral.com.py', 'Av. Eusebio Ayala 2200, Asunción'),
    ('ImportPy S.R.L.', '80034567-8', '021-555-0303', 'info@importpy.com.py', 'Av. Aviadores del Chaco 550, Asunción'),
    ('Suministros del Este', '80045678-9', '061-555-0404', 'pedidos@suminest.com.py', 'Ruta 7 Km 12, Ciudad del Este'),
    ('Comercial Andina', '80056789-0', '021-555-0505', 'comercial@andina.com.py', 'Av. Fernando de la Mora 890, Asunción')
) AS v(razon_social, ruc, telefono, email, direccion)
WHERE NOT EXISTS (SELECT 1 FROM proveedores p WHERE p.proveedor_razon_social = v.razon_social);

-- =========================================================
-- Productos
-- =========================================================
INSERT INTO productos (
    producto_codigo, producto_nombre, producto_descripcion, categoria_id, proveedor_id,
    producto_precio_costo, producto_precio_venta, producto_stock_actual, producto_stock_minimo, estado_id
)
SELECT
    v.codigo, v.nombre, v.descripcion,
    (SELECT categoria_id FROM categorias WHERE categoria_nombre = v.categoria),
    (SELECT proveedor_id FROM proveedores WHERE proveedor_razon_social = v.proveedor),
    v.precio_costo, v.precio_venta, 0, v.stock_minimo,
    (SELECT estado_id FROM estados WHERE estado_descripcion = 'Activo')
FROM (VALUES
    ('ELEC-001', 'Mouse Óptico USB', 'Mouse óptico con cable USB', 'Electrónica', 'Tecno Insumos S.A.', 25000, 45000, 10),
    ('ELEC-002', 'Teclado USB Estándar', 'Teclado alámbrico 104 teclas', 'Electrónica', 'Tecno Insumos S.A.', 40000, 70000, 8),
    ('ELEC-003', 'Monitor LED 21"', 'Monitor LED Full HD 21 pulgadas', 'Electrónica', 'Tecno Insumos S.A.', 650000, 950000, 3),
    ('ELEC-004', 'Cable HDMI 2m', 'Cable HDMI 2 metros', 'Electrónica', 'Tecno Insumos S.A.', 15000, 30000, 15),
    ('ELEC-005', 'Pendrive 32GB', 'Memoria USB 32GB', 'Electrónica', 'Tecno Insumos S.A.', 35000, 60000, 20),

    ('OFIC-001', 'Resma de Papel A4', 'Papel bond A4 75g x500 hojas', 'Oficina', 'Distribuidora Central', 22000, 35000, 25),
    ('OFIC-002', 'Bolígrafo Azul (caja x50)', 'Caja de 50 bolígrafos color azul', 'Oficina', 'Distribuidora Central', 30000, 55000, 10),
    ('OFIC-003', 'Carpeta Archivadora', 'Carpeta lomo ancho tamaño oficio', 'Oficina', 'Distribuidora Central', 12000, 20000, 20),
    ('OFIC-004', 'Grapadora Metálica', 'Grapadora de escritorio metálica', 'Oficina', 'Distribuidora Central', 28000, 48000, 8),

    ('LIMP-001', 'Detergente 1L', 'Detergente líquido para pisos', 'Limpieza', 'ImportPy S.R.L.', 8000, 15000, 30),
    ('LIMP-002', 'Lavandina 1L', 'Lavandina concentrada', 'Limpieza', 'ImportPy S.R.L.', 6000, 12000, 30),
    ('LIMP-003', 'Papel Higiénico (paquete x4)', 'Paquete de 4 rollos', 'Limpieza', 'ImportPy S.R.L.', 10000, 18000, 40),
    ('LIMP-004', 'Guantes de Látex (caja x100)', 'Caja de guantes descartables', 'Limpieza', 'ImportPy S.R.L.', 45000, 75000, 5),

    ('ALIM-001', 'Café Molido 500g', 'Café molido tostado', 'Alimentos', 'Suministros del Este', 18000, 28000, 15),
    ('ALIM-002', 'Azúcar 1kg', 'Azúcar refinada', 'Alimentos', 'Suministros del Este', 6000, 10000, 20),
    ('ALIM-003', 'Yerba Mate 500g', 'Yerba mate compuesta', 'Alimentos', 'Suministros del Este', 12000, 20000, 25),

    ('FERR-001', 'Taladro Eléctrico', 'Taladro percutor 1/2 pulgada', 'Ferretería', 'Comercial Andina', 380000, 550000, 3),
    ('FERR-002', 'Set de Destornilladores', 'Set de 6 destornilladores', 'Ferretería', 'Comercial Andina', 65000, 110000, 5),
    ('FERR-003', 'Tornillos (caja x100)', 'Caja de tornillos autorroscantes', 'Ferretería', 'Comercial Andina', 9000, 16000, 15)
) AS v(codigo, nombre, descripcion, categoria, proveedor, precio_costo, precio_venta, stock_minimo)
WHERE NOT EXISTS (SELECT 1 FROM productos p WHERE p.producto_codigo = v.codigo);

-- =========================================================
-- Movimientos de stock (carga inicial + algunas salidas)
-- El trigger fn_registrar_movimiento_stock actualiza productos.producto_stock_actual.
-- =========================================================

-- Carga inicial: entrada por el stock objetivo de cada producto que aun no tiene movimientos.
INSERT INTO movimientos_stock (producto_id, movimiento_tipo, movimiento_cantidad, movimiento_stock_anterior, movimiento_stock_nuevo, movimiento_motivo, usuario_id)
SELECT p.producto_id, 'ENTRADA', v.cantidad, 0, 0, 'Carga inicial de inventario',
       (SELECT usuario_id FROM usuarios WHERE usuario_nick = 'admin')
FROM (VALUES
    ('ELEC-001', 45), ('ELEC-002', 30), ('ELEC-003', 5), ('ELEC-004', 60), ('ELEC-005', 80),
    ('OFIC-001', 100), ('OFIC-002', 40), ('OFIC-003', 55), ('OFIC-004', 15),
    ('LIMP-001', 90), ('LIMP-002', 70), ('LIMP-003', 150), ('LIMP-004', 20),
    ('ALIM-001', 20), ('ALIM-002', 65), ('ALIM-003', 80),
    ('FERR-001', 4), ('FERR-002', 22), ('FERR-003', 48)
) AS v(codigo, cantidad)
INNER JOIN productos p ON p.producto_codigo = v.codigo
WHERE NOT EXISTS (SELECT 1 FROM movimientos_stock m WHERE m.producto_id = p.producto_id);

-- Salidas para dejar algunos productos por debajo (o cerca) de su stock minimo,
-- y que el reporte de "Stock Bajo" tenga datos para mostrar.
INSERT INTO movimientos_stock (producto_id, movimiento_tipo, movimiento_cantidad, movimiento_stock_anterior, movimiento_stock_nuevo, movimiento_motivo, usuario_id)
SELECT p.producto_id, 'SALIDA', v.cantidad, 0, 0, v.motivo,
       (SELECT usuario_id FROM usuarios WHERE usuario_nick = 'admin')
FROM (VALUES
    ('ELEC-003', 4, 'Venta a Dirección de Informática'),
    ('OFIC-004', 12, 'Distribución a oficinas'),
    ('LIMP-004', 18, 'Entrega a personal de limpieza'),
    ('ALIM-001', 14, 'Consumo cafetería'),
    ('FERR-001', 4, 'Préstamo a taller')
) AS v(codigo, cantidad, motivo)
INNER JOIN productos p ON p.producto_codigo = v.codigo
-- Solo aplica esta salida "demo" una vez: si ya hay mas de un movimiento (la entrada inicial
-- mas esta salida) para el producto, no se repite.
WHERE (SELECT COUNT(*) FROM movimientos_stock m WHERE m.producto_id = p.producto_id) = 1;
