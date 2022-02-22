<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/favicon-min.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/styles.css">
    <script type="text/javascript" src="../js/app.js" defer></script>
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


        <div id="dos_opciones">
            <a href="insertar_noticia.php"><input type="button" value="Insertar noticia" class="confirmar"></a>
        </div>

        <section id="noticiasPagina">

            <div id='lista_noticias'></div>;

        </section>

    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>