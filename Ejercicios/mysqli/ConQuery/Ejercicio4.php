<?php
/*
  Autor: Juan Carlos Pastor Regueras
  Formulario de búsqueda de departamentos por descripción (por una parte del campo
  DescDepartamento)
  Fecha de modificacion: 29-10-2017
 */

include "../../config.php";
$db = new mysqli(HOST, USER, PASSWORD, DATABASE);

//Comprobamos si ha habido algun error de conexion, en tal caso mostramos el codigo de error
if ($db->connect_errno) {
    echo "Error al conectarse a la base de datos<br/>";
    echo "Codigo de error:" . $db->connect_errno;
} else {

    //Incluimos nuestra libreria de validacion
    include "../LibreriaValidacionFormularios.php";

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
        $resultado = $db->query($consulta);
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
}
?>
