<?php
class Conection{

    public static function Conectar()
    {
        $link = mysqli_connect("localhost", "root", "") or die("Error al conectar a la BD");
        mysqli_select_db($link, "senales") or die("Error al seleccionar la BD");

        return $link;
    }

    public static function Cerrar($link){
        mysqli_close($link);
    }
    
}

?>