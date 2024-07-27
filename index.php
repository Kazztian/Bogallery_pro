<?php

require_once("Config/Config.php");
require_once("Helpers/Helpers.php");

$url = !empty($_GET['url']) ? $_GET['url'] : 'home/home';
$arrUrl = explode("/", $url);
$controller = $arrUrl[0];
$method = $arrUrl[0];
$params = ""; // Inicializado como una cadena vacía

if(!empty($arrUrl[1])) {
    if($arrUrl[1] != "") {
        $method = $arrUrl[1];
    }
}

if(!empty($arrUrl[2])) {
    if($arrUrl[2] != ""){
        for($i=2; $i < count($arrUrl); $i++)  {
            $params .= $arrUrl[$i].','; // Se están concatenando los parámetros en $params
        }
        $params = trim($params,',');  
    }
}

//AUTOLOAD
require_once("Libraries/Core/Autoload.php");
//LOAD
require_once("Libraries/Core/Load.php");

// echo "<br>";
// echo "Contolador: ". $controller;
// echo "<br>";
// echo "Metodo: ". $method;
// echo "<br>";
// echo "Parametros: ". $params;

?>
