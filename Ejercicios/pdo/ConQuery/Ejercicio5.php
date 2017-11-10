<?php

/*
  Autor: Juan Carlos Pastor Regueras
  Pagina web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno
  Fecha de modificacion: 28-10-2017
 */

//Información de la base de datos. Host y nombre de la BD
include "../../configDesarrollo.php";
try {
    //Creamos la conexion a la base de datos
    $db = new PDO(DATOSCONEXION, USER, PASSWORD);
    //Definición de los atributos para lanzar una excepcion si se produce un error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Creamos una variable para el control del commit
  
        //Declaramos e inicializamos la variable de control
        $correcto = true;
        //Comienzo de la transacción para una serie de operaciones. Se desactiva el modo autocommit( El modo auto-commit significa que toda consulta que se ejecute tiene su propia transacción implícita
        $db->beginTransaction();
        //Consultas y ejecuciones de estas
        $consulta1 = "INSERT INTO Departamento (CodDepartamento,DescDepartamento) VALUES('COM','compras')";
        //Si al ejecutarse el exec nos devuelve una fila afectada, la ejecucion de ese query será correcta y lo almacenaremos en la variable de control
        $correcto = $db->exec($consulta1);
        $consulta2 = "INSERT INTO Departamento (CodDepartamento,DescDepartamento) VALUES('VEN','ventas')";
        $correcto = $db->exec($consulta2);
        //Esta es la consulta que fallará
        $consulta3 = "INSERT INTO Departamento (CodDepartamento,DescDepartamento) VALUES('NUE','nuevo')";
        $correcto =  $db->exec($consulta3);
    

    //Comprobamos la variable de control
    if ($correcto) {//Si no existen errores, se realizan las operaciones y se imprime un mensaje de confirmación
        $db->commit();
        echo "Registros insertados";
    } else {//si alguna de las operaciones ha fallado, se revierten los cambios de las operaciones correctas (si hubiera alguna), y se imprime mensaje de error
        $db->rollBack();
        print "Ha habido algún error.";
    }
} catch (PDOException $PdoE) {
    //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
    echo($PdoE->getMessage());
    unset($db);
}
?>