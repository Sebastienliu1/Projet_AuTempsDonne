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
    const URI_LENGTH = 3;
    session_unset();
    require_once  'controllers/userController.php';
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    echo($_SERVER['REQUEST_URI'])   ;
    $uri = explode( '/', trim($uri, '/') );

    if (empty($uri[URI_LENGTH - 1])) {
        header("HTTP/1.1 200 OK");
        echo '{"message": "Welcome to the API"}';
        exit();
    }
switch($uri[URI_LENGTH-1]){
    case 'users':
        $controller = new userController(new config());
        $controller->userHandler($_SERVER['REQUEST_METHOD']);
        break;
    default:
        echo("error of uri");
        break;

}
?>