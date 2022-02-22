<body>
        <div class='contenedor-principal-seccion'> 
            <div class='fondo-contenedor-principal'>
                <?php
				require_once("funciones.php");
                    $con=conex();
                    setlocale(LC_ALL,"es-ES.UTF-8");
                    $contador=0;
                    $dia_hoy=date("d");
                    $mes_hoy=date("n");
                    $año_hoy=date("Y");
                    $contadorDias=0;

                    
                    if (isset($_POST['siguiente'])) {
                        $valor= $_POST['valor'];
                        $año_actu=$_POST['año'];
                        // $dias_anio_actual=$_POST['dias_'];
                        // $contador=$dias_anio_actual;
                        $año_hoy=$año_actu;
                        $mes_hoy=$valor;
                        $valor_mes_antes=$valor;
                        $valor_mes_despues=$valor;
                    }elseif(isset($_POST['anterior'])){
                        $valor= $_POST['valor'];
                        $año_actu=$_POST['año'];
                        // $dias_anio_actual=$_POST['dias_'];
                        // $contador=$dias_anio_actual;
                        $mes_hoy=$valor;
                        $valor_mes_antes=$valor;
                        $valor_mes_despues=$valor;
                        $año_hoy=$año_actu;
                    }else {
                        $valor_mes_antes=$mes_hoy;
                        $valor_mes_despues=$mes_hoy;
                        
                    }
                    
                    if ($valor_mes_despues>12) {
                        $año_hoy=$año_hoy+1;
                        $mes_hoy=1;
                        $valor_mes_despues=1;

                    }elseif ($valor_mes_antes<1) {
                        $año_hoy=$año_hoy-1;
                        $mes_hoy=12;
                        $valor_mes_antes=12;
                    }
                    $valor_mes_antes=$mes_hoy-1;
                    $valor_mes_despues=$mes_hoy+1;


                    
                    /*MES Y AÑO DEL CALENDARIO */
                    $primerDia=mktime(0,0,0,$mes_hoy,1,$año_hoy);
                    $forma_mes=strftime("%B",$primerDia);
                    $mayuscula=ucfirst($forma_mes);
                
                    echo"<h2>$mayuscula de $año_hoy</h2>";


                    /*cALENDARIO */
                    
                    $dias_semana=array("Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo");
                    echo"<table border><tr>";
                    for ($i=0; $i < count($dias_semana); $i++) { 
                        echo"<th>$dias_semana[$i]</th>";
                    }
                    echo"</tr><tr>";

                    $primerDia=mktime(0,0,0,$mes_hoy,1,$año_hoy);
                    $primerDiames=date("N",$primerDia);
                    $diasMes=date("t","$primerDia");

                    for($i=1;$i<$primerDiames;$i++){
                        echo"<td> </td>";
                        $contador++;
                    }

                    $citas_hoy="select day(fecha) from citas where month(fecha)=$mes_hoy and year(fecha)=$año_hoy ";
                    $contenido_citas=$con->query($citas_hoy);
                    $a=array();
                    $a[0]=0;
                    while ( $color_cit=$contenido_citas->fetch_array(MYSQLI_ASSOC)) {
                        $a[]=intval($color_cit['day(fecha)']);
                    }

                    for($j=1;$j<=$diasMes;$j++){
                        $contador++;

                        if($contador%6===0 or $contador%7===0){
                            echo"<td class='finde'>$j</td>";
                        }elseif(array_search($j,$a)!=null){
                            echo"<td class='dia_cit'>$j</td>";
                        }else{
                            echo"<td><a href=''>$j</a></td>";
                        }

                        
                        if($contador%7===0){
                            echo"</tr><tr>";
                            $contador=0;
                        }
                    }
                    
                    if($contador%7!=0){
                        while($contador!=7){
                            echo"<td> </td>";
                            $contador++;
                            
                        }
                    }
                

                    $contador=0;

                    echo"</tr></table>";
                    
                    echo "<form action='#' method='post'>
                            <input type='hidden' name='valor' value='$valor_mes_despues'>
                            <input type='hidden' name='año' value='$año_hoy'>
                            <input type='hidden' name='dias_' value='$contadorDias'>
                            <input class='btn btn-primary' type='submit' name='siguiente' value='siguiente'>                             
                        </form>";
                    echo "<form action='#' method='post'>
                            <input type='hidden' name='valor' value='$valor_mes_antes'>
                            <input type='hidden' name='año' value='$año_hoy'>
                            <input type='hidden' name='dias_' value='$contadorDias'>
                            <input class='btn btn-primary' type='submit' name='anterior' value='anterior'>                             
                        </form>";


                    
                    
                        
                ?>
            </div>
        </div>
        <?php

        ?>
    </body>