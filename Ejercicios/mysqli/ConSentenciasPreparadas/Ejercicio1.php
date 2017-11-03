<?php

    /*
        Autor: Juan Carlos Pastor Regueras
        Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
        Fecha de modificacion: 28-10-2017
    */
    
    // Establecemos una nueva conexion
    include "../config.php";
    $db = new mysqli($host,$user,$password,$database);
    
    //Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
    if($db->connect_errno){
        echo "Error al conectarse a la base de datos<br/>";
        echo "Codigo de error:" .$db->connect_errno;
		echo "<br />Descripcion del error:" . $db->connect_error;
    }
    else{
        //Si no ha habido errores lo notificamos al usuario
        echo "Conexion establecida";
		echo $db->host_info,"<br/>";
        echo $db->server_info,"<br/>"; 
        echo "Version servidor ",$db->server_version,"<br/>";
        echo "Version cliente ",$db->client_version,"<br/>"; 
		$db->close();
    }
    //Cerramos la conexion
?>