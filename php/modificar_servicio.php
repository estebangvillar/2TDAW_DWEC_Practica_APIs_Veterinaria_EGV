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
    $descripcion = $_POST["descripcion"];
    $duracion = $_POST["duracion"];
    $precio  = $_POST["precio"];


    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽MODIFICAR SERVICIO🔽</h2>
            </div>
            <form name='formulario' action='modificar_servicio.php' method='POST' enctype='multipart/form-data'>
                <label for='id'>ID: </label>
                <input type='text' readonly name='id' id='id' value='$id'>
                <br>
                <label for='descripcion'>Descripcion: </label>
                <input type='text' name='descripcion' id='descripcion' value='$descripcion'>
                <br>
                <label for=''>Duracion: </label>
                <input type='number' name='duracion' id='duracion' value='$duracion'>
                <br>
                <label for='Precio'>Precio: </label>
                <input type='number' name='precio' id='precio' value='$precio'>
                <br><br>
                <label for='modificar'></label>
                <input type='submit' name='modificar' id='modificar' value='Modificar servicio' class='confirmar'>
                <a href='servicios.php'><input type='button' value='Ver servicios' class='confirmar'></a>
            </form>
        </div>
    ";

    if (isset($_POST["modificar"])) {
        $sentencia = "UPDATE servicio
        SET id='$id', descripcion = '$descripcion', duracion='$duracion', precio='$precio'
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
    ?>

</body>

</html>