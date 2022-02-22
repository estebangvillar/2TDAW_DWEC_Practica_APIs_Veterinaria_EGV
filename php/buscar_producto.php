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
    if (!isset($_POST["buscar"])) {
        $nombre  = "";
        $precio  = "";
    } else {
        $nombre  = $_POST["nombre"];
        $precio  = $_POST["precio"];
    }

    echo "
        <div class='formulario'>
            <div class='titulo_form'>
            <h2>🔽BUSCAR PRODUCTO🔽</h2>
        </div>
        <form name='formulario' action='buscar_producto.php' method='POST'>
            <label for='nombre'>Nombre: </label>
            <input type='text' name='nombre' id='nombre' value='$nombre'>
            <br>
            <label for='precio'>Precio: </label>
            <input type='text' name='precio' id='precio' value='$precio'>
            <br>
            <label for='buscar'></label>
            <input type='submit' name='buscar' id='buscar' value='Buscar producto' class='confirmar'>
            <a href='productos.php'><input type='button' value='Ver productos' class='confirmar'></a>
            <br>
        </form>
		</div>
	";

    if (isset($_POST["buscar"])) {
        if ($_POST["nombre"] && !$_POST["precio"]) {
            $sentencia = "select * from producto where nombre like '$_POST[nombre]%'";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado == true) {
                $datos = $conexion->query($sentencia);
                if (!$datos) {
                    echo "ERROR! $conexion->error";
                } else {
                    if ($datos->num_rows <= 0) {
                        echo "No hay productos para mostrar";
                    } else {
                        echo "<div id='productos'>";
                        while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                            echo "
                            <div class='producto'>
                                <form action='modificar_producto.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                    <input type='text' name='nombre' value='$fila[nombre]' class='infoprod' readonly><br>
                                    <input type='number' name='precio' value='$fila[precio]' class='infoprod' readonly><br>
                                    <input type='submit' value='Modificar' class='confirmar'>
                                </form>
                            </div>
                        ";
                        }
                        echo "</div>";
                    }
                }
            } else {
                echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE BUSCAR</p><br><br>";
            }
        } elseif (!$_POST["nombre"] && $_POST["precio"]) {
            $sentencia = "select * from producto where precio like '%$_POST[precio]%'";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado) {
                $datos = $conexion->query($sentencia);
                if (!$datos) {
                    echo "ERROR! $conexion->error";
                } else {
                    if ($datos->num_rows <= 0) {
                        echo "No hay productos para mostrar";
                    } else {
                        echo "<div id='productos'>";
                        while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                            echo "
                            <div class='producto'>
                                <form action='modificar_producto.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                    <input type='text' name='nombre' value='$fila[nombre]' class='infoprod' readonly><br>
                                    <input type='number' name='precio' value='$fila[precio]' class='infoprod' readonly><br>
                                    <input type='submit' value='Modificar' class='confirmar'>
                                </form>
                            </div>
                        ";
                        }
                        echo "</div>";
                    }
                }
            } else {
                echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE BUSCAR</p><br><br>";
            }
        } else {
            $sentencia = "select * from producto where nombre like '$_POST[nombre]%' and precio like '%$_POST[precio]%'";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado == true) {
                $datos = $conexion->query($sentencia);
                if (!$datos) {
                    echo "ERROR! $conexion->error";
                } else {
                    if ($datos->num_rows <= 0) {
                        echo "No hay productos para mostrar";
                    } else {
                        echo "<div id='productos'>";
                        while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                            echo "
                            <div class='producto'>
                                <form action='modificar_producto.php' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                    <input type='text' name='nombre' value='$fila[nombre]' class='infoprod' readonly><br>
                                    <input type='number' name='precio' value='$fila[precio]' class='infoprod' readonly><br>
                                    <input type='submit' value='Modificar' class='confirmar'>
                                </form>
                            </div>
                        ";
                        }
                        echo "</div>";
                    }
                }
            } else {
                echo "<p class='mensaje_error'>HAY UN ERROR Y NO SE PUEDE BUSCAR</p><br><br>";
            }
        }
    }
    ?>
</body>

</html>