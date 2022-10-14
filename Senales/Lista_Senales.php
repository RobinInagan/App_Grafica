<?php
include("./Senales.php");
include("../Conexion/Conexion.php");

class CRUD_Senal{
    private $conexion;
    private $Link;
    private $senal;

    public function __construct(){
        $this->conexion = new Conection();
        $this->senal = new Senal();
    }

    public function create($obsenial){
        $this->Link = $this->conexion->Conectar();
        $sql="Insert into ";
    }
}

?>