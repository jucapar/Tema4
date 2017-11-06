<?php

/*
  Autor: Juan Carlos Pastor Regueras
  Mostrar el contenido de la tabla Departamento y el número de registros.
  Fecha de modificacion: 28-10-2017
 */

// Establecemos una nueva conexion
include "../../config.php";
$db = new mysqli(HOST,USER,PASSWORD,DATABASE);

//Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
if ($db->connect_errno) {
    echo "Error al conectarse a la base de datos<br/>";
    echo "Codigo de error:" . $db->connect_errno;
} else {
    //Si no ha habido errores procedemos con las operaciones
    //Creamos la consulta
    $consulta = "SELECT * FROM Departamento";
    //Creamos la sentencia preparada
    $sentencia = $db->prepare($consulta);
    //Ejecutamos la consulta
    $sentencia->execute();
    //Obtenemos los resultados
    $resultado = $sentencia->get_result();

    //Guardamos en numero de registros obtenidos
    $numRegistros = $resultado->num_rows;
    //Mostramos los datos por pantalla
    echo "Numero de registros $numRegistros<br/>";

    //Guardamos los resultados obtenidos como un objeto
    $departamento = $resultado->fetch_object();

    while ($departamento != null) {//Mientras haya filas mostramos por pantalla y avanzamos el fetch
        echo "Codigo Departamento:" . $departamento->CodDepartamento . "<br />";
        echo "Descripcion Departamento:" . $departamento->DescDepartamento . "<br />";
        echo "<br />";
        $departamento = $resultado->fetch_object();
    }
}
//Cerramos la conexion
$db->close();
?>