<?php

class CRUD_Senal
{


    public function Insert($fc, $anchoBanda, $potenciaP, $temp)
    {
        if ($this->Validar4() == true) {
            $sql = "INSERT INTO `senal`(`Frecuencia Central`,`Ancho de banda`, `Potencia pico`, `Temp`) VALUES ($fc,$anchoBanda,$potenciaP,$temp)";
            $result = mysqli_query(Conection::conectar(), $sql) or die("Error en la consulta de insertar");
            echo "
             <script type='text/javascript'>
             window.location ='../Home/home.php';
             </script>
            ";
        } else {
            echo "Ya hay 4 señales";
            echo "
             <script type='text/javascript'>
             window.location ='../Home/home.php';
             </script>
            ";
        }
    }

    public function Mostrar()
    {
        $this->conexion = new Conection();
        $lista = array();
        $sql = "SELECT * FROM Senal";
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error en la consulta sql");
        while ($r = mysqli_fetch_array($result)) {
            $lista[] = $r;
        }
        return $lista;
    }

    public function Validar4()
    {
        $sql = "SELECT id FROM Senal";
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error al consultar máximo id");
        while ($r = mysqli_fetch_array($result)) {
            $lista[] = $r;
        }
        if ( $lista[count($lista)-1]['id'] == 4) {
            return false;
        } else {
            return true;
        }
    }
}
