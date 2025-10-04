<?php
require 'db.php';

// Récupérer toutes les listings
function getAllListings()
{
    global $pdo;
    $stmt = $pdo->query("
        SELECT listings.*, users.*
        FROM listings
        INNER JOIN users ON users.id = listings.user_id
        ORDER BY listings.id DESC
    ");
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($listings);
}


// Récupérer toutes les claims
function getAllUsers()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users WHERE role != 'admin'   ORDER BY id DESC");
    $users = $stmt->fetchAll();
    echo json_encode($users);
}

// Récupérer tous les messages
function getAllMessages()
{
    global $pdo;
    $stmt = $pdo->query("
        SELECT messages.*, users.*
        FROM messages
        INNER JOIN users ON users.id = messages.user_id
        ORDER BY messages.id DESC
    ");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($messages);
}

// Récupérer tous les parrainages
function getAllSponsorships()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT 
            s.id,
            s.created_at,
            sponsor.id AS sponsor_id,
            sponsor.first_name AS sponsor_first_name,
            sponsor.last_name AS sponsor_last_name,
            sponsored.id AS sponsored_id,
            sponsored.first_name AS sponsored_first_name,
            sponsored.last_name AS sponsored_last_name
        FROM sponsorships s
        INNER JOIN users sponsor ON sponsor.id = s.sponsor_id
        INNER JOIN users sponsored ON sponsored.id = s.sponsored_id
        ORDER BY s.id DESC
    ");

    $sponsorships = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($sponsorships);
}



// Connexion d'un utilisateur
function login($data)
{
    global $pdo;

    if (empty($data['username']) || empty($data['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Nom d\'utilisateur et mot de passe requis'
        ]);
        return;
    }

    $username = $data['username'];
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        echo json_encode([
            'success' => true,
            'redirect' => 'http://127.0.0.1/tossin/index.php'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nom d’utilisateur ou mot de passe incorrect'
        ]);
    }
}

// logout
function logout()
{
    session_start();
    session_unset();
    session_destroy();

    header('Location: ../login.php');
    exit; // Important pour arrêter le script après la redirection
}
