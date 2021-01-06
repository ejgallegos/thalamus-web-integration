<?php
error_reporting(-1);
/**
*
* FrontCrontoller de la Aplicación.
* Rutea las peticiones del cliente teniendo en cuenta la estructura
* /MODULO/RECURSO/ARGUMENTO
*
* @package    THALAMUS INTEGRATION
* @version    1.0
**/
header('Content-Type: text/html; charset=utf8');
//Thalamus SDK v.4
require_once "common/libs/ThalamusSDK/autoload.php";
require_once 'settings.php';
require_once 'core/database.php';
require_once 'core/collector.php';
require_once 'core/collector_condition.php';
require_once 'core/view.php';
require_once 'core/standardobject.php';
require_once 'core/sessions.php';
require_once 'core/sessions.cliente.php';
require_once 'core/helpers/files.php';
require_once 'core/helpers/appfiles.php';
require_once "core/helpers/configuracionmenu.php";
require_once 'core/helpers/GoogChart.class.php';


$peticion = $_SERVER['REQUEST_URI'];
if (SO_UNIX == true) {
	@list($app, $modulo, $recurso, $argumento) = explode('/', $peticion);
} else {
	@list($null, $app, $modulo, $recurso, $argumento) = explode('/', $peticion);
}

if(empty($modulo)) { $modulo = DEFAULT_MODULE; }
if(empty($recurso)) { $recurso = DEFAULT_ACTION; }
if(!file_exists("modules/{$modulo}/controller.php")) {
    $modulo = DEFAULT_MODULE;
}
$archivo = "modules/{$modulo}/controller.php";

require_once $archivo;
$controller_name = ucwords($modulo) . 'Controller';
$controller = new $controller_name;
$recurso = (method_exists($controller, $recurso)) ? $recurso : DEFAULT_ACTION;
$controller->$recurso($argumento);
?>
