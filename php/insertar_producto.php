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
        $nombre = "";
        $precio  = "";
        //$añadir  = "Añadir producto";
    } else {
        $nombre  = $_POST["nombre"];
        $precio  = $_POST["precio"];
    }

    $sacarID = 'select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA="veterinaria" and TABLE_NAME="producto"';
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
                    $idproducto = $fila[0];
                }
            }
        }
    } else {
        echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE BUSCAR</p><br><br>";
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽INSERTAR PRODUCTO🔽</h2>
            </div>
            <form name='formulario' action='insertar_producto.php' enctype='multipart/form-data' method='POST'>
                <label for='id'>ID: </label>
                <input type='text' disabled name='id' id='id' value='$idproducto'>
                <br>
                <label for='nombre'>Nombre:<span style='color:red'>*</span> </label>
                <input type='text' name='nombre' id='nombre' value='$nombre'>
                <br>
                <label for='precio'>Precio:<span style='color:red'>*</span> </label>
                <input type='text' name='precio' id='precio' value='$precio'>
                <br>
                <input type='submit' name='añadir' id='añadir' value='Insertar producto' class='confirmar'>
                <a href='productos.php'><input type='button' value='Ver productos' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"])) {
        $sentencia = "insert into producto values ('','$nombre','$precio')";

        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO<br><br>RECARGA LA PÁGINA PARA VER LOS CAMBIOS</p>";
            header("refresh:1;url=productos.php");
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