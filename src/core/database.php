<?php

class Database{

    const server = "192.168.11.220";
    const puerto = "5436";
    const usuario = "postgres";
    const clave = "123";
    const dbname = "inventario";

    public static function Conectar() {
        try {
            $conexion = new PDO("pgsql:host=" . self::server . ";port=" . self::puerto . ";dbname=" . self::dbname . ";", self::usuario, self::clave);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        } catch (PDOException $e) {
            return "Fallo" . $e->getMessage();
        }
    }

}
