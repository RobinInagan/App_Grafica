<?php
include("../Conexion/conexion.php");
include("../Senales/Lista_Senales.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" language="javascript" href="../bootstrap-5.0.2-dist/css/bootstrap.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Graficas De Espectro</title>

</head>

<body>
    <div class="container">
        <h1>Graficas de Espectro</h1>
    </div>
        <div class="col-lg-6">
            <h3 align="center">Señales</h3>
            <table class="table caption-top table-hover table-success">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Frecuencia Central</th>
                        <th scope="col">Ancho de Banda</th>
                        <th scope="col">Potencia Pico</th>
                        <th scope="col">Temperatura</th>
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
                    }
                    ?>
                    </tr>

                </tbody>
            </table>
            <tr>
        </div>
    <form action="../insertar/insertar.php" method="POST">

        <input type="number" name="frecuencia" id="frecuencia" placeholder="Frecuencia Central">
        <input type="number" name="BW" id="BW" placeholder="Acnho de Banda">
        <input type="number" name="PP" id="PP" placeholder="Potencia Pico">
        <?php
        if($lists!=null){
            echo" <input disabled  value='".$lists[0]['Temp']."' '>";
            echo" <input type='hidden' name='Temp' id='Temp' value='".$lists[0]['Temp']."' '>";
        }else{
            echo" <input type='number' name='Temp' id='Temp' placeholder='Temperatura'>";
        }
        ?>
        <input type="submit" name="subir" id="subir" value="Hecho">
    </form>
    <form action="./Home.php" method="POST">
        <input type="submit" name="graficar" id="graficar" value="Graficar">
    </form>
    
    <form action="./Home.php" method="POST">
        <input type="submit" name="limpiar" id="limpiar" value="Limpiar">
    </form>
<?php

if(isset($_POST['limpiar'])){
    $obj = new CRUD_Senal();
    $obj->Limpiar();
}

if(isset($_POST['graficar'])){
    $obj = new CRUD_Senal();
    $lista=$obj->SenalesORG();
    if($lista == null ){
    }else {
        $t=$lista[count($lista)-1]['id'];
        $bwm=$obj->SenalesBW();
        $piso_ruido=log10(((pow(10,-23)*1.38)*(($bwm[0]['Ancho_de_banda'])/(10))*($bwm[0]['Temp']))/(pow(10,-3)*1))*10; 
        //$piso_ruido=-100;
        if ($t == 1) {            
           $BW = $lista[0]['Ancho_de_banda']; 
           $frecuencia=$lista[0]['Frecuencia_Central'];
           $PP=$lista[0]['Potencia_pico']; 
           echo "
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
                    [".($frecuencia-($BW)).", ".$piso_ruido.",".$piso_ruido."],
                    [".($frecuencia-($BW/2)).", ".($PP-3).",".$piso_ruido."],
                    [".$frecuencia.", ".$PP.",".$piso_ruido."],
                    [".($frecuencia+($BW/2)).", ".($PP-3).",".$piso_ruido."],
                    [".($frecuencia+($BW)).", ".$piso_ruido.",".$piso_ruido."],
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
           ";
        }
        if ($t == 2) {            
            $BW = $lista[0]['Ancho_de_banda']; 
            $frecuencia=$lista[0]['Frecuencia_Central'];
            $PP=$lista[0]['Potencia_pico'];

            $BW1 = $lista[1]['Ancho_de_banda']; 
            $frecuencia1=$lista[1]['Frecuencia_Central'];
            $PP1=$lista[1]['Potencia_pico'];
            
            echo "
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
                        [".($frecuencia-($BW)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia-($BW/2)).", ".($PP-3).",".$piso_ruido."],
                        [".$frecuencia.", ".$PP.",".$piso_ruido."],
                        [".($frecuencia+($BW/2)).", ".($PP-3).",".$piso_ruido."],
                        [".($frecuencia+($BW)).", ".$piso_ruido.",".$piso_ruido."],
                       ]);

                       data.addRows([
                        [".($frecuencia1-($BW1)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia1-($BW1/2)).", ".($PP1-3).",".$piso_ruido."],
                        [".$frecuencia1.", ".$PP1.",".$piso_ruido."],
                        [".($frecuencia1+($BW1/2)).", ".($PP1-3).",".$piso_ruido."],
                        [".($frecuencia1+($BW1)).", ".$piso_ruido.",".$piso_ruido."],
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
            ";
        }

        if ($t == 3) {            

            $BW = $lista[0]['Ancho_de_banda']; 
            $frecuencia=$lista[0]['Frecuencia_Central'];
            $PP=$lista[0]['Potencia_pico'];

            $BW1 = $lista[1]['Ancho_de_banda']; 
            $frecuencia1=$lista[1]['Frecuencia_Central'];
            $PP1=$lista[1]['Potencia_pico'];

            $BW2 = $lista[2]['Ancho_de_banda']; 
            $frecuencia2=$lista[2]['Frecuencia_Central'];
            $PP2=$lista[2]['Potencia_pico'];
            
            echo "
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
                        [".($frecuencia-($BW)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia-($BW/2)).", ".($PP-3).",".$piso_ruido."],
                        [".$frecuencia.", ".$PP.",".$piso_ruido."],
                        [".($frecuencia+($BW/2)).", ".($PP-3).",".$piso_ruido."],
                        [".($frecuencia+($BW)).", ".$piso_ruido.",".$piso_ruido."],
                       ]);

                       data.addRows([
                        [".($frecuencia1-($BW1)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia1-($BW1/2)).", ".($PP1-3).",".$piso_ruido."],
                        [".$frecuencia1.", ".$PP1.",".$piso_ruido."],
                        [".($frecuencia1+($BW1/2)).", ".($PP1-3).",".$piso_ruido."],
                        [".($frecuencia1+($BW1)).", ".$piso_ruido.",".$piso_ruido."],
                       ]);

                       data.addRows([
                        [".($frecuencia2-($BW2)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia2-($BW2/2)).", ".($PP2-3).",".$piso_ruido."],
                        [".$frecuencia2.", ".$PP2.",".$piso_ruido."],
                        [".($frecuencia2+($BW2/2)).", ".($PP2-3).",".$piso_ruido."],
                        [".($frecuencia2+($BW2)).", ".$piso_ruido.",".$piso_ruido."],
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
            ";
        }

        if ($t == 4) {            
            $BW = $lista[0]['Ancho_de_banda']; 
            $frecuencia=$lista[0]['Frecuencia_Central'];
            $PP=$lista[0]['Potencia_pico'];

            $BW1 = $lista[1]['Ancho_de_banda']; 
            $frecuencia1=$lista[1]['Frecuencia_Central'];
            $PP1=$lista[1]['Potencia_pico'];

            $BW2 = $lista[2]['Ancho_de_banda']; 
            $frecuencia2=$lista[2]['Frecuencia_Central'];
            $PP2=$lista[2]['Potencia_pico'];
            
            $BW3 = $lista[3]['Ancho_de_banda']; 
            $frecuencia3=$lista[3]['Frecuencia_Central'];
            $PP3=$lista[3]['Potencia_pico'];
            
            echo "
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
                        [".($frecuencia-($BW)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia-($BW/2)).", ".($PP-3).",".$piso_ruido."],
                        [".$frecuencia.", ".$PP.",".$piso_ruido."],
                        [".($frecuencia+($BW/2)).", ".($PP-3).",".$piso_ruido."],
                        [".($frecuencia+($BW)).", ".$piso_ruido.",".$piso_ruido."],
                       ]);

                       data.addRows([
                        [".($frecuencia1-($BW1)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia1-($BW1/2)).", ".($PP1-3).",".$piso_ruido."],
                        [".$frecuencia1.", ".$PP1.",".$piso_ruido."],
                        [".($frecuencia1+($BW1/2)).", ".($PP1-3).",".$piso_ruido."],
                        [".($frecuencia1+($BW1)).", ".$piso_ruido.",".$piso_ruido."],
                       ]);

                       data.addRows([
                        [".($frecuencia2-($BW2)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia2-($BW2/2)).", ".($PP2-3).",".$piso_ruido."],
                        [".$frecuencia2.", ".$PP2.",".$piso_ruido."],
                        [".($frecuencia2+($BW2/2)).", ".($PP2-3).",".$piso_ruido."],
                        [".($frecuencia2+($BW2)).", ".$piso_ruido.",".$piso_ruido."],
                       ]);

                       data.addRows([
                        [".($frecuencia3-($BW3)).", ".$piso_ruido.",".$piso_ruido."],
                        [".($frecuencia3-($BW3/2)).", ".($PP3-3).",".$piso_ruido."],
                        [".$frecuencia3.", ".$PP3.",".$piso_ruido."],
                        [".($frecuencia3+($BW3/2)).", ".($PP3-3).",".$piso_ruido."],
                        [".($frecuencia3+($BW3)).", ".$piso_ruido.",".$piso_ruido."],
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
            ";
        }
    }
   
    
   
}

?>

        
    <script src="../bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>

</html>