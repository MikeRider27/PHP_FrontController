<?php

class Producto{

    private $pdo;

    private $pro_id;
    private $pro_nom;
    private $pro_mar;
    private $pro_cos;
    private $pro_pre;
    private $pro_can;
    private $pro_img;

    public function __CONSTRUCT(){
        $this->pdo = DataBase::Conectar();
    }

    
    public function getProId() : ?int
    {
        return $this->pro_id;
    }

    public function setProId(int $id)
    {
        $this->pro_id = $id;
    }

    public function getProNom() : ?string
    {
        return $this->pro_nom;
    }

    public function setProNom(string $nom)
    {
        $this->pro_nom = $nom;
    }

    public function getProMar() : ?string
    {
        return $this->pro_mar;
    }

    public function setProMar(string $mar)
    {
        $this->pro_mar = $mar;
    }

    public function getProCos() : ?float
    {
        return $this->pro_cos;
    }

    public function setProCos(float $cos)
    {
        $this->pro_cos = $cos;
    }

    public function getProPre() : ?float
    {
        return $this->pro_pre;
    }

    public function setProPre(float $pre)
    {
        $this->pro_pre = $pre;
    }

    public function getProCan() : ?int
    {
        return $this->pro_can;
    }

    public function setProCan(int $can)
    {
        $this->pro_can = $can;
    }

    public function getProImg() : ?string
    {
        return $this->pro_img;
    }

    public function setProImg(string $img)
    {
        $this->pro_img = $img;
    }

    public function Cantidad(){
        try{
            $consulta = $this->pdo->prepare("SELECT SUM(pro_can) as Cantidad FROM produtos;");
            $consulta->execute();
            return $consulta->fetch(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function Listar(){
        try{
            $consulta = $this->pdo->prepare("SELECT * FROM produtos;");
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_OBJ);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }


}