<?php

require_once "model/ciudad.php";

class CiudadController{

    private $modelo;

    public function __CONSTRUCT(){
        $this->modelo=new Ciudad;
    }

    public function Inicio(){
       require_once "view/partials/head.php";
        require_once "view/ciudad/index.php";
        require_once "view/partials/footer.php";
    }

    public function FormCrear(){
        $titulo="Registrar";
        $p=new Producto();
        if(isset($_GET['id'])){
            $p=$this->modelo->Obtener($_GET['id']);
            $titulo="Modificar";
        }
require_once "view/partials/head.php";
        require_once "view/ciudad/index.php";
        require_once "view/partials/footer.php";
       // require_once "vistas/encabezado.php";
        require_once "view/ciudad/modal.php";
       // require_once "vistas/pie.php";
    }

    public function Guardar(){
        $p=new Producto();
        $p->setPro_id(intval($_POST['ID']));
        $p->setPro_nom($_POST['Nombre']);
        
        $p->getPro_id() > 0 ?
        $this->modelo->Actualizar($p) :
        $this->modelo->Insertar($p);

        header("location:?c=producto");
    }

    public function Borrar(){
        $this->modelo->Eliminar($_GET["id"]);
        header("location:?c=producto");
    }


}