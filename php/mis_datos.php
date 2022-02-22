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
        redireccion();
        contructor_menu();
        ?>
    </header>

    <main>

        <?php
        $conexion = conex();
        session_decode($_COOKIE["sesion"]);
        $usuario = $_SESSION["usuario"];
        $sentencia = "Select * from dueño where nick='$usuario'";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay datos para mostrar";
            } else {
                echo "<div id='datos'>";
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                        <div class='dato'>
                            <form action='modifico_datos.php' method='POST' enctype='multipart/form-data'>
                                DNI:<input type='text' name='dni' value='$fila[dni]' readonly>
                                Nombre:<input type='text' name='nombre' value='$fila[nombre]' readonly>
                                Teléfono:<input type='text' name='telefono' value='$fila[telefono]' readonly>
                                Nick:<input type='text' name='nick' value='$fila[nick]' readonly>
                                <input type='hidden' name='pass' class='ocultar'>
                                <input type='submit' value='Modificar' class='confirmarh'>
                            </form>
                        </div>
                    ";
                }
                echo "</div>";
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