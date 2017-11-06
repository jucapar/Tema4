<?php

/*
  Autor: Juan Carlos Pastor Regueras
  Mostrar el contenido de la tabla Departamento y el número de registros.
  Fecha de modificacion: 28-10-2017
 */

//Información de la base de datos. Host y nombre de la BD
include "../../config.php";

try {
    //Creamos la conexion a la base de datos
    $db = new PDO(DATOSCONEXION, USER, PASSWORD);
    //Definición de los atributos para lanzar una excepcion si se produce un error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Creamos una variable para guardar las filas afectadas
    $n = 0;
    //Creamos el array de parametros
    $departamentos = array();

    for ($i = 0; $i < 3; $i++) {
        $departamentos[$i] = array(
            'CodDepartamento' => '',
            'DescDepartamento' => ''
        );
    }

    //Añadimos los datos
    $departamentos[0]['CodDepartamento'] = "200";
    $departamentos[0]['DescDepartamento'] = "Lengua";
    $departamentos[1]['CodDepartamento'] = "201";
    $departamentos[1]['DescDepartamento'] = "Musica";
    $departamentos[2]['CodDepartamento'] = "202";
    $departamentos[2]['DescDepartamento'] = "Educacion fisica";

    //Creamos la consulta
    $consulta = "INSERT INTO Departamento (CodDepartamento,DescDepartamento) VALUES(:CodDepartamento,:DescDepartamento)";
    //Mediante un bucle for vamos ejecutando los insert mediante sentencias preparadas
    for ($i = 0; $i < 3; $i++) {
        //Preparamos la consulta
        $sentencia = $db->prepare($consulta);
        //Inyectamos los parametros del insert en el query
        $sentencia->bindParam(":CodDepartamento", $departamentos[$i]['CodDepartamento']);
        $sentencia->bindParam(":DescDepartamento", $departamentos[$i]['DescDepartamento']);
        //Ejecutamos la consulta
        $sentencia->execute();
        //Vamos acumulando el numero de filas afectadas en $n
        $n += $sentencia->rowCount();
    }

    //Comprobamos el numero de filas afectadas, si coincide con el numero de inserts realizado el proceso ha ido bien
    if ($n == 3) {
        echo "Inserciones realizadas correctamente";
    } else {
        echo "Error al realizar los inserts";
    }
    unset($db);
} catch (PDOException $PdoE) {
    //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
    echo($PdoE->getMessage());
    unset($db);
}
?>