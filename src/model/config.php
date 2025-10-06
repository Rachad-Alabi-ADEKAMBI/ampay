<?php

$pdo = new PDO('mysql:dbname=ampay;host=localhost', 'root', '');
function getConnexion()
{
    return new PDO(
        'mysql:host=localhost; dbname=ampay; charset=UTF8',
        'root',
        ''
    );
}

function sendJSON($infos)
{
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    echo json_encode($infos, JSON_UNESCAPED_UNICODE);
}

$error = ['error' => false];
$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

//controle des input
function verifyInput($inputContent)
{
    $inputContent = htmlspecialchars($inputContent);

    $inputContent = trim($inputContent);

    return $inputContent;
}
