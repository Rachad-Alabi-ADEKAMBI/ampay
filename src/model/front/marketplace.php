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

    // Capturer les données JSON envoyées par Axios
    $input = json_decode(file_get_contents('php://input'), true);
    if ($input) {
        $_POST = array_merge($_POST, $input);
    }

    file_put_contents('debug_log.txt', print_r($_POST, true), FILE_APPEND);

    // Vérification des champs requis
    $missingFields = [];
    if (!isset($_POST['message'])) $missingFields[] = 'message';
    if (!isset($_POST['listing_id'])) $missingFields[] = 'listing_id';

    if (!empty($missingFields)) {
        http_response_code(400);
        echo json_encode(['error' => 'Champs manquants : ' . implode(', ', $missingFields)]);
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
            INSERT INTO messages (created_at, listing_id, user_id, message, status)
            VALUES (NOW(), :listing_id, :user_id, :message, 'Envoyé')
        ");
        $stmt->execute([
            ':listing_id' => $listing_id,
            ':user_id' => $user_id,
            ':message' => $message
        ]);

        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
    }
}
