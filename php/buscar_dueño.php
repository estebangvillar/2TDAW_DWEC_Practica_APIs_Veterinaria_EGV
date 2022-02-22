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
                <h2>🔽BUSCAR DUEÑO🔽</h2>
                (Por nombre, nick o teléfono)
            </div>
            <form name='formulario' action='#' method='POST'>
                <label for='nombre'>Busqueda de: </label>
                <input type='text' name='texto' id='texto' value='$texto'>
               
                <br>
                <label for='buscar'></label>
                <input type='submit' name='buscar' id='buscar' value='Buscar dueño' class='confirmar'>
                <br>
            </form>
		</div>
	";

    if (isset($_POST["buscar"])) {
        $sentencia = "select * from dueño where nombre like '%$texto' or nick like '%$texto' or telefono like '%$texto%'";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado->num_rows <= 0) {
            echo "No hay dueños para mostrar";
            $conexion->close();
        } else {
            echo "<div id='dueños'>";
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                echo "
                        <div class='dueño'>
                            <form action='modificar_dueño.php' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$fila[id]' class='ocultar'>
                                DNI:<input type='text' name='dni' value='$fila[dni]' readonly>
                                Nombre:<input type='text' name='nombre' value='$fila[nombre]' readonly>
                                Teléfono:<input type='text' name='telefono' value='$fila[telefono]' readonly>
                                Nick:<input type='text' name='nick' value='$fila[nick]' readonly>
                                <input type='hidden' name='pass' value='$fila[pass]' class='ocultar'>
                                <input type='submit' value='Modificar' class='confirmarh'>
                            </form>
                        </div>
                    ";
            }
            echo "</div>";
            $conexion->close();
        }
    } else {
        echo "<p class='mensaje_error'>COMPLETA AL MENOS UN CAMPO POR FAVOR</p><br><br>";
    }

    ?>
</body>

</html>