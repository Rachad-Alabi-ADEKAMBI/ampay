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
