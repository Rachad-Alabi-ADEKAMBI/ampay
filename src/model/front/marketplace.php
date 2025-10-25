<?php
//session_start();
include __DIR__ . '/../config.php';

// Envoi d'une demande de contact
function contactRequestUser()
{
    file_put_contents('debug_log.txt', "contactRequestUser() appelée\n", FILE_APPEND);

    global $pdo;
    header('Content-Type: application/json; charset=utf-8');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Pour capturer les données JSON envoyées par Axios
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input) {
        $_POST = array_merge($_POST, $input);
    }

    file_put_contents('debug_log.txt', print_r($_POST, true), FILE_APPEND);

    if (!isset($_POST['message'], $_POST['listing_id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Champs manquants.']);
        exit;
    }

    $message = trim($_POST['message']);
    $listing_id = (int) $_POST['listing_id'];

    if ($message === '') {
        http_response_code(400);
        echo json_encode(['error' => 'Le message ne peut pas être vide.']);
        exit;
    }

    session_start();
    if (!isset($_SESSION['id'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Utilisateur non authentifié.']);
        exit;
    }

    $user_id = (int) $_SESSION['id'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO messages (created_at, transaction_id, user_id, message, status)
            VALUES (NOW(), :transaction_id, :user_id, :message, 'envoyé')
        ");
        $stmt->execute([
            ':transaction_id' => $listing_id,
            ':user_id' => $user_id,
            ':message' => $message
        ]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
    }
}

function fetchMesssageByListingId(){

}
