<!DOCTYPE html>
<html lang='es'>

<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='icon' href='../assets/favicon-min.png' type='image/x-icon'>
    <link rel="stylesheet" href="../css/calendar.css">
    <link rel='stylesheet' href='../css/styles.css'>

    <title>Coral Clínica Veterinaria</title>
</head>

<body>
    <header>
        <img src='../assets/logo-min.png' id='logo'>
        <?php
        require_once('funciones.php');
        redireccion();
        contructor_menu();
        ?>
    </header>

    <main>
        <?php
        # definimos los valores iniciales para nuestro calendario
        if (isset($_GET["mes"])) {
            $mes = $_GET["mes"];
            $year = $_GET['año'];
        } else {
            $mes = date("n");
            $year = date('Y');
        }

        $mesAnterior = $mes - 1;
        if ($mesAnterior <= 0) {
            $mesAnterior = 12;
            $añoAnterior = $year - 1;
        } else {
            $añoAnterior = $year;
        }

        $mesSiguiente = $mes + 1;
        if ($mesSiguiente >= 13) {
            $mesSiguiente = 1;
            $añoSiguiente = $year + 1;
        } else {
            $añoSiguiente = $year;
        }
        $diaActual = date("j");

        // Obtenemos el dia de la semana del primer dia
        // Devuelve 0 para domingo, 6 para sabado
        $diaSemana = date("w", mktime(0, 0, 0, $mes, 1, $year)) + 7;
        // Obtenemos el ultimo dia del mes
        $ultimoDiaMes = date("d", (mktime(0, 0, 0, $mes + 1, 1, $year) - 1));

        $meses = array(
            1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        ?>
        <table id="calendar">
            <caption><?php echo $meses[$mes] . " " . $year ?></caption>
            <tr>
                <th>Lun</th>
                <th>Mar</th>
                <th>Mie</th>
                <th>Jue</th>
                <th>Vie</th>
                <th>Sab</th>
                <th>Dom</th>
            </tr>
            <tr bgcolor="silver">
                <?php
                require_once("funciones.php");
                $conexion = conex();
                $last_cell = $diaSemana + $ultimoDiaMes;
                // hacemos un bucle hasta 42, que es el máximo de valores que puede
                // haber... 6 columnas de 7 dias
                for ($i = 1; $i <= 42; $i++) {
                    if ($i == $diaSemana) {
                        // determinamos en que dia empieza
                        $day = 1;
                    }
                    if ($i < $diaSemana || $i >= $last_cell) {
                        // celca vacia
                        echo "<td>&nbsp;</td>";
                    } else {
                        $celdaFecha = $year . "-" . $mes . "-" . $day;
                        $celdaFecha = strtotime($celdaFecha);
                        $celdaFecha = date("Y-m-d", $celdaFecha);
                        session_decode($_COOKIE["sesion"]);
                        $usuario = $_SESSION["usuario"];
                        $usuario = strtolower($usuario);
                        if (strpos($usuario, "admin") !== false) {
                            $sentecia = "select fecha from citas where fecha='$celdaFecha'";
                        } else {
                            $sentecia = "select fecha from citas c, dueño d, cliente cl where fecha='$celdaFecha' and d.nick='$usuario' and c.cliente=cl.id and cl.dni_dueño=d.dni";
                        }
                        // $sentecia = "select fecha from citas where fecha='$celdaFecha'";
                        $datos = $conexion->query($sentecia);
                        if (!$datos) {
                            echo "ERROR! $conexion->error";
                        } else {
                            if ($datos->num_rows > 0) {
                                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                                    echo "<td style='background-color:#ff6a86' title='Consultar cita'><a name='marcador0' href='./citas.php?mes=$mes&año=$year&dia=$day#marcador0' style='color:black;outline:none'>$day</a></td>";
                                    $day++;
                                }
                            } else {
                                echo "<td>$day</td>";
                                $day++;
                            }
                        }



                        // echo $fecha;

                    }
                    // cuando llega al final de la semana, iniciamos una columna nueva
                    if ($i % 7 == 0) {
                        echo "</tr><tr>\n";
                    }
                }
                echo "<div style='display:flex;justify-content:center;font-size:15px'>
            <a name='marcador1' style='outline:none' href=citas.php?mes=$mesAnterior&año=$añoAnterior#marcador1><input type='button' value='◀ ANTERIOR' style='font-size:20px'></a><div style='padding:10px'></div>
            <a name='marcador2' style='outline:none' href=./citas.php?mes=$mesSiguiente&año=$añoSiguiente#marcador2><input type='button' value='SIGUIENTE ▶' style='font-size:20px'></a>
            </div>";
                ?>
            </tr>
        </table>
        <?php
        if (isset($_GET["dia"])) {
            $fecha2 = $_GET["año"] . "-" . $_GET["mes"] . "-" . $_GET["dia"];
            // echo $fecha2;
        } else {
            $fecha2 = "";
        }
        $sentencia = "
        select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
        from citas,cliente,servicio 
        where citas.cliente=cliente.id and citas.servicio=servicio.id and citas.fecha='$fecha2'
        order by fecha asc, hora asc
        ";
        //echo "$sentencia<br>";
        $conexion = conex();
        $resultado = $conexion->query($sentencia);
        if ($resultado->num_rows > 0) {
            while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                // echo "2";
                $hoyy = date("Y-m-d");
                if ($fila["fecha"] < $hoyy) {
                    $nuevaFecha = date('d/m/Y', strtotime($fila['fecha']));
                    echo "
                    <form action='eliminar_cita.php'>
                        <input type=hidden readonly name=cliente id=cliente value=$fila[cliente]>
                        <input type=text readonly value=$fila[nombrecliente] disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=servicio id=servicio value=$fila[servicio]>
                        <input type=text readonly value=$fila[descripcionservicio] disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=fecha id=fecha value=$fila[fecha]> <!Se envía pero no se ve>
                        <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía>
                        <input type=text readonly name=hora id=hora value=$fila[hora]>
                    </form>";
                } else {
                    $nuevaFecha = date('d/m/Y', strtotime($fila['fecha']));
                    echo "
                    <form action='eliminar_cita.php'>
                        <input type=hidden readonly name=cliente id=cliente value=$fila[cliente]>
                        <input type=text readonly value=$fila[nombrecliente] disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=servicio id=servicio value=$fila[servicio]>
                        <input type=text readonly value=$fila[descripcionservicio] disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=fecha id=fecha value=$fila[fecha]> <!Se envía pero no se ve>
                        <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía>
                        <input type=text readonly name=hora id=hora value=$fila[hora]>
                        <input type=submit name=eliminar id=eliminar value='Eliminar cita'>
                    </form>";
                }
            }
        } else {
        }

        session_decode($_COOKIE["sesion"]);
        $usuario = $_SESSION["usuario"];
        $usuario = strtolower($usuario);
        if (strpos($usuario, "admin") !== false) {
            echo '<a href="insertar_cita.php"><input type="button" value="Insertar cita" class="confirmar"></a>
            <a href="buscar_cita.php"><input type="button" value="Buscar cita" class="confirmar"></a>';
        } else {
            echo '<a href="buscar_cita.php"><input type="button" value="Buscar cita" class="confirmar"></a>';
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