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
        $descripcion  = "";
    } else {
        $descripcion  = $_POST["descripcion"];
    }

    echo "
                    <div class='formulario'>
                    <div class='titulo_form'>
                    <h2>🔽BUSCAR SERVICIO🔽</h2>
                    </div>
                    <form name='formulario' action='buscar_servicio.php' method='POST'>
                        <label for='descripcion'>Descripcion: </label>
                        <input type='text' name='descripcion' id='descripcion' value='$descripcion'>
                        <br><br>
                        <label for='buscar'></label>
                        <input type='submit' name='buscar' id='buscar' value='Buscar servicio' class='confirmar'>
                        <a href='servicios.php'><input type='button' value='Ver servicios' class='confirmar'></a>
                        <br>
                    </form>
				</div>
			";

    if (isset($_POST["buscar"])) {
        $sentencia = "select * from servicio where descripcion like '$_POST[descripcion]%'";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado) {
            $datos = $conexion->query($sentencia);
            if (!$datos) {
                echo "ERROR! $conexion->error";
            } else {
                if ($datos->num_rows <= 0) {
                    echo "No hay servicios para mostrar";
                } else {
                    echo "<div id='servicios'>";
                    while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                        echo "
                        <div class='servicio'>
                            <form action='modificar_servicio.php' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$fila[id]' class='ocultar'><br>
                                <input type='text' name='descripcion' value='$fila[descripcion]' class='infoserv' readonly><br>
                                <input type='text' name='duracion' value='$fila[duracion]' class='infoserv' readonly><br>
                                <input type='text' name='precio' value='$fila[precio]' class='infoserv' readonly><br>
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
    ?>
</body>

</html>