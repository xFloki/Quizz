<?php

function conectaBBDD(){
    require('configuracion.php');
    $conexion_mysql = new mysqli($servidor, $usuario_mysql, $clave_mysql, $bd);
    $conexion_mysql -> query("SET NAMES UTF8");
    return $conexion_mysql;
}

    
?>