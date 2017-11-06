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
    //Creamos la consulta
    $consulta = "SELECT * FROM Departamento";
    //Ejecutamos la consulta
    $resultado = $db->query($consulta);
    //Guardamos el numero de registros obtenidos
    $numRegistros = $resultado->rowCount();

	echo "Numero de registros: $numRegistros <br/>";
    while ($departamento = $resultado->fetch(PDO::FETCH_OBJ)) {//Mientras haya resultados, se muestran formateados. FETCH avanza el puntero
        echo "Codigo Departamento:" . $departamento->CodDepartamento . "<br />";
        echo "Descripcion Departamento:" . $departamento->DescDepartamento . "<br />";
        echo "<br />";
    }

    //Cerramos la conexion
    unset($db);
} catch (PDOException $PdoE) {
    //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
    echo($PdoE->getMessage());
    unset($db);

}
?>
