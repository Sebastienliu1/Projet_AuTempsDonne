<?php
require_once("views/main.php");
error_reporting(E_ALL); ini_set('display_errors', '1');
echo("<form method='POST' action='/users' enctype='multipart/form-data'>
    <input value='" . (isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '') . "' type='email' name='email' placeholder='Votre email'>
    <input type='password' name='password' placeholder='Votre mot de passe'>
    <input type='text' name='name' placeholder='Votre prénom'>
    <input type='text' name='surname' placeholder='Votre nom'>
    <div>
    <input type='radio' id='Admin' name='type' value='Admin' />
    <label for='Admin'>Admin</label>
    </div>
    <div>
    <input type='radio' id='Bénéficiaire' name='type' value='Bénéficiaire' />
    <label for='Bénéficiaire'>Bénéficiaire</label>
    </div>
    <div>
    <input type='radio' id='Bénévole' name='type' value='Bénévole' />
    <label for='Bénévole'>Bénévole</label>
    </div>
    <input type='submit' value='Inscription'>
</form>");