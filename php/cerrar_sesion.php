<?php
require_once("funciones.php");
redireccion();
setcookie('sesion', null, -1, '/');
header("refresh:0;url=../index.php");
