<?php

/*
  Autor: Juan Carlos Pastor Regueras
  Conexión a la base de datos con la cuenta usuario y tratamiento de errores.
  Fecha de modificacion: 6-11-2017
 */

//Información de la base de datos. Host y nombre de la BD
include "../../config.php";

try {
    //Creamos la conexion a la base de datos
    $db = new PDO(DATOSCONEXION, USER, PASSWORD);
    //Definición de los atributos para lanzar una excepcion si se produce un error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Si no se produce ningun error mostramos el mensaje de confirmacion
    echo ("Conexion establecida<br />");
    echo "Version del cliente: ", $db->getAttribute(PDO::ATTR_CLIENT_VERSION), "<br>";
    echo "Version del servidor: ", $db->getAttribute(PDO::ATTR_SERVER_VERSION), "<br>";
    echo "Información del servidor: ", $db->getAttribute(PDO::ATTR_SERVER_INFO);
} catch (PDOException $PdoE) {
    //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
    echo($PdoE->getMessage());
    unset($db);
}
?>