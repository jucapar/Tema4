<?php

    /*
        Autor: Juan Carlos Pastor Regueras
        Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
        Fecha de modificacion: 28-10-2017
    */

    //Información de la base de datos. Host y nombre de la BD
    $datosConexion="mysql:host=192.168.1.102;dbname=DAW202DBdepartamentos";
    try{
        //Creamos la conexion a la base de datos
        $db = new PDO($datosConexion,"usuarioDBdepartamentos","paso");
        //Definición de los atributos para lanzar una excepcion si se produce un error
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        //Si no se produce ningun error mostramos el mensaje de confirmacion
        echo ("Conexion establecida");
    }
    catch(PDOException $PDOE){
        //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
        echo($PDOE->getMessage());
        unset($db);
        
    }
    
?>