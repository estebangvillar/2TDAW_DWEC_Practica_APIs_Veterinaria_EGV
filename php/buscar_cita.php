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
        $cliente  = "";
        $servicio  = "";
        $fecha  = "";
        $hora  = "";
        $mes = "";
    } else {
        $cliente  = $_POST["cliente"];
        $servicio  = $_POST["servicio"];
        $fecha  = $_POST["fecha"];
        $hora  = $_POST["hora"];
        $mes = $_POST["mes"];
    }

    $conexion = conex();
    session_decode($_COOKIE["sesion"]);
    $usuario = $_SESSION["usuario"];
    $usuario = strtolower($usuario);
    if (strpos($usuario, "admin") !== false) {
        echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR CLIENTE🔽</h2>
            </div>
            <form name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='cliente'>Cliente: </label>
                <select name='cliente'>";
        $sentencia = "Select id, nombre from cliente";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay clientes para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "<option value='$fila[id]'>$fila[nombre] - $fila[id]</option>";
                }
            }
        }
        echo "
                </select>
                <input type='submit' name='buscar_por_cliente' id='buscar' value='Buscar citas' class='confirmar'>
            </form>
        </div>
        <div class='formulario'>
        <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR SERVICIO🔽</h2>
            </div>
            <form  name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='servicio'>Servicio: </label>
                <select name='servicio'>";
        $sentencia = "Select id, descripcion from servicio";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay servicios para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "<option value='$fila[id]'>$fila[descripcion] - $fila[id]</option>";
                }
            }
        }
        echo "
                </select>
                <input type='submit' name='buscar_por_servicio' id='buscar' value='Buscar citas' class='confirmar'>
                </form>
        </div>
        <div class='formulario'>
        <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR FECHA🔽</h2>
            </div>
            <form  name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='fecha'>Fecha: </label>
                <input type='date' name='fecha' id='fecha' value='$fecha'>
                <br>
                <label for='buscar'></label>
                <input type='submit' name='buscar_por_fecha' id='buscar' value='Buscar citas' class='confirmar'>
                <a href='citas.php'><input type='button' value='Ver calendario' class='confirmar'></a>
                <br>
            </form>
        </div>
        <div class='formulario'>
        <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR MES🔽</h2>
            </div>
            <form  name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='fecha'>Mes: </label>
                <select name='mes' id='mes' value='$mes'>
                    <option value='01'>ENERO</option>
                    <option value='02'>FEBRERO</option>
                    <option value='03'>MARZO</option>
                    <option value='04'>ABRIL</option>
                    <option value='05'>MAYO</option>
                    <option value='06'>JUNIO</option>
                    <option value='07'>JULIO</option>
                    <option value='08'>AGOSTO</option>
                    <option value='09'>SEPTIEMBRE</option>
                    <option value='10'>OCTUBRE</option>
                    <option value='11'>NOVIEMBRE</option>
                    <option value='12'>DICIEMBRE</option>
                </select>
                <br>
                <label for='buscar'></label>
                <input type='submit' name='buscar_por_mes' id='buscar' value='Buscar citas' class='confirmar'>
                <a href='citas.php'><input type='button' value='Ver calendario' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

        if (isset($_POST["buscar_por_cliente"])) {
            // ECHO "1";
            $sentencia = "
        select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
        from citas,cliente,servicio 
        where cliente=$_POST[cliente] and citas.cliente=cliente.id and citas.servicio=servicio.id 
        order by fecha asc, hora asc
        ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas el cliente $_POST[cliente] son:</b><br>";
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
                echo "<p class='mensaje_error'>EL CLIENTE $_POST[cliente] NO TIENE CITAS, VUELVA A INTENTARLO</p><br><br>";
            }
        }

        //A continuación se procesan los resultados según el tipo de búsqueda de citas:

        if (isset($_POST["buscar_por_servicio"])) {
            // ECHO "1";
            $sentencia = "
        select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
        from citas,cliente,servicio 
        where servicio=$_POST[servicio] and citas.cliente=cliente.id and citas.servicio=servicio.id 
        order by fecha asc, hora asc
        ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas para el servicio $_POST[servicio] son:</b><br>";
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
                        <input type=text readonly value='$fila[descripcionservicio]' disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=fecha id=fecha value=$fila[fecha]> <!Se envía pero no se ve>
                        <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía>
                        <input type=text readonly name=hora id=hora value=$fila[hora] disabled>
                    </form>";
                    } else {
                        $nuevaFecha = date('d/m/Y', strtotime($fila['fecha']));
                        echo "
                <form action='eliminar_cita.php'>
                    <input type=hidden readonly name=cliente id=cliente value=$fila[cliente]>
                    <input type=text readonly value=$fila[nombrecliente] disabled> <!Sin name, no se envía>
                    <input type=hidden readonly name=servicio id=servicio value=$fila[servicio]>
                    <input type=text readonly value='$fila[descripcionservicio]' disabled> <!Sin name, no se envía>
                    <input type=hidden readonly name=fecha id=fecha value=$fila[fecha]> <!Se envía pero no se ve>
                    <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía>
                    <input type=text readonly name=hora id=hora value=$fila[hora] disabled>
                    <input type=submit name=eliminar id=eliminar value='Eliminar cita'>
                </form>";
                    }
                }
            } else {
                echo "<p class='mensaje_error'>NO HAY CITAS DEL SERVICIO $_POST[servicio], VUELVA A INTENTARLO</p><br><br>";
            }
        }

        if (isset($_POST["buscar_por_fecha"])) {
            // ECHO "1";
            $nuevaFecha = date('d/m/Y', strtotime($_POST['fecha'])); //Para mostrarla en formato "español"
            //Todas las fechas que se muestren en formato español en el bucle siguiente tendrán el valor de la línea anterior
            $sentencia = "
        select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
        from citas,cliente,servicio 
        where fecha='$_POST[fecha]' and citas.cliente=cliente.id and citas.servicio=servicio.id 
        order by fecha asc, hora asc
        ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas la fecha $nuevaFecha son:</b><br>";
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
                        <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía. TOMA EL VALOR ASIGNADO ANTES DEL BUCLE, YA QUE ES SIEMPRE EL MISMO EN ESTOS RESULTADOS>
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
                    <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía. TOMA EL VALOR ASIGNADO ANTES DEL BUCLE, YA QUE ES SIEMPRE EL MISMO EN ESTOS RESULTADOS>
                    <input type=text readonly name=hora id=hora value=$fila[hora]>
                    <input type=submit name=eliminar id=eliminar value='Eliminar cita'>
                </form>";
                    }
                }
            } else {
                echo "<p class='mensaje_error'>NO HAY CITAS PARA LA FECHA $nuevaFecha, VUELVA A INTENTARLO</p><br><br>";
            }
        }

        if (isset($_POST["buscar_por_mes"])) {
            // ECHO "1";
            $sentencia = "
        select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
        from citas,cliente,servicio 
        where month(fecha)=$_POST[mes] and citas.cliente=cliente.id and citas.servicio=servicio.id 
        order by fecha asc, hora asc
        ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas el mes $_POST[mes] son:</b><br>";
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
                echo "<p class='mensaje_error'>NO HAY CITAS PARA EL MES $_POST[mes], VUELVA A INTENTARLO</p><br><br>";
            }
        }
    } else {
        echo "
        <div class='formulario'>
            <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR CLIENTE🔽</h2>
            </div>
            <form name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='cliente'>Cliente: </label>
                <select name='cliente'>";
        $sentencia = "Select cliente.id, cliente.nombre from cliente, dueño where cliente.dni_dueño=dueño.dni and dueño.nick='$usuario'";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay clientes para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "<option value='$fila[id]'>$fila[nombre] - $fila[id]</option>";
                }
            }
        }
        echo "
                </select>
                <input type='submit' name='buscar_por_cliente' id='buscar' value='Buscar citas' class='confirmar'>
            </form>
        </div>
        <div class='formulario'>
        <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR SERVICIO🔽</h2>
            </div>
            <form  name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='servicio'>Servicio: </label>
                <select name='servicio'>";
        $sentencia = "Select id, descripcion from servicio";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                echo "No hay servicios para mostrar";
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    echo "<option value='$fila[id]'>$fila[descripcion] - $fila[id]</option>";
                }
            }
        }
        echo "
                </select>
                <input type='submit' name='buscar_por_servicio' id='buscar' value='Buscar citas' class='confirmar'>
                </form>
        </div>
        <div class='formulario'>
        <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR FECHA🔽</h2>
            </div>
            <form  name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='fecha'>Fecha: </label>
                <input type='date' name='fecha' id='fecha' value='$fecha'>
                <br>
                <label for='buscar'></label>
                <input type='submit' name='buscar_por_fecha' id='buscar' value='Buscar citas' class='confirmar'>
                <br>
            </form>
        </div>
        <div class='formulario'>
        <div class='titulo_form'>
                <h2>🔽BUSCAR CITAS POR MES🔽</h2>
            </div>
            <form  name='formulario' action='buscar_cita.php' enctype='multipart/form-data' method='POST'>
                <label for='fecha'>Mes: </label>
                <select name='mes' id='mes' value='$mes'>
                    <option value='01'>ENERO</option>
                    <option value='02'>FEBRERO</option>
                    <option value='03'>MARZO</option>
                    <option value='04'>ABRIL</option>
                    <option value='05'>MAYO</option>
                    <option value='06'>JUNIO</option>
                    <option value='07'>JULIO</option>
                    <option value='08'>AGOSTO</option>
                    <option value='09'>SEPTIEMBRE</option>
                    <option value='10'>OCTUBRE</option>
                    <option value='11'>NOVIEMBRE</option>
                    <option value='12'>DICIEMBRE</option>
                </select>
                <br>
                <label for='buscar'></label>
                <input type='submit' name='buscar_por_mes' id='buscar' value='Buscar citas' class='confirmar'>
                <a href='citas.php'><input type='button' value='Ver calendario' class='confirmar'></a>
                <br>
            </form>
        </div>
    ";

        if (isset($_POST["buscar_por_cliente"])) {
            // ECHO "1";
            $sentencia = "
        select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
        from citas,cliente,servicio 
        where cliente=$_POST[cliente] and citas.cliente=cliente.id and citas.servicio=servicio.id 
        order by fecha asc, hora asc
        ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas el cliente $_POST[cliente] son:</b><br>";
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
                echo "<p class='mensaje_error'>EL CLIENTE $_POST[cliente] NO TIENE CITAS, VUELVA A INTENTARLO</p><br><br>";
            }
        }
        if (isset($_POST["buscar_por_servicio"])) {
            // ECHO "1";
            $sentencia = "
            select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
            from citas,cliente,servicio,dueño
            where servicio=$_POST[servicio] and citas.cliente=cliente.id and citas.servicio=servicio.id and citas.cliente=cliente.id and cliente.dni_dueño=dueño.dni and dueño.nick='$usuario'
            order by fecha asc, hora asc
            ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas para el servicio $_POST[servicio] son:</b><br>";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    // echo "2";
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
                }
            } else {
                echo "<p class='mensaje_error'>NO HAY CITAS DEL SERVICIO $_POST[servicio], VUELVA A INTENTARLO</p><br><br>";
            }
        }

        if (isset($_POST["buscar_por_fecha"])) {
            // ECHO "1";
            $nuevaFecha = date('d/m/Y', strtotime($_POST['fecha'])); //Para mostrarla en formato "español"
            //Todas las fechas que se muestren en formato español en el bucle siguiente tendrán el valor de la línea anterior
            $sentencia = "
            select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
            from citas,cliente,servicio,dueño
            where fecha='$_POST[fecha]' and citas.cliente=cliente.id and citas.servicio=servicio.id and citas.cliente=cliente.id and cliente.dni_dueño=dueño.dni and dueño.nick='$usuario'
            order by fecha asc, hora asc
            ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas la fecha $nuevaFecha son:</b><br>";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    // echo "2";
                    //$nuevaFecha = date('d/m/Y', strtotime($fila['fecha']));
                    echo "
                    <form action='eliminar_cita.php'>
                        <input type=hidden readonly name=cliente id=cliente value=$fila[cliente]>
                        <input type=text readonly value=$fila[nombrecliente] disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=servicio id=servicio value=$fila[servicio]>
                        <input type=text readonly value=$fila[descripcionservicio] disabled> <!Sin name, no se envía>
                        <input type=hidden readonly name=fecha id=fecha value=$fila[fecha]> <!Se envía pero no se ve>
                        <input type=text readonly value=$nuevaFecha disabled> <!Sin name, no se envía. TOMA EL VALOR ASIGNADO ANTES DEL BUCLE, YA QUE ES SIEMPRE EL MISMO EN ESTOS RESULTADOS>
                        <input type=text readonly name=hora id=hora value=$fila[hora]>
                    </form>";
                }
            } else {
                echo "<p class='mensaje_error'>NO HAY CITAS PARA LA FECHA $nuevaFecha, VUELVA A INTENTARLO</p><br><br>";
            }
        }

        if (isset($_POST["buscar_por_mes"])) {
            // ECHO "1";
            $sentencia = "
            select citas.cliente,cliente.nombre AS nombrecliente,citas.servicio,servicio.descripcion AS descripcionservicio,citas.fecha,citas.hora 
            from citas,cliente,servicio,dueño
            where month(fecha)=$_POST[mes] and citas.cliente=cliente.id and citas.servicio=servicio.id and citas.cliente=cliente.id and cliente.dni_dueño=dueño.dni and dueño.nick='$usuario'
            order by fecha asc, hora asc
            ";
            //echo "$sentencia<br>";
            $conexion = conex();
            $resultado = $conexion->query($sentencia);
            if ($resultado->num_rows > 0) {
                echo "<b>Las citas programadas el mes $_POST[mes] son:</b><br>";
                while ($fila = $resultado->fetch_array(MYSQLI_ASSOC)) {
                    // echo "2";
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
                }
            } else {
                echo "<p class='mensaje_error'>NO HAY CITAS PARA EL MES $_POST[mes], VUELVA A INTENTARLO</p><br><br>";
            }
        }
    }


    ?>
</body>

</html>