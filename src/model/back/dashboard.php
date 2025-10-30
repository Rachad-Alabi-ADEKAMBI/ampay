<?php



function fetchAllMessages()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT 
            messages.id AS message_id,
            messages.created_at AS message_date,
            messages.listing_id,
            messages.message,
            messages.sender_id,
            messages.receiver_id,
            messages.status AS message_status,       -- ✅ status du message
            users.first_name,
            users.last_name,
            users.email,
            users.phone,
            users.username,
            users.country,
            users.city
        FROM messages
        INNER JOIN users ON users.id = messages.sender_id
        ORDER BY messages.id DESC
    ");

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($messages, JSON_UNESCAPED_UNICODE);
}



function newMessage()
{
    global $pdo;
    session_start();
    header('Content-Type: application/json; charset=utf-8');
    ob_clean(); // Vide tout tampon de sortie

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

    $missing = [];

    if (empty($input['listing_id'])) $missing[] = 'listing_id';
    if (empty($input['message']) || !trim($input['message'])) $missing[] = 'message';
    if (empty($input['receiver_id'])) $missing[] = 'receiver_id';

    if (!empty($missing)) {
        echo json_encode([
            'success' => false,
            'error' => 'Champs manquants : ' . implode(', ', $missing)
        ]);
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
        echo json_encode(['success' => false, 'error' => 'Utilisateur non authentifié.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $user_id = (int) $_SESSION['id'];
    $listing_id = isset($_GET['listing_id']) ? (int) $_GET['listing_id'] : 0;

    if ($listing_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'ID de transaction invalide.'], JSON_UNESCAPED_UNICODE);
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
                s.first_name AS sender_first_name,
                s.last_name AS sender_last_name,
                r.username AS receiver_name,
                r.first_name AS receiver_first_name,
                r.last_name AS receiver_last_name
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
        ], JSON_UNESCAPED_UNICODE);
        exit;
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erreur base de données : ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
