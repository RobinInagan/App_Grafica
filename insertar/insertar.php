<?php
    include("../Conexion/conexion.php");
    include("../Senales/Lista_Senales.php");
    
    $lists = new CRUD_Senal();
    $lists->Insert($_REQUEST['frecuencia'], $_REQUEST['BW'], $_REQUEST['PP'], $_REQUEST['Temp']);
?>
