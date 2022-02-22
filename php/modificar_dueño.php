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
    $dni = $_POST["dni"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $nick = $_POST["nick"];
    $pass = $_POST["pass"];


    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽MODIFICAR DUEÑO🔽</h2>
            </div>
            <form name='formulario' action='modificar_dueño.php' method='POST' enctype='multipart/form-data'>
                <label for='dni'>DNI: </label>
                <input type='text' name='dni' id='dni' value='$dni'>
                <br>
                <label for='nombre'>Nombre: </label>
                <input type='text' name='nombre' id='nombre' value='$nombre'>
                <br>
                <label for='telefono'>Teléfono: </label>
                <input type='text' name='telefono' id='telefono' value='$telefono'>
                <br>
                <label for='nick'>Nick: </label>
                <input type='text' name='nick' id='nick' value='$nick'>
                <br>
                <label for='pass'>Contraseña: </label>
                <input type='password' name='pass' id='pass' value='$pass'>
                <br>
                <label for='modificar'></label>
                <input type='submit' name='modificar' id='modificar' value='Modificar cliente' class='confirmar'>
                <br>
            </form>
        </div>
    ";

    if (isset($_POST["modificar"])) {
        $sentencia = "UPDATE dueño
            SET dni = '$dni', nombre='$nombre', telefono='$telefono', nick='$nick', pass='$pass'
            WHERE dni='$dni'";
        // echo "<br>Ejecutando...<br><br>";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado == true) {
            echo "<p class='mensaje_ok'>MODIFICADO CON ÉXITO<br><br>VOLVIENDO A DUEÑOS</p>";
            header("refresh:1.5;url=duenos.php");
        } else {
            echo "HAY UN ERROR Y NO SE PUEDE REGISTRAR<br><br>";
            header("refresh:1.5;url=duenos.php");
        }
        $conexion->close();
    }
    ?>
</body>

</html>