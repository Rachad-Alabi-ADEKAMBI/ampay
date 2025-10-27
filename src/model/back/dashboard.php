<?php



function fetchAllMessages()
{
    global $pdo;
    $stmt = $pdo->query("
        SELECT messages.*, users.*
        FROM messages
        INNER JOIN users ON users.id = messages.sender_id
        ORDER BY messages.id DESC
    ");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($messages);
}


function newMessage()
{
    global $pdo;
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    ob_clean(); // ← vide tout tampon de sortie

    if (!isset($_SESSION['id'])) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non authentifié.']);
        exit;
    }

    $sender_id = (int) $_SESSION['id'];
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        echo json_encode(['success' => false, 'error' => 'Aucune donnée reçue.']);
        exit;
    }

    if (empty($input['listing_id']) || empty(trim($input['message'])) || empty($input['receiver_id'])) {
        echo json_encode(['success' => false, 'error' => 'Champs manquants.']);
        exit;
    }

    $listing_id  = (int) $input['listing_id'];
    $message     = trim($input['message']);
    $receiver_id = (int) $input['receiver_id'];

    try {
        $stmt = $pdo->prepare("
            INSERT INTO messages (created_at, listing_id, message, sender_id, receiver_id, status)
            VALUES (NOW(), :listing_id, :message, :sender_id, :receiver_id, 'Envoyé')
        ");
        $stmt->execute([
            ':listing_id'  => $listing_id,
            ':message'     => $message,
            ':sender_id'   => $sender_id,
            ':receiver_id' => $receiver_id
        ]);

        echo json_encode(['success' => true, 'message' => 'Message envoyé avec succès.']);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur base de données : ' . $e->getMessage()]);
        exit;
    }
}


function fetchConversations()
{
    global $pdo;
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    ob_clean();

    if (!isset($_SESSION['id'])) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non authentifié.']);
        exit;
    }

    $user_id = (int) $_SESSION['id'];
    $listing_id = isset($_GET['listing_id']) ? (int) $_GET['listing_id'] : 0;

    if ($listing_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'ID de transaction invalide.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            SELECT 
                m.id,
                m.message,
                m.sender_id,
                m.receiver_id,
                m.status,
                m.created_at,
                s.username AS sender_name,
                r.username AS receiver_name
            FROM messages m
            LEFT JOIN users s ON s.id = m.sender_id
            LEFT JOIN users r ON r.id = m.receiver_id
            WHERE m.listing_id = :listing_id
              AND (:user_id IN (m.sender_id, m.receiver_id))
            ORDER BY m.created_at ASC
        ");
        $stmt->execute([
            ':listing_id' => $listing_id,
            ':user_id' => $user_id
        ]);

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode([
            'success' => true,
            'messages' => $messages
        ]);
        exit;
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur base de données : ' . $e->getMessage()
        ]);
        exit;
    }
}
