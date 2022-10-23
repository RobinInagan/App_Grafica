<?php
include("../Conexion/conexion.php");
include("../Senales/Lista_Senales.php");

$sig = new CRUD_Senal();
$lists = $sig->Mostrarid($_GET['id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" language="javascript" href="../bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="CSS/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" language="javascript" src="../js/funciones.js"></script>
    <title>Graficas De Espectro</title>

</head>

<body>
    <style type="text/css">
        body {

            background-color: #a8a1a0
        }
    </style>
    <h1 class="text-center">Grafica de Espectro</h1>
    <div align="center">
        <h3 align="center">Editar Señales</h3>
        <form action="" method="POST"> 
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Frecuencia Central (MHz)</th>
                        <th scope="col">Ancho de Banda(MHz)</th>
                        <th scope="col">Potencia Pico(dBm)</th>
                        <th scope="col">Temperatura (°k)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    for ($i = 0; $i < count($lists); $i++) {
                        echo "<tr>";
                        echo "<td>" . $lists[$i]['id'] . "</td>";
                        echo "<td> <input require type='number' name='frecuencia' id='frecuencia' value='" . $lists[$i]['Frecuencia_Central'] . "'>
                    <select id='FC_V' name='FC_V' class='col-auto' aria-label='Default select example'>
                        <option selected>Unidad</option>
                        <option value='GHz'>GHz</option>
                        <option value='MHz'>MHz</option>
                        <option value='kHz'>kHz</option>
                        <option value='Hz'>Hz</option>
                    </select>
                    </td>";
                        echo "<td> <input require type='number' name='BW' id='BW' value='" . $lists[$i]['Ancho_de_banda'] . "'>
                    <select id='BW_V' name='BW_V' class='col-auto' aria-label='Default select example'>
                        <option selected>Unidad</option>
                        <option value='GHz'>GHz</option>
                        <option value='MHz'>MHz</option>
                        <option value='kHz'>kHz</option>
                        <option value='Hz'>Hz</option>
                    </select>
                    </td>";
                        echo "<td> <input require type='number' name='PP' id='PP' value='" . $lists[$i]['Potencia_pico'] . "'>
                    <select id='PP_V' name='PP_V' class='col-auto' aria-label='Default select example'>
                        <option selected>Unidad</option>
                        <option value='dBm'>dBm</option>
                        <option value='dBW'>dBW</option>
                        <option value='dBk'>dBk</option>
                    </select>
                    </td>";
                        echo "<td> <input require type='number' name='Temp' id='Temp' value='" . $lists[$i]['Temp'] . "'></td>";
                    }
                    ?>
                    <input type="hidden" name="1" id="1" value="<?php echo"".$lists[0]['id']."";?>">
                    </tr>
                </tbody>        
        </table>
        <input class='btn btn-success' type="submit" name="editar" id="editar">
        <a class="btn btn-primary" href="../Home/home.php">Volver</a>
        </form> 
        <tr>
    </div>
    <?php
    function Cambio_MHZ($valor, $base)
    {
        switch ($base) {
            case "GHz":
                return pow(10, 3) * $valor;
                break;
            case "MHz":
                return $valor;
                break;
            case "kHz":
                return pow(10, -3) * $valor;
                break;
            case "Hz":
                return pow(10, -6) * $valor;
                break;
        }
    };

    function Cambio_dBm($valor, $base)
    {
        switch ($base) {
            case "dBm":
                return $valor;
                break;
            case "dBW":
                return $valor + 30;
                break;
            case "dBk":
                return $valor + 60;
                break;
        }
    };


    if (isset($_POST['editar'])) {
        $id = $_POST['1'];
        $baseFc = $_POST['FC_V'];
        $frecuencia = $_POST['frecuencia'];
        $baseBW = $_POST['BW_V'];
        $BW = $_POST['BW'];
        $basePP = $_POST['PP_V'];
        $PP = $_POST['PP'];
        $Temperatura = $_POST['Temp'];

        $frecuencia = Cambio_MHZ($frecuencia, $baseFc);
        $BW = Cambio_MHZ($BW, $baseBW);
        $PP = Cambio_dBm($PP, $basePP);

        if ($frecuencia > 0 && $frecuencia <= 100) {
            if ($BW > 0 && $BW <= 10) {
                if ($Temperatura > 0 && $Temperatura <= 373) {

                    $lists = new CRUD_Senal();
                    $lists->update($id,$frecuencia, $BW, $PP, $Temperatura);
                } else {
                    echo "<script>
                        alert('Error, la temperatura es menor que 0 o mayor que 373 °k')
                        </script>
                    ";
                }
            } else {
                echo "<script>
                alert('Error, el ancho de banda es menos que 0 o mayor a 10 Mhz')
            </script>
            ";
            }
        } else {
            echo "<script>
                alert('Error, la frecuencia es menos que 0 o mayor a 100 Mhz')
            </script>
            ";
        }
    }
    ?>
    <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>

</html>