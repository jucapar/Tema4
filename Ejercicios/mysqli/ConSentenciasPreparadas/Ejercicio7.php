<?php
/*
  Autor: Juan Carlos Pastor Regueras
  Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla
  Departamento de nuestra base de datos. (IMPORTAR
  Fecha de modificacion: 3-11-2017
 */

include "../../config.php";
$db = new mysqli(HOST, USER, PASSWORD, DATABASE);

//Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
if ($db->connect_errno) {
    echo "Error al conectarse a la base de datos<br/>";
    echo "Codigo de error:" . $db->connect_errno;
} else {

    $error = false;
    if (filter_has_var(INPUT_POST, 'Importar')) {//Si hemos pulsado el boton de Enviar
        $xml_file = $_FILES['fichero']['tmp_name']; //Archivo xml a cargar

        if (file_exists($xml_file)) { //Si existe, se carga
            $xml = simplexml_load_file($xml_file);
        } else {//si no existe, error
            $error = true;
            $db->close();
        }
    }
    //Si no hemos pulsado el boton, o ha habido un error en la validacion mostrarmos el formulario
    if (!filter_has_var(INPUT_POST, 'Importar') || $error) {
        ?>
        <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data">
            <label for="fichero">Seleccione un fichero XML:</label><br />
            <input type="file" id="fichero" name="fichero" >
            <br /><br />
            <input type="submit" name="Importar" value="Importar">
        </form>
        <?PHP
    } else {
        //Variable para contar el numero de registros que se han ejecutado correctamente
        $cuenta = 0;
        $consulta = "INSERT INTO Departamento (CodDepartamento,DescDepartamento) VALUES (?,?)";
        //Preparamos la consulta
        $sentencia = $db->prepare($consulta);
        //Recorremos nuestro fichero XML 
        foreach ($xml->Departamento as $departamento) {
            //Inyectamos los parametros del insert en el query
            $sentencia->bind_param("ss", $departamento->CodDepartamento, $departamento->DescDepartamento);
            //Si la ejecucion es correcta incrementamos el numero de registros correctos
            if ($sentencia->execute()) {
                $cuenta++;
            }
        }
        echo ($cuenta . " registros insertados con exito");
        //Cerramos la sentencia
        $sentencia->close();
        //Cerramos la conexion
    }
    $db->close();
}
?>