<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../css/calendar.css">
    <title>Citas</title>
    <meta charset="utf-8">
</head>

<body>
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
                    $sentecia = "select fecha from citas where fecha='$celdaFecha'";
                    $datos = $conexion->query($sentecia);
                    if (!$datos) {
                        echo "ERROR! $conexion->error";
                    } else {
                        if ($datos->num_rows > 0) {
                            while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                                echo "<td style='background-color:red' title='Consultar cita'>$day</td>";
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

            echo "<a href=./calendario.php?mes=$mesAnterior&año=$añoAnterior><input type='button' value='◀ANTERIOR'></a>";
            echo "<a href=./calendario.php?mes=$mesSiguiente&año=$añoSiguiente><input type='button' value='SIGUIENTE▶'></a>";
            ?>
        </tr>
    </table>
</body>

</html>