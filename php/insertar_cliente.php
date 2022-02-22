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
        $tipo  = "";
        $nombre  = "";
        $edad  = "";
        $dueño  = "";
    } else {
        $tipo  = $_POST["tipo"];
        $nombre  = $_POST["nombre"];
        $edad  = $_POST["edad"];
        $dueño  = $_POST["dueño"];
    }

    $sacarID = 'select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA="veterinaria" and TABLE_NAME="cliente"';
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
                    $idcliente = $fila[0];
                }
            }
        }
    } else {
        echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE BUSCAR</p><br><br>";
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽INSERTAR CLIENTE🔽</h2>
            </div>
            <form name='formulario' action='insertar_cliente.php' enctype='multipart/form-data' method='POST'>
                <label>ID: </label>
                <input type='text' placeholder='$idcliente' disabled>
                <br>
                <label for='foto'>Foto:<span style='color:red'>*</span> </label>
                <input type='file' name='foto' id='foto' required>
                <br>
                <label for='tipo'>Tipo:<span style='color:red'>*</span> </label>
                <input type='text' name='tipo' id='tipo' value='$tipo' required>
                <br>
                <label for='nombre'>Nombre:<span style='color:red'>*</span> </label>
                <input type='text' name='nombre' id='nombre' value='$nombre' required>
                <br>
                <label for='edad'>Edad:<span style='color:red'>*</span> </label>
                <input type='number' name='edad' id='edad' value='$edad' required>
                <br>
                <label for='dueño'>Dueño:<span style='color:red'>*</span> </label>
                <select name='dueño' required>";
    echo "<option value='vacio' selected>🔽Elige un dueño🔽</option>";
    $sentencia = "Select dni, nombre, nick from dueño";
    $datos = $conexion->query($sentencia);
    if (!$datos) {
        echo "ERROR! $conexion->error";
    } else {
        if ($datos->num_rows <= 0) {
            echo "No hay dueños para mostrar";
        } else {
            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='$fila[dni]'>$fila[nombre] - $fila[nick] - $fila[dni]</option>";
            }
        }
    }
    echo "
                </select>
                <br><br>
                <label for='añadir'></label>
                <input type='submit' name='añadir' id='añadir' value='Insertar cliente' class='confirmar'>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"]) && isset($_FILES['foto']) && $tipo != "" && $nombre != "" && $edad != "" && $dueño != "vacio") {
        $name = $_FILES["foto"]["name"];
        $temp = $_FILES["foto"]["tmp_name"];
        if (!file_exists("../assets")) {
            mkdir("../assets");
        }
        $ruta = "../assets/$name";
        move_uploaded_file($temp, "$ruta");
        $sentencia = "insert into cliente values ('','$tipo','$nombre','$edad','$dueño','$ruta')";
        $comprobarRepetido = "select count(id) num from cliente where tipo=? and nombre=? and dni_dueño=?";
        $conexion = conex();
        $consulta = $conexion->prepare($comprobarRepetido);
        $consulta->bind_param("sss", $tipo, $nombre, $dueño);
        $consulta->execute();
        $consulta->bind_result($num);
        $consulta->fetch();
        if ($num == 0) {
            $consulta->close();
            $insertar = "insert into cliente values ('',?,?,?,?,?)";
            $consulta_insertar = $conexion->prepare($insertar);
            $consulta_insertar->bind_param("sssss", $tipo, $nombre, $edad, $dueño, $ruta);
            $consulta_insertar->execute();
            $consulta_insertar->close();
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO</p>";
            header("refresh:1.5;url=clientes.php");
        } else {
            echo "<p class='mensaje_error'>ERROR, EL USUARIO YA EXISTE</p>";
            header("refresh:1.5;url=clientes.php");
        }
    } else {
        echo "<p class='mensaje_error'>COMPLETA TODOS LOS CAMPOS POR FAVOR</p>";
    }
    $conexion->close();


    ?>
</body>

</html>