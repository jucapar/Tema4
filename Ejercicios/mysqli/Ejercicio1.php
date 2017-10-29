<?php

    /*
        Autor: Juan Carlos Pastor Regueras
        Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
        Fecha de modificacion: 28-10-2017
    */
    
    // Establecemos una nueva conexion
    $db = new mysqli("192.168.1.102","usuarioDBdepartamentos","paso","DAW202DBdepartamentos");
    
    //Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
    if($db->connect_errno){
        echo "Error al conectarse a la base de datos<br/>";
        echo "Codigo de error:" .$db->connect_errno;
    }
    else{
        //Si no ha habido errores lo notificamos al usuario
        echo "Conexion establecida";
    }
    //Cerramos la conexion
    $db->close();


?>