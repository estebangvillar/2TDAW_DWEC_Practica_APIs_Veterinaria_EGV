<?php
if (session_id() != "") {
} else {
    session_start();
}


function contructor_menu()
{
    if (basename($_SERVER['PHP_SELF']) == 'index.php') {
        if (!isset($_COOKIE["sesion"])) {
            echo "  <nav id='menu'>
                            <ul>
                                <li><a href='index.php'>Inicio</a></li>
                                <li><a href='php/productos.php'>Productos</a></li>
                                <li><a href='php/servicios.php'>Servicios</a></li>
                                <li class='cerrarsesion'><a href='php/acceder.php'>Acceder</a></li>
                            </ul>
                        </nav>
                        ";
        } else {
            session_decode($_COOKIE["sesion"]);
            $usuario = $_SESSION["usuario"];
            $usuario = strtolower($usuario);
            if (strpos($usuario, "admin") !== false) {
                echo "  <nav id='menu'>
                    <ul>
                        <li><a href='index.php'>Inicio</a></li>
                        <li><a href='php/clientes.php'>Clientes</a></li>
                        <li><a href='php/productos.php'>Productos</a></li>
                        <li><a href='php/servicios.php'>Servicios</a></li>
                        <li><a href='php/testimonios.php'>Testimonios</a></li>
                        <li><a href='php/noticias.php?x=0'>Noticias</a></li>
                        <li><a href='php/citas.php'>Citas</a></li>
                        <li><a href='php/duenos.php'>Dueños</a></li>
                        <li class='cerrarsesion'><a href='php/cerrar_sesion.php'>Cerrar sesión</a></li>
                    </ul>
                </nav>";
            } else {
                echo "  <nav id='menu'>
                    <ul>
                        <li><a href='index.php'>Inicio</a></li>
                        <li><a href='php/mis_mascotas.php'>Mis mascotas</a></li>
                        <li><a href='php/mis_datos.php'>Mis datos personales</a></li>
                        <li><a href='php/citas.php'>Mis citas</a></li>
                        <li><a href='php/productos.php'>Productos</a></li>
                        <li><a href='php/servicios.php?x=0'>Servicios</a></li>
                        <li class='cerrarsesion'><a href='php/cerrar_sesion.php'>Cerrar sesión</a></li>
                    </ul>
                </nav>";
            }
        }
    } else {
        if (!isset($_COOKIE["sesion"])) {
            echo "  <nav id='menu'>
                            <ul>
                                <li><a href='../index.php'>Inicio</a></li>
                                <li><a href='productos.php'>Productos</a></li>
                                <li><a href='servicios.php'>Servicios</a></li>
                                <li class='cerrarsesion'><a href='acceder.php'>Acceder</a></li>
                            </ul>
                        </nav>";
        } else {
            session_decode($_COOKIE["sesion"]);
            $usuario = $_SESSION["usuario"];
            $usuario = strtolower($usuario);
            if (strpos($usuario, "admin") !== false) {
                echo "  <nav id='menu'>
                    <ul>
                        <li><a href='../index.php'>Inicio</a></li>
                        <li><a href='clientes.php'>Clientes</a></li>
                        <li><a href='productos.php'>Productos</a></li>
                        <li><a href='servicios.php'>Servicios</a></li>
                        <li><a href='testimonios.php'>Testimonios</a></li>
                        <li><a href='noticias.php?x=0'>Noticias</a></li>
                        <li><a href='citas.php'>Citas</a></li>
                        <li><a href='duenos.php'>Dueños</a></li>
                        <li class='cerrarsesion'><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
                    </ul>
                </nav>";
            } else {
                echo "  <nav id='menu'>
                    <ul>
                        <li><a href='../index.php'>Inicio</a></li>
                        <li><a href='mis_mascotas.php'>Mis mascotas</a></li>
                        <li><a href='mis_datos.php'>Mis datos personales</a></li>
                        <li><a href='citas.php'>Mis citas</a></li>
                        <li><a href='productos.php'>Productos</a></li>
                        <li><a href='servicios.php?x=0'>Servicios</a></li>
                        <li class='cerrarsesion'><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
                    </ul>
                </nav>";
            }
        }
    }
}

function constructor_footer()
{
    echo '<div class="contenedor-footer">
            <div class="contenido-footer">
                <h3 class="website-logo">Veterinaria Coral</h3>
                <span class="footer-info">958 73 87 50</span>
                <span class="footer-info">clínicaveterinariacoral@contacto.es</span>
            </div>
            <div class="menu-footer">
                <div class="contenido-footer">
                    <span class="titulo-menu">Menú</span>
                    <a href="" class="elemento-footer">Servicios</a>
                    <a href="" class="elemento-footer">Blog</a>
                    <a href="" class="elemento-footer">Contacto</a>
                </div>
                <div class="contenido-footer">
                    <span class="titulo-menu">Legal</span>
                    <a href="" class="elemento-footer">Política de privacidad</a>
                    <a href="" class="elemento-footer">Cookies</a>
                    <a href="" class="elemento-footer">Aviso legal</a>
                </div>
            </div>
            
            <div class="contenido-footer">
                <span class="titulo-menu">Síguenos</span>
                <div class="contenedor-rss">
                    <a href="https://www.facebook.com" class="link-rss"></a>
                    <a href="https://www.twitter.com" class="link-rss"></a>
                    <a href="https://www.linkedin.com" class="link-rss"></a>
                </div>
            </div>
        </div>';
}

function conex()
{
    $conexion = new mysqli("localhost", "root", "", "veterinaria");
    $conexion->set_charset("utf8");
    return $conexion;
}

function redireccion()
{
    $comprobar = basename($_SERVER['PHP_SELF']);
    if (!isset($_COOKIE["sesion"])) {
        if(strpos($comprobar, "buscar") !== false){

        }else{
            header("refresh:0;url='acceder.php'");
        }
        
    } else {
        session_decode($_COOKIE["sesion"]);
        $usuario = $_SESSION["usuario"];
        $usuario = strtolower($usuario);
        if (strpos($usuario, "admin") !== false) {
        } else {
            if (basename($_SERVER['PHP_SELF']) == 'testimonios.php') {
                header("refresh:0;url='../index.php'");
            }
            if (basename($_SERVER['PHP_SELF']) == 'noticias.php') {
                header("refresh:0;url='../index.php'");
            }
            if (basename($_SERVER['PHP_SELF']) == 'duenos.php') {
                header("refresh:0;url='../index.php'");
            }
            if(strpos($comprobar, "insertar") !== false){
                header("refresh:0;url='../index.php'");
            }
            if(strpos($comprobar, "modificar") !== false){
                header("refresh:0;url='../index.php'");
            }
            if(strpos($comprobar, "eliminar") !== false){
                header("refresh:0;url='../index.php'");
            }
        }
    }
}
