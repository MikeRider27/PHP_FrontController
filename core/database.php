<?php

class Database{

    const server = "localhost";
    const usuario = "postgres";
    const clave = "123";
    const dbname = "mvc";

    public static function Conectar() {
        try {
            $conexion = new PDO("pgsql:host=" . self::server . ";dbname=" . self::dbname . ";", self::usuario, self::clave);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        } catch (PDOException $e) {
            return "Fallo" . $e->getMessage();
        }
    }

}
