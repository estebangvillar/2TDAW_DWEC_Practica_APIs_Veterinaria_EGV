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
        $titulo  = "";
        $contenido  = "";
        $fecha_publicacion  = "";
    } else {
        $titulo  = $_POST["titulo"];
        $contenido  = $_POST["contenido"];
        $fecha_publicacion  = $_POST["fecha_publicacion"];
    }

    $sacarID = 'select AUTO_INCREMENT from information_schema.TABLES where TABLE_SCHEMA="veterinaria" and TABLE_NAME="noticia"';
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
                    $idnoticia = $fila[0];
                }
            }
        }
    } else {
        echo "HAY UN ERROR Y NO SE PUEDE EXTRAER EL ID<br><br>";
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽INSERTAR NOTICIA🔽</h2>
            </div>
            <form name='formulario' action='insertar_noticia.php' enctype='multipart/form-data' method='POST'>
                <label>ID: </label>
                <input type='text' placeholder='$idnoticia' disabled>
                <br>
                <label for='titulo'>Titulo:<span style='color:red'>*</span> </label>
                <input type='text' name='titulo' id='titulo' value='$titulo'>
                <br>
                <label for='contenido'>Contenido:<span style='color:red'>*</span> </label>
                <textarea name='contenido' id='contenido' value='$contenido'></textarea>
                <br>
                <label for='foto'>Foto:<span style='color:red'>*</span> </label>
                <input type='file' name='foto' id='foto'>
                <br>
                <label for='fecha_publicacion'>Fecha de publicacion:<span style='color:red'>*</span> </label>
                <input type='date' name='fecha_publicacion' id='fecha_publicacion' value='$fecha_publicacion'>
                <br>
                <label for='añadir'></label>
                <input type='submit' name='añadir' id='añadir' value='Insertar noticia' class='confirmar'>
                <a href='noticias.php'><input type='button' value='Ver noticias' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"]) && $titulo != "" && $contenido != "" && $_FILES["foto"]["size"] != 0 && $fecha_publicacion != "") {
        $name = $_FILES["foto"]["name"];
        $temp = $_FILES["foto"]["tmp_name"];
        if (!file_exists("../assets")) {
            mkdir("../assets");
        }
        $ruta = "../assets/$name";
        move_uploaded_file($temp, "$ruta");
        $sentencia = "insert into noticia values ('','$titulo','$contenido','$name','$fecha_publicacion')";

        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO<br><br>RECARGA LA PÁGINA PARA VER LOS CAMBIOS</p>";
            header("refresh:1;url=noticias.php");
        } else {
            echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE REGISTRAR</p><br><br>";
        }
    } else {
        echo "<p class='mensaje_error'>COMPLETA TODOS LOS CAMPOS POR FAVOR</p>";
    }
    $conexion->close();
    ?>
</body>

</html>