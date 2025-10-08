<?php
require_once './src/model/login.php';

function loginPage()
{
    require './src/view/front/login.php'; // pas ./src/view/front/login.php si ton fichier est dans /view/login.php
}

function login()
{
    // Appelle la fonction du modèle
    loginUser();
}
