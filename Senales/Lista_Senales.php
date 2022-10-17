<?php

class CRUD_Senal
{


    public function Insert($fc, $anchoBanda, $potenciaP, $temp)
    {
        if ($this->Validar4() == true) {
            $sql = "INSERT INTO `senal`(`Frecuencia_Central`,`Ancho_de_banda`, `Potencia_pico`, `Temp`) VALUES ($fc,$anchoBanda,$potenciaP,$temp)";
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
        if($lista!= null ){
            if ( $lista[count($lista)-1]['id'] == 4) {
                return false;
            } else {
                return true;
            }
        }else {
            return true;
        }
        
    }

    public function SenalesORG(){
        $sql = "SELECT * FROM Senal ORDER by 'Frecuencia_Central'";
        $señal = array();
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error al consultar buscar id");
        while ($r = mysqli_fetch_array($result)) {
            $señal[] = $r;
        }
        return $señal;
    }

    public function SenalesBW(){
        $sql = "SELECT * FROM Senal order by senal.Ancho_de_banda ASC;";
        $señal = array();
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error al consultar buscar id");
        while ($r = mysqli_fetch_array($result)) {
            $señal[] = $r;
        }
        return $señal;
    }

    public function Limpiar(){
        
    }
}
