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
    $id = $_POST["id"];
    $foto = $_FILES["foto"];
    $tipo  = $_POST["tipo"];
    $nombre  = $_POST["nombre"];
    $edad  = $_POST["edad"];
    $dueño  = $_POST["dni_dueño"];


    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽MODIFICAR CLIENTE🔽</h2>
            </div>
            <form name='formulario' action='modificar_cliente.php' method='POST' enctype='multipart/form-data'>
                <label for='id'>ID: </label>
                <input type='text' readonly name='id' id='id' value='$id'>
                <br>
                <label for='foto'>Foto: </label>
                <input type='file' name='foto' id='foto'>
                <br>
                <label for='tipo'>Tipo: </label>
                <input type='text' name='tipo' id='tipo' value='$tipo'>
                <br>
                <label for='nombre'>Nombre: </label>
                <input type='text' name='nombre' id='nombre' value='$nombre'>
                <br>
                <label for='edad'>Edad: </label>
                <input type='text' name='edad' id='edad' value='$edad'>
                <br>
                <label for='dueño'>Dueño: </label>
                <select name='dni_dueño' required>";
    $sentencia = "Select dni, nombre, nick from dueño where nombre='$dueño'";
    $conexion = conex();
    $datos = $conexion->query($sentencia);
    if (!$datos) {
        echo "ERROR! $conexion->error";
    } else {
        if ($datos->num_rows <= 0) {
            echo "No hay dueños para mostrar";
        } else {
            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='$fila[dni]'>$fila[nombre] - $fila[nick] - $fila[dni]</option>";
                $noRepetirOpcion = $fila["dni"];
            }
        }
    }
    $sentencia = "Select dni, nombre, nick from dueño";
    $datos = $conexion->query($sentencia);
    if (!$datos) {
        echo "ERROR! $conexion->error";
    } else {
        if ($datos->num_rows <= 0) {
            echo "No hay dueños para mostrar";
        } else {
            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                if ($fila["dni"] == $noRepetirOpcion) {
                } else {
                    echo "<option value='$fila[dni]'>$fila[nombre] - $fila[nick] - $fila[dni]</option>";
                }
            }
        }
    }
    echo "
                </select>
                <br><br>
                <label for='modificar'></label>
                <input type='submit' name='modificar' id='modificar' value='Modificar cliente' class='confirmar'>
                <a href='clientes.php'><input type='button' value='Ver Clientes' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["modificar"])) {
        if ($_FILES['foto']['size'] == 0) {
            $sentencia = "UPDATE cliente
            SET tipo = '$tipo', nombre='$nombre', edad=$edad, dni_dueño='$dueño'
            WHERE id=$id";
            echo "<br>Ejecutando...<br><br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado == true) {
                echo "MODIFICADO CON ÉXITO<br><br>";
            } else {
                echo "HAY UN ERROR Y NO SE PUEDE REGISTRAR<br><br>";
            }
            $conexion->close();
        } else {
            $name = $_FILES["foto"]["name"];
            $temp = $_FILES["foto"]["tmp_name"];
            if (!file_exists("../assets")) {
                mkdir("../assets");
            }
            $ruta = "../assets/$name";
            move_uploaded_file($temp, "$ruta");
            $sentencia = "UPDATE cliente
            SET foto='$ruta', tipo = '$tipo', nombre='$nombre', edad=$edad, dni_dueño='$dueño'
            WHERE id=$id";
            echo "<br>Ejecutando...<br><br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado == true) {
                echo "MODIFICADO CON ÉXITO<br><br>";
            } else {
                echo "HAY UN ERROR Y NO SE PUEDE REGISTRAR<br><br>";
            }
            $conexion->close();
        }
    }


    ?>
</body>

</html>