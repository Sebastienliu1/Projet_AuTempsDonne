<?php
include_once 'controllers/uController.php';
// Skipper les warnings, pour la production (vos exceptions devront être gérées proprement)
error_reporting(E_ERROR | E_PARSE);

// le contenu renvoyé par le serveur sera du JSON
header("Content-Type: application/json; charset=utf8");
// Autorise les requêtes depuis localhost
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS,PATCH');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

const URI_LENGTH = 4;
session_unset();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$urine = $uri;
$uri = explode('/',  $uri, 4 );
if (empty($uri[count($uri) - 1])) {
    header("HTTP/1.1 200 OK");
    echo '{"message": "Welcome to the API"}';
    exit();
}

print_r($uri);

$post = json_encode($_POST); 
print_r($post); // to be deleted when proper front will be there

switch ($uri[count($uri) - 1]) {
    case 'users':
        $controller = new userController();
        $controller->userHandler($post);
        break;
    default:
        echo("error of uri");
        break;
}
