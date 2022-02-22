<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <script type="text/javascript" src="../javascript/validacion_jquery.js" defer></script>
    <title>Coral Clínica Veterinaria</title>
</head>

<body>
    <?php
    require_once("funciones.php");
    redireccion();
    if (!isset($_POST["añadir"])) {
        $dni  = "";
        $nombre  = "";
        $telefono  = "";
        $nick  = "";
        $pass  = "";
    } else {
        $dni  = $_POST["dni"];
        $nombre  = $_POST["nombre"];
        $telefono  = $_POST["telefono"];
        $nick  = $_POST["nick"];
        $pass  = $_POST["pass"];
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽INSERTAR CLIENTE🔽</h2>
            </div>
            <form name='formulario' action='#' enctype='multipart/form-data' method='POST'>
                <label for='dni'>DNI:<span style='color:red'>*</span> </label>
                <input type='text' name='dni' id='dni' value='$dni' required>
                <br>
                <label for='nombre'>Nombre:<span style='color:red'>*</span> </label>
                <input type='text' name='nombre' id='nombre' value='$nombre' required>
                <br>
                <label for='telefono'>Telefono: </label>
                <input type='text' name='telefono' id='telefono' value='$telefono' minlength=9 maxlength=9>
                <br>
                <label for='nick'>Nick:<span style='color:red'>*</span> </label>
                <input type='text' name='nick' id='nick' value='$nick' required>
                <br>
                <label for='pass'>Contraseña:<span style='color:red'>*</span> </label>
                <input type='password' name='pass' id='pass' value='$pass' required>
                <br>
                <label for='añadir'></label>
                <input type='submit' name='añadir' id='añadir' value='Insertar cliente' class='confirmar'>
            </form>
        </div>
    ";

    if (isset($_POST["añadir"])) {
        $pass = md5($pass);
        //     $sentencia = "insert into dueño values ('','$dni','$nombre','$telefono','$nick','$pass')";
        //     $conexion = conex();
        //     $resultado = $conexion->query($sentencia);
        //     if ($resultado == true) {
        //         echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO</p>";
        //         header("refresh:1;url=duenos.php");
        //         $conexion->close();
        //     } else {
        //         echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE REGISTRAR</p><br><br>";
        //         $conexion->close();
        //     }
        // }else{
        //     echo "<p class='mensaje_error'>COMPLETA TODOS LOS CAMPOS POR FAVOR</p>";
        //     $conexion->close();
        // }

        $comprobarRepetido = "select count(dni) num from dueño where dni=?";
        $conexion = conex();
        $consulta = $conexion->prepare($comprobarRepetido);
        $consulta->bind_param("s", $dni);
        $consulta->execute();
        $consulta->bind_result($num);
        $consulta->fetch();
        if ($num == 0) {
            $consulta->close();
            $insertar = "insert into dueño values (?,?,?,?,?)";
            $consulta_insertar = $conexion->prepare($insertar);
            $consulta_insertar->bind_param("sssss", $dni, $nombre, $telefono, $nick, $pass);
            $consulta_insertar->execute();
            $consulta_insertar->close();
            echo "<p class='mensaje_ok'>REGISTRADO CON ÉXITO</p>";
            header("refresh:1.5;url=duenos.php");
        } else {
            echo "<p class='mensaje_error'>ERROR, EL USUARIO YA EXISTE</p>";
            header("refresh:1.5;url=duenos.php");
        }
    }
    ?>
</body>

</html>