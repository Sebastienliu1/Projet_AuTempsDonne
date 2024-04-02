<?php
require_once("views/main.php");
error_reporting(E_ALL); ini_set('display_errors', '1');
echo("<form method='POST' action='/users' enctype='multipart/form-data'>
    <input value='" . (isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '') . "' type='email' name='email' placeholder='Votre email'>
    <input type='password' name='password' placeholder='Votre mot de passe'>
    <input type='text' name='name' placeholder='Votre prénom'>
    <input type='text' name='surname' placeholder='Votre nom'>
    <input type='submit' value='Inscription'>
</form>");

$json = new ArrayValue($_POST);

$json->jsonSerialize();