<?php
//LOAD
//Convierte las primeras letras en mayusculas, por servidores sensibles a las mayusculas
$controller = ucwords($controller);
$controllerFile = "Controllers/".$controller.".php";
if(file_exists($controllerFile)) 
{
    require_once($controllerFile);
    $controllerInstance = new $controller();
    if(method_exists($controllerInstance, $method)) {
        $controllerInstance->{$method}($params);
    } else {
        require_once("Controllers/Error.php");
    }
} else {
    require_once("Controllers/Error.php");
}



?>