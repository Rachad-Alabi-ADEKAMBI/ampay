<?php
//session_start();
include __DIR__ . '/../config.php';
// Connexion d'un utilisateur
function loginUser()
{
    global $pdo;
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['email']) || empty($data['password'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Email et mot de passe requis.'
        ]);
        return;
    }

    $email = trim($data['email']);
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['email'] = $user['email'];

        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name'];

        $_SESSION['last_name'] = $user['last_name'];

        $_SESSION['role'] = $user['role'];
        $_SESSION['country'] = $user['country'];

        $_SESSION['phone_prefix'] = $user['phone_prefix'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['referral_link'] = $user['referral_link'];

        echo json_encode([
            'success' => true,
            'redirect' => 'index.php?action=dashboard'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Email ou mot de passe incorrect.'
        ]);
    }
}
