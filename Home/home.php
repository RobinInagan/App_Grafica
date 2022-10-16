<?php
include("../Conexion/conexion.php");
include("../Senales/Lista_Senales.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" language="javascript" href="../bootstrap/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Graficas De Espectro</title>

</head>

<body>
    <div class="container">
        <h1>Graficas de Espectro</h1>
    </div>
    <form action="" method="POST">
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
                        echo "<td>" . $lists[$i]['Frecuencia Central'] . "</td>";
                        echo "<td>" . $lists[$i]['Ancho de banda'] . "</td>";
                        echo "<td>" . $lists[$i]['Potencia pico'] . "</td>";
                        echo "<td>" . $lists[$i]['Temp'] . "</td>";
                    }
                    ?>
                    </tr>

                </tbody>
            </table>
            <tr>
        </div>
    </form>
    <form action="../insertar/insertar.php" method="POST">

        <input type="number" name="frecuencia" id="frecuencia" placeholder="Frecuencia Central">
        <input type="number" name="BW" id="BW" placeholder="Acnho de Banda">
        <input type="number" name="PP" id="PP" placeholder="Potencia Pico">
        <input type="number" name="Temp" id="Temp" placeholder="Temperatura">
        <input type="submit" name="subir" id="subir" value="Hecho">
    </form>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</body>

</html>