<?php

    /*
        Autor: Juan Carlos Pastor Regueras
        Mostrar el contenido de la tabla Departamento y el número de registros.
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
        //Creamos la consulta
        $consulta = "SELECT * FROM Departamento";
        //Preparamos la consulta
        $sentencia = $db->prepare($consulta);
        //La ejecutamos
        $sentencia->execute();
        //Establecemos la obtencion de los resultados como un array asociativo
        $sentencia->setFetchMode(PDO::FETCH_ASSOC);
        //Guardamos el numero de registros obtenidos
        $numRegistros = $sentencia->rowCount();
        //Guardamos todos los resultados obtenidos
        $departamentos = $sentencia->fetchAll();
    
        //Mostramos los datos por pantalla
         echo "Numero de registros $numRegistros<br/>";
        for($i = 0; $i < count($departamentos);$i++){
        foreach($departamentos[$i] as $indice =>$valor){
            echo ("$indice:$valor<br/>");
            }
               echo("<br />");
        }
        //Cerramos la conexion
        unset($db);
       
    }
    catch(PDOException $PDOE){
        //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
        echo($PDOE->getMessage());
        unset($db);
        
    }
    
?>