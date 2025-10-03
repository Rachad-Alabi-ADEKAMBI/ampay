<?php
require 'db.php';

// Récupérer toutes les listings
function getAllListings()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM listings ORDER BY id DESC");
    $listings = $stmt->fetchAll();
    echo json_encode($listings);
}

// Récupérer toutes les claims
function getAllUsers()
{
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM users WHERE role != 'admin' ORDER BY id DESC");
    $users = $stmt->fetchAll();
    echo json_encode($users);
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
