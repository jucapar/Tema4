<?php
/*
  Autor: Juan Carlos Pastor Regueras
  Formulario de búsqueda de departamentos por descripción (por una parte del campo
  DescDepartamento)
  Fecha de modificacion: 29-10-2017
 */

include "../../config.php";
try {
    //Creamos la conexion a la base de datos
    $db = new PDO(DATOSCONEXION, USER, PASSWORD);
    //Definición de los atributos para lanzar una excepcion si se produce un error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//Incluimos nuestra libreria de validacion
include "../../LibreriaValidacionFormularios.php";

// Constantes para los valores maximos y minimos
define("MIN", 1);
define("MAX", 100);

// Array de errores, utilizado para mostrar el mensaje de error correspondiente al valor devuelto por la funcion de validacion
$arrayErrores = array(" ", "No ha introducido ningun valor<br />", "El valor introducido no es valido<br />", "Tamaño minimo no valido<br />", "Tamaño maximo no valido<br />");

//Variable de control, utilizada para saber si algun campo introducido es erroneo
$error = false;

// Variable que guardará el valor devuelto por las funciones de validacion
$valida = 0;


// Inicializamos las variables de Departamento y las variables de errores
$DescDepartamento = "";
$errorDepartamento = "";
$estilosDepartamento = "";


if (filter_has_var(INPUT_POST, 'enviar')) {//Si hemos pulsado el boton de Enviar
    //Ejecutamos la funcion de validacion y recogemos el valor devuelto
    $valida = validarCadenaAlfanumerica($_POST['DescDepartamento'], MIN, MAX);
    //Si el valor es distinto de 0 ha habido un error y procedemos a tratarlo
    if ($valida != 0) {
        //Asignamos el error producido al valor correspondiente en el array de errores
        $errorDepartamento = $arrayErrores[$valida];
        //Activamos el class correspondiente para marcar el borde del campo en rojo
        $estilosDepartamento = "error";
        //Como ha habido un error, la variable de control $error toma el valor true
        $error = true;
        //Si no ha habido ningun error, guardamos el valor enviado en el array de departamento
    } else {
        //Si no ha habido ningun error, guardamos el valor enviado en el array de departamento
        $DescDepartamento = $_POST['DescDepartamento'];
    }
}
//Si no hemos pulsado el boton, o ha habido un error en la validacion mostrarmos el formulario
if (!filter_has_var(INPUT_POST, 'enviar') || $error) {
    ?>
    <form action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">


        <label for="DescDepartamento">Introduzca la descripcion del departamento:</label><br />
        <input type="text" name="DescDepartamento" value="<?php echo $DescDepartamento; ?>" class="<?PHP echo $estilosDepartamento; ?>"><br /><br />
    <?PHP echo $errorDepartamento; ?>

        <input type="submit" name="enviar" value="Enviar">

    </form>
    <?PHP
} else {
    //Creamos la consulta

    $consulta = "SELECT * FROM Departamento WHERE DescDepartamento LIKE CONCAT('%',\"" . $DescDepartamento . "\",'%')";
    //Preparamos la sentencia
    $resultado = $db->query($consulta);

    while ($departamento = $resultado->fetch(PDO::FETCH_OBJ)) {//Mientras haya resultados, se muestran formateados. FETCH avanza el puntero
        echo "Codigo Departamento:" . $departamento->CodDepartamento . "<br />";
        echo "Descripcion Departamento:" . $departamento->DescDepartamento . "<br />";
        echo "<br />";
    }
}
//Cerramos la conexion
unset($db);

} catch (PDOException $PdoE) {
    //Capturamos la excepcion en caso de que se produzca un error,mostramos el mensaje de error y deshacemos la conexion
    echo($PdoE->getMessage());
    unset($db);

}
?>
