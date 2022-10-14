<?php
include("../Conexion/Conexion.php");

class Señal{
    public $id;   
    public $BW;
    public $Po_Pico;
    public $link;
    
    public function __construct($id, $BW, $Po_Pico,$link){
        $this->id = 0;
        $this->BW = 0;
        $this->Po_Pico = 0;
        $a= new Conection();
        $this->link = $a->Conectar();
    }

    public function set_id($algo){
            $this->id = $algo;
        }
    public function set_BW($valor){
        $this->BW =$valor;
    }
    public function set_Po_Pico($valor){
        $this->Po_Pico = $valor;
    }
    public function get_id(){
        return $this->id;
    }
    public function get_BW(){
        return $this->BW;
    }
    public function get_Po_Pico(){
        return $this->Po_Pico;
    }
    public function Mostrar(){
        
    }


}

?>