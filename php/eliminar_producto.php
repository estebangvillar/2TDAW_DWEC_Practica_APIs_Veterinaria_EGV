<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="3;url=productos.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Coral Clínica Veterinaria</title>
</head>

<body>
    <?php
    require_once("funciones.php");
    redireccion();
    if (!isset($_POST["eliminar"])) {
        echo "ESTA PÁGINA SOLO SE PUEDE EJECUTAR DESDE EL BOTÓN";
        $id = "";
    } else {
        $id  = $_POST["id"];
    }

    if (isset($_POST["eliminar"])) {
        $sentencia = "delete from producto where id=$id";

        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "ELIMINADO CON ÉXITO<br><br>VOLVIENDO A PRODUCTOS...";
        } else {
            echo "HAY UN ERROR Y NO SE PUEDE ELIMINAR<br><br>";
        }
    }

    ?>
    <a href='productos.php'><input type='button' value='Ver productos' class='confirmar'></a>
</body>

</html>