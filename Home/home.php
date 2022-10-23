<?php
include("../Conexion/conexion.php");
include("../Senales/Lista_Senales.php");

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
        <h3 align="center">Señales</h3>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Frecuencia Central (MHz)</th>
                    <th scope="col">Ancho de Banda(MHz)</th>
                    <th scope="col">Potencia Pico(dBm)</th>
                    <th scope="col">Temperatura (°k)</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sig = new CRUD_Senal();
                $lists = $sig->Mostrar();

                for ($i = 0; $i < count($lists); $i++) {
                    echo "<tr>";
                    echo "<td>" . $lists[$i]['id'] . "</td>";
                    echo "<td>" . $lists[$i]['Frecuencia_Central'] . "</td>";
                    echo "<td>" . $lists[$i]['Ancho_de_banda'] . "</td>";
                    echo "<td>" . $lists[$i]['Potencia_pico'] . "</td>";
                    echo "<td>" . $lists[$i]['Temp'] . "</td>";
                ?>
                    <td>
                        <button class="btn btn-warning" onclick=window.location="../Senales/Editar.php?id=<?php echo $lists[$i]['id']; ?>">
                            <span class="material-icons">mode_edit</span>
                        </button>
                        <?php
                        if ($lists[$i]['id'] != 1) {
                        ?>

                            <button class="btn btn-danger" onclick="eliminar('../Senales/Eliminar.php?id=<?php echo $lists[$i]['id']; ?>')">
                                <span class="material-icons">cancel</span>
                            </button>
                        <?php
                        }
                        ?>
                    </td>
                <?php
                }
                ?>
                </tr>
            </tbody>
        </table>
        <tr>
    </div>
    <div class="row g-3 text-center">
        <div class="col">
            <form action="" method="POST" class="form-group">
                <div class="col-auto"><input require type="number" name="frecuencia" id="frecuencia" placeholder="Frecuencia Central">
                    <select id="FC_V" name="FC_V" class="col-auto" aria-label="Default select example">
                        <option selected>Unidad</option>
                        <option value="GHz">GHz</option>
                        <option value="MHz">MHz</option>
                        <option value="kHz">kHz</option>
                        <option value="Hz">Hz</option>
                    </select>
                </div>
                <div class="col-auto"><input require type="number" name="BW" id="BW" placeholder="Ancho de Banda">
                    <select id="BW_V" name="BW_V" class="col-auto" aria-label="Default select example">
                        <option selected>Unidad</option>
                        <option value="GHz">GHz</option>
                        <option value="MHz">MHz</option>
                        <option value="kHz">kHz</option>
                        <option value="Hz">Hz</option>
                    </select>
                </div>
                <div class="col-auto"><input require type="number" name="PP" id="PP" placeholder="Potencia Pico">
                    <select id="PP_V" name="PP_V" class="col-auto" aria-label="Default select example">
                        <option selected>Unidad</option>
                        <option value="dBm">dBm</option>
                        <option value="dBW">dBW</option>
                        <option value="dBk">dBk</option>
                    </select>
                </div>
                <?php
                if ($lists != null) {

                    echo "<div class='col-auto'> <input require disabled  value='" . $lists[0]['Temp'] . "' '>";
                    echo " <input  type='hidden' name='Temp' id='Temp' value='" . $lists[0]['Temp'] . "' '></div> ";
                } else {
                    echo "<div class='col-auto'> <input type='number' name='Temp' id='Temp' placeholder='Temperatura'></div>";
                }
                ?>
                <br>
                <div><input class="btn btn-primary" type="submit" name="subir" id="subir" value="Hecho"></div>
                <br>
            </form>
        </div>
        <div class="col">
            <form action="./Home.php" method="POST">
                <input type="submit" name="graficar" id="graficar" value="Graficar" class="btn btn-primary">
            </form>
            <BR>
            <form action="./Home.php" method="POST">
                <input type="submit" name="limpiar" id="limpiar" value="Limpiar" class="btn btn-primary">
            </form>
        </div>
    </div>
    <div class="row g-3 text-center">
        <div class="col"></div>
        <div class="col">

        </div>
        <div class="col"></div>
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


    if (isset($_POST['subir'])) {
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
                    $lists->Insert($frecuencia, $BW, $PP, $Temperatura);
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

    if (isset($_POST['limpiar'])) {
        $obj = new CRUD_Senal();
        $obj->Limpiar();
    }

    if (isset($_POST['graficar'])) {
        $obj = new CRUD_Senal();
        $lista = $obj->SenalesORG();
        if ($lista == null) {
        } else {
            $t = $lista[count($lista) - 1]['id'];
            $bwm = $obj->SenalesBW();
            if ($t > 1) {
                $piso_ruido = log10(((pow(10, -23) * 1.38) * ((pow(10, 6) * $bwm[0]['Ancho_de_banda']) / (10)) * ($bwm[0]['Temp'])) / (pow(10, -3) * 1)) * 10;
            } else {
                $piso_ruido = log10(((pow(10, -23) * 1.38) * ((pow(10, 6) * $bwm[0]['Ancho_de_banda'])) * ($bwm[0]['Temp'])) / (pow(10, -3) * 1)) * 10;
            }
            if ($t == 1) {
                $BW = $lista[0]['Ancho_de_banda'];
                $frecuencia = $lista[0]['Frecuencia_Central'];
                $PP = $lista[0]['Potencia_pico'];
                echo "
           
           <div align='center' > 
           <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
           <script type='text/javascript'>
               google.charts.load('current', {
                   'packages': ['line']
               });
               google.charts.setOnLoadCallback(drawChart);
       
               function drawChart() {
                   var data = new google.visualization.DataTable();
                   data.addColumn('number', 'Frecuencia (Mhz)');
                   data.addColumn('number', 'señal');
                   data.addColumn('number', 'Ruido');


                   data.addRows([
                    [" . ($frecuencia - ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                    [" . ($frecuencia - ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                    [" . $frecuencia . ", " . $PP . "," . $piso_ruido . "],
                    [" . ($frecuencia + ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                    [" . ($frecuencia + ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                   ]);

                   var options = {
                       chart: {
                           title: 'Visualizacion de señales de radiofrecuencia',
                           subtitle: 'dBm',
                       },
                    
                       width: 900,
                       height: 500,
                       backgroundColor: '#E4E4E4',

                   };
       
                   var chart = new google.charts.Line(document.getElementById('linechart_material'));
       
                   chart.draw(data, google.charts.Line.convertOptions(options));
                   
               }
           </script>
           <div align='center' id='linechart_material' style='width: 900px; height: 500px;'></div>
           </div> 
           
           ";
            }
            if ($t == 2) {
                $BW = $lista[0]['Ancho_de_banda'];
                $frecuencia = $lista[0]['Frecuencia_Central'];
                $PP = $lista[0]['Potencia_pico'];

                $BW1 = $lista[1]['Ancho_de_banda'];
                $frecuencia1 = $lista[1]['Frecuencia_Central'];
                $PP1 = $lista[1]['Potencia_pico'];

                echo "
            <div align='center' > 
            <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
            <script type='text/javascript'>
                google.charts.load('current', {
                    'packages': ['line']
                });
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
        
                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'Frecuencia (Mhz)');
                    data.addColumn('number', 'señales');
                    data.addColumn('number', 'ruido');
 
                    data.addRows([
                        [" . ($frecuencia - ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia - ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia . ", " . $PP . "," . $piso_ruido . "],
                        [" . ($frecuencia + ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia + ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                       data.addRows([
                        [" . ($frecuencia1 - ($BW1)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia1 - ($BW1 / 2)) . ", " . ($PP1 - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia1 . ", " . $PP1 . "," . $piso_ruido . "],
                        [" . ($frecuencia1 + ($BW1 / 2)) . ", " . ($PP1 - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia1 + ($BW1)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                    var options = {
                        chart: {
                            title: 'Visualizacion de señales de radiofrecuencia',
                            subtitle: 'dBm'
                        },
                        width: 900,
                        height: 500
                    };
        
                    var chart = new google.charts.Line(document.getElementById('linechart_material'));
        
                    chart.draw(data, google.charts.Line.convertOptions(options));
                }
            </script>
            <div id='linechart_material' style='width: 900px; height: 500px'></div>
            </div> 
            ";
            }

            if ($t == 3) {

                $BW = $lista[0]['Ancho_de_banda'];
                $frecuencia = $lista[0]['Frecuencia_Central'];
                $PP = $lista[0]['Potencia_pico'];

                $BW1 = $lista[1]['Ancho_de_banda'];
                $frecuencia1 = $lista[1]['Frecuencia_Central'];
                $PP1 = $lista[1]['Potencia_pico'];

                $BW2 = $lista[2]['Ancho_de_banda'];
                $frecuencia2 = $lista[2]['Frecuencia_Central'];
                $PP2 = $lista[2]['Potencia_pico'];

                echo "
            <div align='center' > 
            <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
            <script type='text/javascript'>
                google.charts.load('current', {
                    'packages': ['line']
                });
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
        
                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'Frecuencia (Mhz)');
                    data.addColumn('number', 'señales');
                    data.addColumn('number', 'ruido');
 
                    data.addRows([
                        [" . ($frecuencia - ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia - ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia . ", " . $PP . "," . $piso_ruido . "],
                        [" . ($frecuencia + ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia + ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                       data.addRows([
                        [" . ($frecuencia1 - ($BW1)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia1 - ($BW1 / 2)) . ", " . ($PP1 - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia1 . ", " . $PP1 . "," . $piso_ruido . "],
                        [" . ($frecuencia1 + ($BW1 / 2)) . ", " . ($PP1 - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia1 + ($BW1)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                       data.addRows([
                        [" . ($frecuencia2 - ($BW2)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia2 - ($BW2 / 2)) . ", " . ($PP2 - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia2 . ", " . $PP2 . "," . $piso_ruido . "],
                        [" . ($frecuencia2 + ($BW2 / 2)) . ", " . ($PP2 - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia2 + ($BW2)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                    var options = {
                        chart: {
                            title: 'Visualizacion de señales de radiofrecuencia',
                            subtitle: 'dBm'
                        },
                        width: 900,
                        height: 500
                    };
        
                    var chart = new google.charts.Line(document.getElementById('linechart_material'));
        
                    chart.draw(data, google.charts.Line.convertOptions(options));
                }
            </script>
            <div id='linechart_material' style='width: 900px; height: 500px'></div>
            </div>
            ";
            }

            if ($t == 4) {
                $BW = $lista[0]['Ancho_de_banda'];
                $frecuencia = $lista[0]['Frecuencia_Central'];
                $PP = $lista[0]['Potencia_pico'];

                $BW1 = $lista[1]['Ancho_de_banda'];
                $frecuencia1 = $lista[1]['Frecuencia_Central'];
                $PP1 = $lista[1]['Potencia_pico'];

                $BW2 = $lista[2]['Ancho_de_banda'];
                $frecuencia2 = $lista[2]['Frecuencia_Central'];
                $PP2 = $lista[2]['Potencia_pico'];

                $BW3 = $lista[3]['Ancho_de_banda'];
                $frecuencia3 = $lista[3]['Frecuencia_Central'];
                $PP3 = $lista[3]['Potencia_pico'];

                echo "
            <div align='center' > 
            <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
            <script type='text/javascript'>
                google.charts.load('current', {
                    'packages': ['line']
                });
                google.charts.setOnLoadCallback(drawChart);
        
                function drawChart() {
        
                    var data = new google.visualization.DataTable();
                    data.addColumn('number', 'Frecuencia (Mhz)');
                    data.addColumn('number', 'señales');
                    data.addColumn('number', 'ruido');
 
                    data.addRows([
                        [" . ($frecuencia - ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia - ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia . ", " . $PP . "," . $piso_ruido . "],
                        [" . ($frecuencia + ($BW / 2)) . ", " . ($PP - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia + ($BW)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                       data.addRows([
                        [" . ($frecuencia1 - ($BW1)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia1 - ($BW1 / 2)) . ", " . ($PP1 - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia1 . ", " . $PP1 . "," . $piso_ruido . "],
                        [" . ($frecuencia1 + ($BW1 / 2)) . ", " . ($PP1 - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia1 + ($BW1)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                       data.addRows([
                        [" . ($frecuencia2 - ($BW2)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia2 - ($BW2 / 2)) . ", " . ($PP2 - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia2 . ", " . $PP2 . "," . $piso_ruido . "],
                        [" . ($frecuencia2 + ($BW2 / 2)) . ", " . ($PP2 - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia2 + ($BW2)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                       data.addRows([
                        [" . ($frecuencia3 - ($BW3)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                        [" . ($frecuencia3 - ($BW3 / 2)) . ", " . ($PP3 - 3) . "," . $piso_ruido . "],
                        [" . $frecuencia3 . ", " . $PP3 . "," . $piso_ruido . "],
                        [" . ($frecuencia3 + ($BW3 / 2)) . ", " . ($PP3 - 3) . "," . $piso_ruido . "],
                        [" . ($frecuencia3 + ($BW3)) . ", " . $piso_ruido . "," . $piso_ruido . "],
                       ]);

                    var options = {
                        chart: {
                            title: 'Visualizacion de señales de radiofrecuencia',
                            subtitle: 'dBm'
                        },
                        width: 900,
                        height: 500
                    };
        
                    var chart = new google.charts.Line(document.getElementById('linechart_material'));
        
                    chart.draw(data, google.charts.Line.convertOptions(options));
                }
            </script>
            <div id='linechart_material' style='width: 900px; height: 500px'></div>
            </div>
            ";
            }
        }
    }

    ?>
    <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>

</html>