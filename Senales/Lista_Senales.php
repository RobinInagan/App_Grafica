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
        $sql = "DELETE FROM senal";
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error al eliminar datos");
        $sql2 = " ALTER TABLE `Senal` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;";
        $result2 = mysqli_query(Conection::conectar(), $sql2) or die("Error al reiniciar contador");
        echo "
             <script type='text/javascript'>
             window.location ='../Home/home.php';
             </script>
            ";
    }

    public function Eliminar($id){
        $sql = "DELETE FROM senal where id = $id";
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error al eliminar datos");
        $id=$id-1;
        $sql2 = " ALTER TABLE `Senal` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT= $id;";
        $result2 = mysqli_query(Conection::conectar(), $sql2) or die("Error al reiniciar contador");
        echo "
             <script type='text/javascript'>
             window.location ='../Home/home.php';
             </script>
            ";
    }

    public function update($id,$frecuencia,$BW,$PP,$temp){
        $sql="UPDATE `senal` SET `Frecuencia_Central`= $frecuencia,`Ancho_de_banda`= $BW ,`Potencia_pico`= $PP,`Temp`= $temp WHERE id =$id";        
        $result = mysqli_query(Conection::conectar(), $sql) or die ("Error al actualizar datos");
        $sql2="UPDATE `senal` SET `Temp`='$temp'";
        $result2 = mysqli_query(Conection::conectar(), $sql2) or die("Error al cambiar temp");
        echo "
             <script type='text/javascript'>
             window.location ='../Home/home.php';
             </script>
            ";
    }

    public function Mostrarid($id)
    {
        $this->conexion = new Conection();
        $lista = array();
        $sql = "SELECT * FROM Senal where id = $id ";
        $result = mysqli_query(Conection::conectar(), $sql) or die("Error en al buscar por id");
        while ($r = mysqli_fetch_array($result)) {
            $lista[] = $r;
        }
        return $lista;
    }
}
