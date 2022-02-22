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
        $sentencia = "Select * from dueño where nick not like '%admin%'";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay dueños para mostrar";
            } else {
                echo "<div id='dueños'>";
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                        <div class='dueño'>
                            <form action='modificar_dueño.php' method='POST' enctype='multipart/form-data'>
                                DNI:<input type='text' name='dni' value='$fila[dni]' readonly>
                                Nombre:<input type='text' name='nombre' value='$fila[nombre]' readonly>
                                Teléfono:<input type='text' name='telefono' value='$fila[telefono]' readonly>
                                Nick:<input type='text' name='nick' value='$fila[nick]' readonly>
                                <input type='hidden' name='pass' value='$fila[pass]' class='ocultar'>
                                <input type='submit' value='Modificar' class='confirmarh'>
                            </form>
                        </div>
                    ";
                }
                echo "</div>";
            }
        }
        ?>
        <div id="dos_opciones">
            <a href="insertar_dueño.php"><input type="button" value="Insertar dueño" class="confirmar"></a>
            <a href="buscar_dueño.php"><input type="button" value="Buscar dueño" class="confirmar"></a>
        </div>

    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>