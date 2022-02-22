<?php
session_start();
require_once("funciones.php");
?>
<!DOCTYPE html>
<html lang="es" class="cuerpolog">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <title>Acceder</title>
</head>

<body class="cuerpolog">
    <?php
    if (!isset($_POST['enviar'])) {
        $usuario = "";
        $pass = "";
        // $mantener = "";
    } else {
        $usuario = $_POST["usuario"];
        $pass = $_POST["pass"];
        // $mantener = $_POST["mantener"];
    }
    echo '
    <main style="margin-top:0px">
        <div id="generalAcceder" class="cuerpolog">
            <div>
                <form id="formu" method="POST" enctype="multipart/form-data">
                    <h2>Acceder</h2>
                    <label for="usuario"></label>
                    <input type="text" name="usuario" id="usuario" placeholder="Usuario" required autocomplete=off>
                    <label for="pass"></label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña" required>
                    <div id="mantenerdiv">
                        <span>Mantener sesión iniciada</span><input type="checkbox" name="mantener">
                    </div>
                    <input type="submit" name="enviar" id="enviar">
                </form>
            </div>

            <div id="imagenAcceder">
                <img src="../assets/favicon-min.png">
            </div>
        </div>
    </main>
    ';
    if (isset($_POST["enviar"])) {
        $pass = md5($pass);
        $comprobarExiste = "select count(dni) from dueño where nick=? and pass=?";
        $conexion = conex();
        $consulta = $conexion->prepare($comprobarExiste);
        echo $conexion->error;
        $consulta->bind_param("ss", $usuario, $pass);
        $consulta->execute();
        $consulta->bind_result($num);
        $consulta->fetch();
        if ($num > 0) {
            if (isset($_POST["mantener"])) {
                $caducidad = time() + 604800;
                // echo "mantener";
            } else {
                $caducidad = time() + 1800;
                // echo "no mantener";
            }

            $_SESSION["usuario"] = $usuario;
            $_SESSION["pass"] = $pass;
            $datos = session_encode();
            echo $datos;
            setcookie('sesion', $datos, $caducidad, '/');
            echo "<p class='mensaje_ok' style='position:absolute'>SESIÓN INICIADA</p>";
            header("refresh:0;url=../index.php");
        } else {
            echo "<p class='mensaje_error'>ERROR, USUARIO Y/O CONTRASEÑA INCORRECTOS</p>";
            // header("refresh:1.5;url=clientes.php");
        }
    }
    ?>
</body>

</html>