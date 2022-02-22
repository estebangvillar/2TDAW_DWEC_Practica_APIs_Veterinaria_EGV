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
    <header>
        <img src="../assets/logo-min.png" id="logo">
        <?php
        require_once("funciones.php");
        contructor_menu();
        ?>
    </header>

    <main>

        <?php
        $conexion = conex();
        $sentencia = "Select * from servicio";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay servicios para mostrar";
            } else {
                echo "<div id='servicios'>";
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    if (!isset($_COOKIE["sesion"])) {
                        echo "
                        <div class='servicio'>
                            <form action='modificar_servicio.php' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                <input type='text' name='descripcion' value='$fila[descripcion]' class='infoserv' readonly><br>
                                <input type='text' name='duracion' value='$fila[duracion]' class='infoserv' readonly><br>minutos
                                <input type='text' name='precio' value='$fila[precio]' class='infoserv' readonly><br><br>€
                            </form>
                        </div>
                    ";
                    } else {
                        session_decode($_COOKIE["sesion"]);
                        $usuario = $_SESSION["usuario"];
                        $pass = $_SESSION["pass"];
                        if (strpos($usuario, "admin") !== false) {
                            echo "
                            <div class='servicio'>
                                <form action='modificar_servicio.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                    <input type='text' name='descripcion' value='$fila[descripcion]' class='infoserv' readonly><br>
                                    <input type='text' name='duracion' value='$fila[duracion]' class='infoserv' readonly><br>minutos
                                    <input type='text' name='precio' value='$fila[precio]' class='infoserv' readonly><br><br>€
                                    <input type='submit' value='Modificar' class='confirmar'>
                                </form>
                            </div>
                        ";
                        } else {
                            echo "
                            <div class='servicio'>
                                <form action='modificar_servicio.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                    <input type='text' name='descripcion' value='$fila[descripcion]' class='infoserv' readonly><br>
                                    <input type='text' name='duracion' value='$fila[duracion]' class='infoserv' readonly><br>minutos
                                    <input type='text' name='precio' value='$fila[precio]' class='infoserv' readonly><br><br>€
                                </form>
                            </div>
                        ";
                        }
                    }
                }
                echo "</div>";
            }
        }

        if (!isset($_COOKIE["sesion"])) {
            echo '<div id="dos_opciones">
                <a href="buscar_servicio.php"><input type="button" value="Buscar servicio" class="confirmar"></a>
            </div>';
        } else {
            $usuario = strtolower($usuario);
            if (strpos($usuario, "admin") !== false) {
                echo '<div id="dos_opciones">
                    <a href="insertar_servicio.php"><input type="button" value="Insertar servicio" class="confirmar"></a>
                    <a href="buscar_servicio.php"><input type="button" value="Buscar servicio" class="confirmar"></a>
                </div>';
            } else {
                echo '<div id="dos_opciones">
                    <a href="buscar_servicio.php"><input type="button" value="Buscar servicio" class="confirmar"></a>
                </div>';
            }
        }
        ?>

    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>