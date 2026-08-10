<?php

class Usuario{

    private $pdo;

    private $usuario_id;
    private $usuario_nick;
    private $usuario_email;
    private $rol_id;
    private $rol_descripcion;
    private $persona_nombre;
    private $persona_apellido;

    public function __CONSTRUCT(){
        $this->pdo = Database::Conectar();
    }

    public function getUsuarioId() : ?int{
        return $this->usuario_id;
    }

    public function setUsuarioId(int $id){
        $this->usuario_id=$id;
    }

    public function getUsuarioNick() : ?string{
        return $this->usuario_nick;
    }

    public function setUsuarioNick(string $nick){
        $this->usuario_nick=$nick;
    }

    public function getUsuarioEmail() : ?string{
        return $this->usuario_email;
    }

    public function setUsuarioEmail(string $email){
        $this->usuario_email=$email;
    }

    public function getRolId() : ?int{
        return $this->rol_id;
    }

    public function setRolId(int $id){
        $this->rol_id=$id;
    }

    public function getRolDescripcion() : ?string{
        return $this->rol_descripcion;
    }

    public function setRolDescripcion(string $desc){
        $this->rol_descripcion=$desc;
    }

    public function getPersonaNombre() : ?string{
        return $this->persona_nombre;
    }

    public function setPersonaNombre(string $nom){
        $this->persona_nombre=$nom;
    }

    public function getPersonaApellido() : ?string{
        return $this->persona_apellido;
    }

    public function setPersonaApellido(string $ape){
        $this->persona_apellido=$ape;
    }

    public function ValidarCredenciales(string $nick, string $clave){
        try{
            $consulta = "SELECT u.usuario_id, u.usuario_nick, u.usuario_email, u.usuario_password,
                                r.rol_id, r.rol_descripcion,
                                p.persona_nombre, p.persona_apellido
                         FROM usuarios u
                         INNER JOIN roles r ON r.rol_id = u.rol_id
                         INNER JOIN personas p ON p.persona_id = u.persona_id
                         INNER JOIN estados e ON e.estado_id = u.estado_id
                         WHERE u.usuario_nick = ? AND e.estado_descripcion = 'Activo';";
            $sentencia = $this->pdo->prepare($consulta);
            $sentencia->execute(array($nick));
            $fila = $sentencia->fetch(PDO::FETCH_OBJ);

            if($fila && password_verify($clave, $fila->usuario_password)){
                $this->setUsuarioId(intval($fila->usuario_id));
                $this->setUsuarioNick($fila->usuario_nick);
                $this->setUsuarioEmail($fila->usuario_email);
                $this->setRolId(intval($fila->rol_id));
                $this->setRolDescripcion($fila->rol_descripcion);
                $this->setPersonaNombre($fila->persona_nombre);
                $this->setPersonaApellido($fila->persona_apellido);
                return true;
            }

            return false;
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

}
