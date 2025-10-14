<?php

function fetchMyTransactions()
{
    global $pdo;
    if (ob_get_level()) ob_end_clean(); // vide le tampon
    header('Content-Type: application/json; charset=utf-8');

    if (empty($_SESSION['id'])) {
        echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM listings WHERE user_id = ? ORDER BY id DESC");
        $stmt->execute([$_SESSION['id']]);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'data' => $transactions]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}
