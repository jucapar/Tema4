<?php

    /*
        Autor: Juan Carlos Pastor Regueras
        Mostrar el contenido de la tabla Departamento y el número de registros.
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
        //Si no ha habido errores procedemos con las operaciones
        
        //Creamos la consulta
        $consulta = "SELECT * FROM Departamento";
        //Creamos la sentencia preparada
        $sentencia=$db->prepare($consulta);
        //Ejecutamos la consulta
        $sentencia->execute();
        //Obtenemos los resultados
        $resultado=$sentencia->get_result();
        //Guardamos los resultados obtenidos como un array asociativo
        $departamentos=$resultado->fetch_all(MYSQLI_ASSOC);
        //Guardamos en numero de registros obtenidos
        $numRegistros = $resultado->num_rows;
        //Mostramos los datos por pantalla
        echo "Numero de registros $numRegistros<br/>";
        
        for($i = 0; $i < count($departamentos);$i++){
            foreach($departamentos[$i] as $indice =>$valor){
                echo ("$indice:$valor<br/>");
                }
                echo("<br />");
        }
        
    }
    //Cerramos la conexion
    $db->close();


?>