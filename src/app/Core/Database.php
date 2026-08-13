<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function connection(): PDO
    {
        if (self::$instance === null) {
            $host = getenv('DB_HOST') ?: '192.168.11.220';
            $port = getenv('DB_PORT') ?: '5436';
            $name = getenv('DB_NAME') ?: 'inventario';
            $user = getenv('DB_USER') ?: 'postgres';
            $password = getenv('DB_PASSWORD') ?: '123';

            try {
                self::$instance = new PDO(
                    "pgsql:host={$host};port={$port};dbname={$name};",
                    $user,
                    $password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die('Error de conexion a la base de datos: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
