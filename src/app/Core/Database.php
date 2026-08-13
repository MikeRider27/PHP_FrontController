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
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $name = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');

            if (!$host || !$port || !$name || !$user || $password === false) {
                die('Error de conexion a la base de datos: faltan variables de entorno DB_*');
            }

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
