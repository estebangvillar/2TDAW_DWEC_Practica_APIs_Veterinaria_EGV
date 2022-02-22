<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="2;url=citas.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Coral Clínica Veterinaria</title>
</head>

<body>
    <?php
    require_once("funciones.php");
    redireccion();
    if (!isset($_GET["eliminar"])) {
        echo "ESTA PÁGINA SOLO SE PUEDE EJECUTAR DESDE EL BOTÓN";
        $cliente = "";
        $servicio = "";
        $fecha = "";
        $hora = "";
    } else {
        $cliente = $_GET["cliente"];
        $servicio = $_GET["servicio"];
        $fecha = $_GET["fecha"];
        $hora = $_GET["hora"];
    }

    if (isset($_GET["eliminar"])) {
        //Código 
        $segundosHoy = time();
        // $hoy=date("Y-m-d",$segundosHoy);
        $segundosTuFecha = strtotime($fecha);
        //echo "La fecha actual es $hoy<br>";
        //echo "La fecha de la cita que deseas eliminar es $fecha<br>";
        //echo "Hasta hoy han transcurrido $segundosHoy segundos <br>";
        //echo "Hasta $fecha han transcurrido $segundosTuFecha segundos <br><br>";

        if ($segundosTuFecha < $segundosHoy) {
            echo "Solo se pueden eliminar citas futuras (hoy excluido)";
        } else {
            echo "La cita es futura, puede eliminarse <br><br>";
            $sentencia = "delete from citas where cliente=$cliente and servicio=$servicio and fecha='$fecha' and hora='$hora'";
            //echo "$sentencia<br><br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado) {
                echo "ELIMINADA CON ÉXITO<br><br>";
            } else {
                echo "HAY UN ERROR Y NO SE PUEDE ELIMINAR<br><br>";
            }
            echo "VOLVIENDO A CITAS...";
        }
    }

    ?>
    <a href='citas.php'><input type='button' value='Ver citas' class='confirmar'></a>
</body>

</html>