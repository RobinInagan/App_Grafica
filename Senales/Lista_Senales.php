<?php
include("Senales.php");
include("./Conexion/conexion.php");

class CRUD_Senal{
    private $conexion;
    private $Link;
    private $senal;

    public function __construct(){
        $this->senal = new Senal();
    }

    public function create($obsenial= new senal(),$temp){
        $this->conexion = new Conection();
        $this->Link = $this->conexion->Conectar();
        $sql="Insert into Senal values ( `Ancho de banda`, `Potencia pico`, `Temp`) VALUES ('$obsenial->get_BW()', $obsenial->get_Po_Pico(), 1,$temp)";
        $res = mysqli_query($this->conexion->Conectar(), $sql) or die("Error en la consulta sql al insertar ingreso");
    }

    public function Mostrar(){
        $this->conexion = new Conection();
        $lista = array();
        $sql = "SELECT * FROM Senal";
        $result = mysqli_query($this->conexion->Conectar(), $sql) or die("Error en la consulta sql");
        while($r = mysqli_fetch_array($result)){
            $lista[] = $r; 
        }

        $this->conexion->Cerrar($this->conexion->Conectar());
        return $lista;
    }
}

?>