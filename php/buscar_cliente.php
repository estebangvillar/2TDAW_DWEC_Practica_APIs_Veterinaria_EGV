<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Coral Clínica Veterinaria</title>
</head>

<body>
    <?php
    require_once("funciones.php");
    redireccion();
    if (!isset($_POST["buscar"])) {
        $texto  = "";
    } else {
        $texto  = $_POST["texto"];
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽BUSCAR CLIENTE🔽</h2>
                (Por nombre, nombre de su dueño o teléfono)
            </div>
            <form name='formulario' action='buscar_cliente.php' method='POST'>
                <label for='nombre'>Busqueda de: </label>
                <input type='text' name='texto' id='texto' value='$texto'>
               
                <br>
                <label for='buscar'></label>
                <input type='submit' name='buscar' id='buscar' value='Buscar cliente' class='confirmar'>
                <br>
            </form>
		</div>
	";

    if (isset($_POST["buscar"])) {
        $sentencia = "select * from cliente c, dueño d where (c.nombre like '%$texto%' or d.nombre like '%$texto%' or d.telefono like '%$texto%') and c.dni_dueño=d.dni";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado->num_rows <= 0) {
            echo "No hay clientes para mostrar";
            $conexion->close();
        } else {
            echo "<div id='clientes'>";
            while ($fila = $resultado->fetch_array(MYSQLI_NUM)) {
                echo "
                            <div class='cliente'>
                                <form action='modificar_cliente.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='$fila[0]' class='ocultar'>
                                    <input type='file' name='foto' value='$fila[5]' hidden class='ocultar'><img src='$fila[5]' id='fotocliente'><br>
                                    Tipo: <input type='text' name='tipo' value='$fila[1]' readonly><br>
                                    Nombre: <input type='text' name='nombre' value='$fila[2]' readonly><br>
                                    Edad: <input type='text' name='edad' value='$fila[3]' readonly><br>
                                    Dueño: <input type='text' name='dni_dueño' value='$fila[7]' readonly><br>
                                    <input type='submit' value='Modificar' class='confirmar'>
                                </form>
                            </div>
                        ";
            }
            $conexion->close();
        }
    } else {
        echo "<p class='mensaje_error'>COMPLETA AL MENOS UN CAMPO POR FAVOR</p><br><br>";
    }

    ?>
</body>

</html>