<?php

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="css/styles.css">
    <script type="text/javascript" src="js/app.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Coral Clínica Veterinaria</title>
</head>

<body>
    <header>
        <img src="assets/logo-min.png" id="logo">
        <?php
        require_once("php/funciones.php");
        contructor_menu();
        ?>
        <div id='bg'>
            <img src='assets/bg-min.jpg'>
        </div>";
    </header>

    <main>
        <h2 class='titulo'>Últimas noticias</h2>
        <?php
        $conexion = conex();
        $sentencia = "Select * from noticia order by fecha_publicacion DESC limit 0,3";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay noticias para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    $cortado = substr($fila['contenido'], 0, 484);
                    $cortado .= "...";
                    $nuevaFecha = date('d/m/Y', strtotime($fila['fecha_publicacion'])); //Para mostrarla en formato "español"
                    echo "
                    <div class='tarjetas'>
                        <form action='php/ficha_noticia.php' method='POST' id='idnoticia'>
                            <input type='number' name=id value='$fila[id]' class='ocultar'>
                            <h2>$fila[titulo]</h2>
                            <div>
                                <p>$cortado</p>
                                <img src='$fila[imagen]'>
                            </div>
                            <span>$nuevaFecha</span>
                            <input type='submit' name='leermas' value='Leer más' class='confirmar'>
                        </form>
                    </div>
                    ";
                }
            }
        }

        ?>
        <section id="nuestros_perritos" class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center">Nuestros perros</h2>
                </div>
            </div>
            <div id="perros" class="row">
            </div>
        </section>
        <h2 class="titulo">Un testimonio cualquiera...</h2>
        <?php
        $conexion = conex();;
        $sentencia = "select contenido, nombre from testimonio t, dueño d where t.dni_autor=d.dni order by rand() limit 0,1;";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay testimonios para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "
                    <div class='tarjetas'>
                        <h2>$fila[nombre]</h2>
                        <div>
                            <p>$fila[contenido]</p>
                        </div>
                    </div>
                    ";
                }
            }
        }

        $conexion->close();
        ?>

        <div id="newsletter">
            <p>¿TE LLAMAMOS?</p>
        </div>

        <div class="formulario">
            <form>
                <label for="emailJs">Correo electrónico</label>
                <input type="text" name="emailJs" id="tlfJs">
                <!----><br>
                <label for="tlfJs">Teléfono</label>
                <input type="tel" name="tlfPhp" id="tlfJs" maxlength=9>
                <!----><br>
                <label for="botonJs"></label>
                <input type="submit" name="botonPhp" id="botonJs" value="Recibir información">
            </form>
        </div>



    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>