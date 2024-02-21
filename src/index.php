<?php
echo("<form method='POST' action='/users' enctype='multipart/form-data'>
    <input value='" . (isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '') . "' type='email' name='email' placeholder='Votre email'>
    <input type='password' name='password' placeholder='Votre mot de passe'>
    <input type='text' name='name' placeholder='Votre prénom'>
    <input type='text' name='surname' placeholder='Votre nom'>
    <input type='submit' value='Inscription'>
</form>");?>