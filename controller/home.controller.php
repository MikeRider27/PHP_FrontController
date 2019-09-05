<?php
require_once "model/ciudad.php";
class HomeController{
    private $modelo;

    public function __CONSTRUCT(){
        $this->modelo=new Ciudad();
    }

    public function Inicio(){
        require_once "view/partials/head.php";
        require_once "view/home/principal.php";
        require_once "view/partials/footer.php";
    }

}