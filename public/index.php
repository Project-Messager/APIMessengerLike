<?php
session_start();
require_once __DIR__.DIRECTORY_SEPARATOR ."./../vendor/autoload.php";
ini_set("pcre.backtrack_limit", "2048000000");
ini_set('memory_limit', '1024M');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function chargerClasse($classe){
    //$classe va ressembler à src\Model\Article
    $ds = DIRECTORY_SEPARATOR;
    // JE veux le document ROOT (c'est à dire www)
    $dir = __DIR__."$ds.."; // Je remonte d'un cran pour wwww

    //Remplacer les séparateur du namespace "src\Model\Article"
    $className = str_replace('\\', $ds, $classe);

    $file = "{$dir}{$ds}{$className}.php";
    if(is_readable($file)){
        require_once $file;
    }
}
spl_autoload_register("chargerClasse");

$urls = explode("/",$_GET["url"]);
$controller = (isset($urls[0])) ? $urls[0] : '';
$action = (isset($urls[1])) ? $urls[1] : '';
$param = (isset($urls[2])) ? $urls[2] : '';

if($controller != ''){
    try {
        $class = "App\Controller\\".$controller."Controller";
        if (class_exists($class)) {
            $controller = new $class();
            if (method_exists($class, $action)) {
                echo $controller->$action($param);
            }else { echo'Acion n\'existe pas pour ce controller !';}
        }else { echo 'Le controlleur n\'existe pas pour cette url !';}
    }
    catch(Exception $e) {
        // Penser à Gérer l’exception
        echo $e->getMessage();
    }
}else {
    //Route par défaut (/)
    $controller = new \src\Controller\ApiMessageController();
    echo $controller->all();
}
?>