# Sistema de Inventario Zeus

Sistema de gestión de inventario en PHP, construido sobre un patrón Front
Controller propio (sin framework): un único punto de entrada (`src/index.php`)
enruta cada pedido a un controlador según `?c=` (controlador) y `?a=` (acción).

## Stack

- PHP 8.0 + Apache (contenedor Docker)
- PostgreSQL (servidor externo, no incluido en docker-compose)
- Sin dependencias de Composer/npm: autoload propio (`src/app/autoload.php`) y
  frontend con AdminLTE 2 / Bootstrap 3 ya vendorizados en `src/assets/`

## Estructura del proyecto

```
docker-compose.yaml       Levanta el contenedor "controller" (Apache + PHP)
.env.example                Variables de entorno requeridas (copiar a .env)
docker_files/              Dockerfile de la imagen PHP
bd/
  schema.sql                Esquema completo, para una base nueva/vacía
  migration_002_*.sql        Migraciones incrementales sobre una base ya existente
  seed_demo.sql               Datos de prueba (categorías, proveedores, productos)
src/
  index.php                Front controller (punto de entrada único)
  app/
    Core/                   Database, Router, Controller y Model base, Auth
    Controllers/             Un controlador por módulo
    Models/                   Un modelo por entidad (acceso a datos con PDO)
  view/                    Vistas PHP (una carpeta por módulo) + partials/head-footer
  assets/                  CSS/JS del theme AdminLTE (vendorizado)
```

## Levantar el entorno

```bash
docker compose up -d --build
```

La app queda en `http://localhost:7040`. El contenedor `controller` se conecta
a un PostgreSQL **externo** (no lo levanta docker-compose); la conexión se
configura por variables de entorno, tomadas de un archivo `.env` (no
versionado) en la raíz del proyecto:

```bash
cp .env.example .env
# editar .env con los datos reales del servidor Postgres
```

```
DB_HOST=<host del servidor Postgres>
DB_PORT=<puerto>
DB_NAME=inventario
DB_USER=<usuario>
DB_PASSWORD=<clave>
```

`docker-compose.yaml` inyecta estas variables al contenedor (`${DB_HOST}`,
etc.) y `src/app/Core/Database.php` las lee con `getenv()`; si falta alguna,
la conexión falla explícitamente en vez de usar un valor por defecto.

## Base de datos

- **Instalación nueva** (base vacía): correr `bd/schema.sql` completo.
- **Base ya existente**: aplicar solo las migraciones incrementales
  (`bd/migration_002_compras_usuarios.sql`, y las que se agreguen después)
  sin volver a correr `schema.sql`.
- **Datos de prueba** (opcional): `bd/seed_demo.sql` carga categorías,
  proveedores y productos ficticios, útil para desarrollo/demo.

```bash
PGPASSWORD=<clave> psql -h <host> -p <puerto> -U postgres -d inventario -f bd/schema.sql
```

El stock de los productos **no se actualiza desde PHP**: cada movimiento
(entrada/salida/ajuste) se inserta en `movimientos_stock`, y un trigger de
PostgreSQL (`fn_registrar_movimiento_stock`) recalcula
`productos.producto_stock_actual` y rechaza salidas sin stock suficiente. Esto
mantiene el stock consistente sin importar desde qué módulo se origina el
movimiento (carga manual o recepción de una Orden de Compra).

## Acceso

Usuario de prueba (creado por `schema.sql`):

- **Usuario:** `admin`
- **Contraseña:** `admin123`
- **Rol:** Administrador

## Roles

- **Administrador**: acceso completo (Productos, Categorías, Proveedores,
  Movimientos de Stock, Órdenes de Compra, Usuarios, Reportes).
- **Operador**: solo puede ver Productos y registrar/ver Movimientos de Stock;
  sin acceso a Categorías, Proveedores, Usuarios ni Compras.

## Módulos

- **Inventario**: Productos, Categorías, Proveedores, Movimientos de Stock
  (kardex por producto).
- **Compras**: Órdenes de Compra a proveedor (Pendiente → Recibida/Cancelada);
  al recibir una orden se generan automáticamente las entradas de stock.
- **Usuarios**: alta/edición de usuarios y asignación de rol.
- **Reportes**: Stock Bajo, Valor de Inventario, Movimientos por Fecha,
  Productos más Movidos. Cada reporte tiene un botón "Imprimir / PDF" que abre
  el diálogo de impresión del navegador con una vista limpia (sin menú ni
  botones) — desde ahí se puede guardar como PDF.

## 👨‍💻 Autor

Miguel Villalba
Desarrollador Full Stack
✉️ mike.mavc27@gmail.com

## 📄 Licencia

Este proyecto está bajo la licencia MIT.
