<?php
include("../Conexion/conexion.php");
include("../Senales/Lista_Senales.php");

$obj = new CRUD_Senal();
$obj->Eliminar($_GET['id']);

?>