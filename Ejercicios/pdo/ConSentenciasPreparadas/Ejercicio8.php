<?php
/*
  Autor: Juan Carlos Pastor Regueras
  Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml. (COPIA DE SEGURIDAD / EXPORTAR)
  Fecha de modificacion: 28-10-2017
 */
//Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
include "../../configDesarrollo.php";
try {
    //Creamos la conexion a la base de datos
    $db = new PDO(DATOSCONEXION, USER, PASSWORD);
    //Definición de los atributos para lanzar una excepcion si se produce un error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Si no se produce ningun error empezamos la ejecucion
    if (!filter_has_var(INPUT_POST, 'Exportar')) {
        ?>
        <html lang="en" xmlns="http://www.w3.org/1999/html">
            <head>
            </head>
            <body>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <label for="Exportar"></label>
                    <input type="submit" name="Exportar" id="Exportar" value="Exportar">
                </form>
            </body>
        </html>
        <?PHP
    } else {
        $consulta = "SELECT * from Departamento"; //Consulta de todos los registros para generar la tabla
        $sentencia = $db->prepare($consulta); //Se almacena el resultado de la consulta
        $resultado = $sentencia->execute();
        //Cotenido del fichero XML
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Departamentos></Departamentos>'); //creación del XML y su nodo raiz
        header("Content-type: text/xml");
        while ($registro = $sentencia->fetch(PDO::FETCH_OBJ)) {//Mientras haya resultados, se imprimen. FETCH avanza el puntero
            $departamento = $xml->addChild('Departamento'); //nuevo elemento hijo
            $departamento->addChild('CodDepartamento', $registro->CodDepartamento); //nuevo elemento hijo de departamento
            $departamento->addChild('DescDepartamento', $registro->DescDepartamento); //nuevo elemento hijo de departamento
        }
        print($xml->asXML()); //Se imprime el xml creado
    }
    //Cerramos la conexion
    unset($db);
} catch (PDOException $PdoE) {
    //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
    echo($PdoE->getMessage());
    unset($db);
}
?>