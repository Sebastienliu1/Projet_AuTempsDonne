<?php
include_once 'controllers/userController.php';
require_once 'config.php';

// Skipper les warnings, pour la production (vos exceptions devront être gérées proprement)
error_reporting(E_ERROR | E_PARSE);

// le contenu renvoyé par le serveur sera du JSON
header("Content-Type: application/json; charset=utf8");
// Autorise les requêtes depuis localhost
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS,PATCH');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

 file_put_contents('debug.log', $_SERVER['REQUEST_URI'] . PHP_EOL, FILE_APPEND);
 echo 'REQUEST_URI: ' . $_SERVER['REQUEST_URI'] . PHP_EOL;
  echo 'QUERY_STRING: ' . $_SERVER['QUERY_STRING'] . PHP_EOL;

const URI_LENGTH = 4;
session_unset();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
 echo($_SERVER['REQUEST_URI']);
$uri = explode($uri,'/', 3);
 var_dump($uri);
 var_dump($uri[$URI_LENGTH - 1]);   

if (empty($uri[URI_LENGTH - 1])) {
    header("HTTP/1.1 200 OK");
    echo '{"message": "Welcome to the API"}';
    exit();
}

switch ($uri[URI_LENGTH - 1]) {
    case 'users':
        $controller = new userController(new config());
        $controller->userHandler($_SERVER['REQUEST_METHOD']);
        break;
    default:
        echo("error of uri");
        break;
}
?>
