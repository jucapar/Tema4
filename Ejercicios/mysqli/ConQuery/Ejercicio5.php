<?php

/*
  Autor: Juan Carlos Pastor Regueras
  Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno
  Fecha de modificacion: 28-10-2017
 */

// Establecemos una nueva conexion
include "../config.php";
$db = new mysqli($host, $user, $password, $database);

//Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
if ($db->connect_errno) {
    echo "Error al conectarse a la base de datos<br/>";
    echo "Codigo de error:" . $db->connect_errno;
} else {
    //Creamos una variable para el control del commit
    $correcto = true;

    //Consultas de inserción de datos con diferentes valores
    $consulta1 = "insert into Departamento values('EJ1','ejemplo1')";
    $consulta2 = "insert into Departamento values('EJ2','ejemplo2')";
    //Esta es la que fallará
    $consulta3 = "insert into Depatamento values('EJE3','eje3')";

    //Si alguna de las consultas no se ejecuta, no todas las oepraciones son correctas
    if (!$db->query($consulta1)) {
        $correcto = false;
    }
    if (!$db->query($consulta2)) {
        $correcto = false;
    }
    if (!$db->query($consulta3)) {
        $correcto = false;
    }

    //Si todas las operaciones han salido bien, $correcto valdrá true y ejecutaremos el commit
    if ($correcto) {
        $db->commit();
        echo "Cambios realizados";
    } else {
        //Si ha habido algun error desharemos los cambios
        $db->rollback();
        echo "Cambios no realizados";
    }
}
//Cerramos la conexion
$db->close();
?>