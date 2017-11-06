<?php
/*
  Autor: Juan Carlos Pastor Regueras
  Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.
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
        $sentencia = $db->prepare($consulta); //Se prepara la consulta
        $resultado = $sentencia->execute(); //Se ejecuta la consulta
		$registro = $resultado->fetch_object();
        //Cotenido del fichero XML
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Departamentos></Departamentos>'); //creación del XML y su nodo raiz
        header("Content-type: text/xml");
          while ($registro != null) {//Mientras haya resultados, se imprimen. FETCH avanza el puntero
            $departamento = $xml->addChild('Departamento'); //nuevo elemento hijo
            $departamento->addChild('CodDepartamento', $registro->CodDepartamento); //nuevo elemento hijo de departamento
            $departamento->addChild('DescDepartamento', $registro->DescDepartamento); //nuevo elemento hijo de departamento
            $registro = $resultado->fetch_object(); //Avanza el puntero al siguiente registro
        }
        print($xml->asXML()); //Se imprime el xml creado
    }
    //Cerramos la conexion
    $db->close();
}
?>
			

