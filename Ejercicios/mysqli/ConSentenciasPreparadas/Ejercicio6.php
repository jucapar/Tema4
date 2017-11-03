<?php

    /*
        Autor: Juan Carlos Pastor Regueras
        Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno
        Fecha de modificacion: 28-10-2017
    */
    
    // Establecemos una nueva conexion
    include "../config.php";
    $db = new mysqli($host,$user,$password,$database);
    
    //Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
    if($db->connect_errno){
        echo "Error al conectarse a la base de datos<br/>";
        echo "Codigo de error:" .$db->connect_errno;
    }
    else{
       
	   //Creamos una variable donde guardaremos las filas afectadas al crear las consultas, nos servirá como contro de errores
	   $n=0;
	   //Creamos el array de parametros
	   $departamentos = array();
	   
	   for($i = 0;$i< 3;$i++){
		   $departamentos[$i] = array(
			'CodDepartamento' => '',
			'DescDepartamento' => ''
			);
	   }
	
	   //Añadimos los datos
	   $departamentos[0]['CodDepartamento'] = "10";
	   $departamentos[0]['DescDepartamento'] = "Lengua";
	   $departamentos[1]['CodDepartamento'] = "11";
	   $departamentos[1]['DescDepartamento'] = "Musica";
	   $departamentos[2]['CodDepartamento'] = "12";
	   $departamentos[2]['DescDepartamento'] = "Educacion fisica";
	   
		//Creamos la consulta
		$consulta="INSERT INTO Departamento (CodDepartamento,DescDepartamento) VALUES(?,?)";
		//Mediante un bucle for vamos ejecutando los insert mediante sentencias preparadas
		for($i = 0; $i < 3;$i++){
			 //Preparamos la consulta
			$sentencia=$db->prepare($consulta);
			//Inyectamos los parametros del insert en el query
			$sentencia->bind_param("ss",$departamentos[$i]['CodDepartamento'],$departamentos[$i]['DescDepartamento']);
			//Ejecutamos la consulta
			$sentencia-> execute();	
			//Vamos acumulando el numero de filas afectadas en $n
			$n += $sentencia->affected_rows;
			echo $n."</br>";
		}
		
		//Comprobamos el numero de filas afectadas, si coincide con el numero de inserts realizado el proceso ha ido bien
		if($n==3){
			echo "Inserciones realizadas correctamente";
		}
		else{
			echo "Error al realizar los inserts";
		}
       
	   //Cerramos la sentencia
	   $sentencia->close();
    }
    //Cerramos la conexion
    $db->close();


?>