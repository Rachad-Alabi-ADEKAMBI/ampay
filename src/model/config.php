<?php

date_default_timezone_set('Africa/Porto-Novo');

// Crée une seule instance PDO et sécurise la fonction contre redéclaration
if (!function_exists('getConnexion')) {
    function getConnexion()
    {
        static $pdo = null;

        if ($pdo === null) {
            try {
                $pdo = new PDO(
                    'mysql:host=localhost;dbname=ampay;charset=UTF8',
                    'root',
                    ''
                );
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erreur de connexion : " . $e->getMessage());
            }
        }

        return $pdo;
    }
}

// Fonction pour envoyer du JSON
if (!function_exists('sendJSON')) {
    function sendJSON($infos)
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        echo json_encode($infos, JSON_UNESCAPED_UNICODE);
    }
}

// Initialisation des variables
$error = ['error' => false];
$action = $_GET['action'] ?? '';

// Contrôle des inputs
if (!function_exists('verifyInput')) {
    function verifyInput($inputContent)
    {
        return trim(htmlspecialchars($inputContent));
    }
}

$pdo = getConnexion();
