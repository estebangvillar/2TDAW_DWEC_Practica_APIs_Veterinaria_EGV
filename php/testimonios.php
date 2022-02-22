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
        $sentencia = "Select * from testimonio, dueño where testimonio.dni_autor=dueño.dni order by fecha";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay testimonios para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    $nuevaFecha = date('d/m/Y', strtotime($fila['fecha']));
                    echo "
                    <div class='tarjetas'>
                        <h2>$fila[nombre]</h2>
                        <div class='reseña'>
                            <p>$fila[contenido]</p>
                            <p>$nuevaFecha</p>
                        </div>
                    </div>
                    ";
                }
                echo "</div>";
            }
        }
        ?>
        <div id="dos_opciones">
            <a href="insertar_testimonio.php"><input type="button" value="Insertar testimonio" class="confirmar"></a>
        </div>

    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>