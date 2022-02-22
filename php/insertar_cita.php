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
        $cliente  = "";
        $servicio  = "";
        $fecha  = "";
        $hora  = "";
    } else {
        $cliente  = $_POST["cliente"];
        $servicio  = $_POST["servicio"];
        $fecha  = $_POST["fecha"];
        $hora  = $_POST["hora"];
    }

    $conexion = conex();
    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽INSERTAR CITA🔽</h2>
            </div>
            <form name='formulario' action='insertar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='cliente'>Cliente:<span style='color:red'>*</span> </label>
                <select name='cliente'>";
    $sentencia = "Select id, nombre from cliente";
    $datos = $conexion->query($sentencia);
    if (!$datos) {
        echo "ERROR! $conexion->error";
    } else {
        if ($datos->num_rows <= 0) {
            echo "No hay clientes para mostrar";
        } else {
            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='$fila[id]'>$fila[nombre] - $fila[id]</option>";
            }
        }
    }
    echo "
                </select>
                <br>
                <label for='servicio'>Servicio:<span style='color:red'>*</span> </label>
                <select name='servicio'>";
    $sentencia = "Select id, descripcion from servicio";
    $datos = $conexion->query($sentencia);
    if (!$datos) {
        echo "ERROR! $conexion->error";
    } else {
        if ($datos->num_rows <= 0) {
            echo "No hay servicios para mostrar";
        } else {
            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='$fila[id]'>$fila[descripcion] - $fila[id]</option>";
            }
        }
    }
    echo "
                </select>
                <br>
                <label for='fecha'>Fecha:<span style='color:red'>*</span> </label>
                <input type='date' name='fecha' id='fecha' value='$fecha'>
                <br>
                <label for='hora'>Hora:<span style='color:red'>*</span> </label>
                <input type='time' name='hora' id='hora' value='$hora'>
                <br>
                <label for='añadir'></label>
                <input type='submit' name='añadir' id='añadir' value='Insertar cita' class='confirmar'>
                <a href='citas.php'><input type='button' value='Ver calendario' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"]) && $cliente != "" && $servicio != "" && $fecha != "" && $hora != "") {
        $sentencia = "insert into citas values ('$cliente','$servicio','$fecha','$hora')";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO<br><br>RECARGA LA PÁGINA PARA VER LOS CAMBIOS</p>";
            header("refresh:1;url=citas.php");
            $conexion->close();
        } else {
            echo "<p class='mensaje_error'>CITA OCUPADA, VUELVA A INTENTARLO</p><br><br>";
            $conexion->close();
        }
    } else {
        echo "<p class='mensaje_error'>COMPLETA TODOS LOS CAMPOS POR FAVOR</p>";
    }

    ?>
</body>

</html>