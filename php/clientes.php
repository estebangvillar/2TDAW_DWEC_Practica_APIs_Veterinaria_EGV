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
        $sentencia = "Select * from cliente, dueño where cliente.dni_dueño=dueño.dni order by cliente.nombre";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay clientes para mostrar";
            } else {
                echo "<div id='clientes'>";
                while ($fila = $datos->fetch_array(MYSQLI_NUM)) {
                    echo "
                        <div class='cliente'>
                            <form action='modificar_cliente.php' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$fila[0]' class='ocultar'>
                                <input type='file' name='foto' value='$fila[5]' hidden class='ocultar'><img src='$fila[5]' id='fotocliente'><br>
                                Tipo: <input type='text' name='tipo' value='$fila[1]' readonly><br>
                                Nombre: <input type='text' name='nombre' value='$fila[2]' readonly><br>
                                Edad: <input type='text' name='edad' value='$fila[3]' readonly><br>
                                Dueño: <input type='text' name='dni_dueño' value='$fila[7]' readonly><br>
                                <input type='submit' value='Modificar' class='confirmar'>
                            </form>
                        </div>
                    ";
                }
                echo "</div>";
            }
        }
        ?>
        <div id="dos_opciones">
            <a href="insertar_cliente.php"><input type="button" value="Insertar cliente" class="confirmar"></a>
            <a href="buscar_cliente.php"><input type="button" value="Buscar cliente" class="confirmar"></a>
        </div>

    </main>

    <footer>
        <?php
        constructor_footer();
        ?>
    </footer>
</body>

</html>