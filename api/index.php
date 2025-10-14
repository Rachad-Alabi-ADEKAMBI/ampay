<?php
header('Content-Type: application/json');
include 'functions.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'allListings':
        getAllListings();
        break;

    case 'allUsers':
        getAllUsers();
        break;

    case 'allMessages':
        getAllMessages();
        break;

    case 'allSponsorships':
        getAllSponsorships();
        break;

    case 'register':
        $data = json_decode(file_get_contents('php://input'), true);
        register($pdo, $data);
        break;

    case 'createListing':
        $data = json_decode(file_get_contents("php://input"), true);
        createListing($pdo, $data);
        break;


    case 'login':
        // Récupérer les données POST
        $data = json_decode(file_get_contents("php://input"), true);
        login($data);
        break;

    case 'logout':
        logout();
        break;

    default:
        echo json_encode(['error' => 'Action non reconnue']);
        break;
}
