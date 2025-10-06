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


//inscription

session_start();

function register($pdo, $data)
{
    header('Content-Type: application/json');

    $firstName = trim($data['firstName'] ?? '');
    $lastName = trim($data['lastName'] ?? '');
    $email = trim($data['email'] ?? '');
    $country = trim($data['country'] ?? '');
    $city = trim($data['city'] ?? '');
    $phonePrefix = trim($data['phonePrefix'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $password = $data['password'] ?? '';
    $confirmPassword = $data['confirmPassword'] ?? '';
    $role = $data['role'] ?? 'user';
    $account_verified = $data['account_verified'] ?? 'no';

    // Vérifications
    if (!$firstName || !$lastName || !$email || !$country || !$city || !$phone || !$password || !$confirmPassword) {
        echo json_encode(['error' => 'Tous les champs sont obligatoires']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Email invalide']);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(['error' => 'Le mot de passe doit contenir au moins 8 caractères']);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['error' => 'Les mots de passe ne correspondent pas']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['error' => 'Cet email est déjà utilisé']);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, country, city, phone_prefix, phone, password, role, account_verified, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $result = $stmt->execute([
        $firstName,
        $lastName,
        $email,
        $country,
        $city,
        $phonePrefix,
        $phone,
        $passwordHash,
        $role,
        $account_verified
    ]);

    if ($result) {
        $userId = $pdo->lastInsertId();
        $_SESSION['user'] = [
            'id' => $userId,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'role' => $role
        ];

        echo json_encode(['success' => 'Compte créé avec succès', 'user' => $_SESSION['user']]);
        exit;
    } else {
        // Récupère l'erreur exacte de PDO
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['error' => $errorInfo[2] ?? 'Erreur lors de la création du compte']);
        exit;
    }
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
