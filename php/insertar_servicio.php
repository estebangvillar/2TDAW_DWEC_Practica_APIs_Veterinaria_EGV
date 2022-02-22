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
    if (!isset($_POST["añadir"])) {
        $descripcion = "";
        $duracion = "";
        $precio  = "";
    } else {
        $descripcion  = $_POST["descripcion"];
        $duracion = $_POST["duracion"];
        $precio  = $_POST["precio"];
    }

    $sacarID = 'select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA="veterinaria" and TABLE_NAME="servicio"';
    $conexion = conex();
    $resultado = $conexion->query($sacarID);
    if ($resultado == true) {
        $datos = $conexion->query($sacarID);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                $idcliente = 1;
            } else {
                while ($fila = $datos->fetch_row()) {
                    $idservicio = $fila[0];
                }
            }
        }
    } else {
        echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE BUSCAR</p><br><br>";
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽INSERTAR SERVICIO🔽</h2>
            </div>
            <form name='formulario' action='insertar_servicio.php' enctype='multipart/form-data' method='POST'>
                <label for='id'>ID: </label>
                <input type='text' disabled name='id' id='id' value='$idservicio'>
                <br>
                <label for='descripcion'>Descripcion:<span style='color:red'>*</span> </label>
                <input type='text' name='descripcion' id='descripcion' value='$descripcion'>
                <br>
                <label for='duracion'>Duración:<span style='color:red'>*</span> </label>
                <input type='text' name='duracion' id='duracion' value='$duracion'>
                <br>
                <label for='precio'>Precio:<span style='color:red'>*</span> </label>
                <input type='text' name='precio' id='precio' value='$precio'>
                <br><br>
                <input type='submit' name='añadir' id='añadir' value='Insertar servicio' class='confirmar'>
                <a href='servicios.php'><input type='button' value='Ver servicios' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"]) && $descripcion != "" && $duracion != "" && $precio != "") {
        $sentencia = "insert into servicio values ('','$descripcion', '$duracion', '$precio')";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO<br><br>RECARGA LA PÁGINA PARA VER LOS CAMBIOS</p>";
            header("refresh:1;url=servicios.php");
            $conexion->close();
        } else {
            echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE REGISTRAR</p><br><br>";
            $conexion->close();
        }
    } else {
        echo "<p class='mensaje_error'>COMPLETA TODOS LOS CAMPOS POR FAVOR</p>";
        $conexion->close();
    }
    ?>
</body>

</html>