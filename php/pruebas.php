<?php
require_once("funciones.php");
redireccion();
        $conexion = conex();
        $sentencia = "Select fecha from citas";
        $datos = $conexion->query($sentencia);
        if (!$datos) {
            echo "ERROR! $conexion->error";
        } else {
            if ($datos->num_rows <= 0) {
                
            } else {
                while ($fila = $datos->fetch_array(MYSQLI_ASSOC)) {
                    $fecha = $fila["fecha"];
                    echo $fecha;
                }
            }
        }
