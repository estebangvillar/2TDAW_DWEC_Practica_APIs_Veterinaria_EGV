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
        $autor = "";
        $contenido  = "";
        $fecha  = "";
    } else {
        $autor  = $_POST["autor"];
        $contenido  = $_POST["contenido"];
        $fecha  = $_POST["fecha"];
    }

    $sacarID = 'select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA="veterinaria" and TABLE_NAME="testimonio"';
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
                <h2>🔽INSERTAR TESTIMONIO🔽</h2>
            </div>
            <form name='formulario' action='insertar_testimonio.php' enctype='multipart/form-data' method='POST'>
                <label for='id'>ID: </label>
                <input type='text' disabled name='id' id='id' value='$idservicio'>
                <br>
                <label for='autor'>Autor:<span style='color:red'>*</span> </label>
                <select name='autor' required>";
    echo "<option value='vacio' selected>🔽Elige un autor🔽</option>";
    $sentencia = "Select dni, nombre, nick from dueño";
    $datos = $conexion->query($sentencia);
    if (!$datos) {
        echo "ERROR! $conexion->error";
    } else {
        if ($datos->num_rows <= 0) {
            echo "No hay autor para mostrar";
        } else {
            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                echo "<option value='$fila[dni]'>$fila[nombre] - $fila[nick] - $fila[dni]</option>";
            }
        }
    }
    echo "
                </select>
                <br>
                <label for='contenido'>Contenido:<span style='color:red'>*</span> </label>
                <textarea name='contenido' id='contenido' value='$contenido'></textarea>
                <br>
                <label for='fecha'>Fecha:<span style='color:red'>*</span> </label>
                <input type='date' name='fecha' id='fecha' value='$fecha'>
                <br>
                <label for='añadir'></label>
                <input type='submit' name='añadir' id='añadir' value='Insertar testimonio' class='confirmar'>
                <a href='testimonios.php'><input type='button' value='Ver testimonios' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"]) && $autor != "vacio" && $contenido != "" && $fecha != "") {
        $sentencia = "insert into testimonio values ('','$autor','$contenido','$fecha')";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO<br><br>RECARGA LA PÁGINA PARA VER LOS CAMBIOS</p>";
            header("refresh:1;url=testimonios.php");
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