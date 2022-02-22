<?php
if (session_id() != "") {
} else {
    session_start();
}
?>
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
        $sentencia = "Select * from producto";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay productos para mostrar";
            } else {
                echo "<div id='productos'>";
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    if (!isset($_COOKIE["sesion"])) {
                        echo "
                    <div class='producto'>
                        <form action='modificar_producto.php' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                            <input type='text' name='nombre' value='$fila[nombre]' class='infoprod' readonly><br>
                            <input type='number' name='precio' value='$fila[precio]' class='infoprod' readonly style='text-align:right;width:18%'>€<br>
                            
                        </form>
                        
                    </div>
                ";
                    } else {
                        session_decode($_COOKIE["sesion"]);
                        $usuario = $_SESSION["usuario"];
                        $pass = $_SESSION["pass"];
                        if (strpos($usuario, "admin") !== false) {
                            echo "
                    <div class='producto'>
                        <form action='modificar_producto.php' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                            <input type='text' name='nombre' value='$fila[nombre]' class='infoprod' readonly><br>
                            <input type='number' name='precio' value='$fila[precio]' class='infoprod' readonly style='text-align:right;width:18%'>€<br>
                            <input type='submit' value='Modificar' class='confirmar'>
                        </form>
                        <form action='eliminar_producto.php' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' name='id' value='$fila[id]' class='ocultar'>
                            <input type='submit' name='eliminar' value='Eliminar' class='confirmar'>
                        </form>
                    </div>
                ";
                        } else {
                            echo "
                    <div class='producto'>
                        <form action='modificar_producto.php' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                            <input type='text' name='nombre' value='$fila[nombre]' class='infoprod' readonly><br>
                            <input type='number' name='precio' value='$fila[precio]' class='infoprod' readonly style='text-align:right;width:18%'>€<br>
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
            echo '  <div id="dos_opciones">
                        <a href="buscar_producto.php"><input type="button" value="Buscar producto" class="confirmar"></a>
                    </div>';
        } else {
            $usuario = strtolower($usuario);
            if (strpos($usuario, "admin") !== false) {
                echo '  <div id="dos_opciones">
                            <a href="insertar_producto.php"><input type="button" value="Insertar producto" class="confirmar"></a>
                            <a href="buscar_producto.php"><input type="button" value="Buscar producto" class="confirmar"></a>
                        </div>';
            } else {
                echo '  <div id="dos_opciones">
                            <a href="buscar_producto.php"><input type="button" value="Buscar producto" class="confirmar"></a>
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