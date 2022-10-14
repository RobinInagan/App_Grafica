<?php
include()

?>
<!DOCTYPE html>
<html lang="en">
<head>
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
                <h3 align="center">Ingresos</h3>
                <table class="table caption-top table-hover table-success">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ing = new Ingresos();
                        $reg = $ing->Mostrar($_SESSION['id']);

                        for ($i = 0; $i < count($reg); $i++) {
                            echo "<tr>";
                            echo "<td>" . $reg[$i]['id'] . "</td>";
                            echo "<td>" . $reg[$i]['descripcion'] . "</td>";
                            echo "<td>$" . $reg[$i]['valor'] . "</td>";
                        ?>
                            <td>
                                <button class="btn btn-warning" onclick=window.location="../Ingreso/editar.php?id=<?php echo $reg[$i]['id']; ?>">
                                    <span class="material-icons">mode_edit</span>
                                </button>
                                <button class="btn btn-danger" onclick="eliminar('../Ingreso/eliminarI.php?id=<?php echo $reg[$i]['id']; ?>')">
                                    <span class="material-icons">cancel</span>
                                </button>
                            </td>
                        <?php
                        }
                        ?>
                        </tr>
                    </tbody>

                </table>
                <tr>
                    <form action="../Ingreso/insertar.php" method="POST">
                        <td></td>
                        <td colspan="2">
                            <input type="text" id="descripcion" name="descripcion" placeholder="Descripción" required>
                        </td>
                        <td>
                            <input type="number" id="valor" name="valor" placeholder="Valor" required>
                        </td>
                        <td>
                            <button class="btn btn-success">
                                <span class="material-icons">add_circle</span>
                            </button>
                        </td>
                    </form>
                </tr>

            </div>
    </form>
</body>
</html>