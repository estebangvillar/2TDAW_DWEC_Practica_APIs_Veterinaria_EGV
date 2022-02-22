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
        $sentencia = "Select * from noticia where id=$_POST[id]";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay noticias para mostrar";
            } else {
                echo "<div id='clientes'>";
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                <div class='tarjetas'>
                        <form action='ficha_noticia.php' method='POST' id='idnoticia'>
                            <input type='number' name=id value='$fila[id]' class='ocultar'>
                        <h2>$fila[titulo]</h2>
                        <div>
                            <p>$fila[contenido]</p>
                            <img src='$fila[imagen]'>
                        </div><br>
                        <span>$fila[fecha_publicacion]</span>
                        </form>
                </div>
                ";
                }
                echo "</div>";
            }
        }
        ?>
        <div id="dos_opciones">
            <a href="insertar_noticia.php"><input type="button" value="Insertar noticia" class="confirmar"></a>
            <a href='noticias.php'><input type='button' value='Ver noticias' class='confirmar'></a>
        </div>
    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>