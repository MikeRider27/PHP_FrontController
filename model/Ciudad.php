<?php

class Ciudad{

    private $pdo;

    private $id_ciudad;
    private $ciu_descri;
    //private $pro_mar;    
    //private $pro_cos;
    //private $pro_pre;
    //private $pro_can;
    //private $pro_img;

    public function __CONSTRUCT(){
        $this->pdo = Database::Conectar();
    }

    public function getId_ciudad() : ?int{
        return $this->id_ciudad;
    }

    public function setId_ciudad(int $id){
        $this->id_ciudad=$id;
    }

    public function getCiu_descri() : ?string{
        return $this->ciu_descri;
    }

    public function setCiu_descri(string $nom){
        $this->ciu_descri=$nom;
    }


    public function carga_tabla(){
        try{
            $consulta=$this->pdo->prepare("SELECT * FROM ciudad ORDER BY id_ciudad;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function gencod($id){
        try{
            $consulta=$this->pdo->prepare("SELECT * FROM ciudad WHERE id_ciudad=?;");
            $consulta->execute(array($id));
            $r=$consulta->fetch(PDO::FETCH_OBJ);
            $p=new Ciudad();
            return $p;

        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Insertar(Producto $p){
        try{
            $consulta="INSERT INTO ciudad(ciu_descri) VALUES (?);";
            $this->pdo->prepare($consulta)
                    ->execute(array(
                        $p->getCiu_descri(),
                    ));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Actualizar(Producto $p){
        try{
            $consulta="UPDATE ciudad SET 
                ciu_descri=?
                WHERE id_ciudad=?;
            ";
            $this->pdo->prepare($consulta)
                    ->execute(array(
                        $p->getCiu_descri(),
                        //$p->getPro_mar(),
                       // $p->getPro_cos(),
                       // $p->getPro_pre(),
                       // $p->getPro_can(),
                        $p->getId_ciudad()
                    ));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Eliminar($id){
        try{
            $consulta="DELETE FROM ciudad WHERE id_ciudad=?;";
            $this->pdo->prepare($consulta)
                    ->execute(array($id));
        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}