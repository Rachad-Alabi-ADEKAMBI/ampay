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

function newTransaction()
{
    global $pdo;

    // Récupération et décodage des données JSON envoyées par Axios
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        return ['success' => false, 'error' => 'Aucune donnée reçue.'];
    }

    $required = ['type', 'amount', 'currency', 'country', 'city', 'delay', 'user_id'];

    foreach ($required as $field) {
        if (!isset($data[$field]) || $data[$field] === '') {
            return ['success' => false, 'error' => "Le champ '$field' est requis."];
        }
    }

    // Valeur par défaut du statut
    $status = 'Actif';

    // Ajout du champ "status" dans la requête
    $sql = "INSERT INTO LISTINGS (user_id, type, amount, currency, country, city, delay, status, created_at)
            VALUES (:user_id, :type, :amount, :currency, :country, :city, :delay, :status, NOW())";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':type' => $data['type'],
            ':amount' => $data['amount'],
            ':currency' => $data['currency'],
            ':country' => $data['country'],
            ':city' => $data['city'],
            ':delay' => $data['delay'],
            ':status' => $status
        ]);
        return ['success' => true, 'message' => 'Annonce créée avec succès.'];
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Erreur base de données : ' . $e->getMessage()];
    }
}

function updateListing()
{
    global $pdo;

    // Récupération et décodage des données JSON envoyées par Axios
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        return ['success' => false, 'error' => 'Aucune donnée reçue.'];
    }

    // Vérification des champs requis
    $required = ['id', 'type', 'amount', 'currency', 'country', 'city', 'delay', 'status'];
    foreach ($required as $field) {
        if (!isset($data[$field]) || $data[$field] === '') {
            return ['success' => false, 'error' => "Le champ '$field' est requis."];
        }
    }

    $sql = "UPDATE listings
            SET type = :type,
                amount = :amount,
                currency = :currency,
                country = :country,
                city = :city,
                delay = :delay,
                status = :status,
                updated_at = NOW()
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':id' => $data['id'],
            ':type' => $data['type'],
            ':amount' => $data['amount'],
            ':currency' => $data['currency'],
            ':country' => $data['country'],
            ':city' => $data['city'],
            ':delay' => $data['delay'],
            ':status' => $data['status']
        ]);

        if ($stmt->rowCount() > 0) {
            return ['success' => true, 'message' => 'Annonce mise à jour avec succès.'];
        } else {
            return ['success' => false, 'error' => "Aucune modification détectée ou ID introuvable."];
        }
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Erreur base de données : ' . $e->getMessage()];
    }
}

function fetchCommentedTransactions()
{
    global $pdo;
    $user_id = (int) $_SESSION['id'];

    try {
        // Récupère tous les messages envoyés par l'utilisateur avec les infos de listing
        $sql = "
            SELECT l.id AS listing_id, l.type, l.amount, l.currency, l.country, l.city, l.delay, l.status, l.created_at AS listing_created_at,
                   m.id AS message_id, m.message, m.created_at AS message_created_at
            FROM listings l
            INNER JOIN messages m ON l.id = m.listing_id
            WHERE m.sender_id = :sender_id
            ORDER BY l.created_at DESC, m.created_at DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':sender_id' => $user_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$rows) {
            echo json_encode(['success' => true, 'data' => [], 'message' => 'Aucun listing trouvé pour cet utilisateur.']);
            exit;
        }

        // Regroupe les messages par listing
        $listings = [];
        foreach ($rows as $row) {
            $id = $row['listing_id'];
            if (!isset($listings[$id])) {
                $listings[$id] = [
                    'listing_id' => $row['listing_id'],
                    'type' => $row['type'],
                    'amount' => $row['amount'],
                    'currency' => $row['currency'],
                    'country' => $row['country'],
                    'city' => $row['city'],
                    'delay' => $row['delay'],
                    'status' => $row['status'],
                    'listing_created_at' => $row['listing_created_at'],
                    'messages' => []
                ];
            }
            $listings[$id]['messages'][] = [
                'message_id' => $row['message_id'],
                'message' => $row['message'],
                'message_created_at' => $row['message_created_at']
            ];
        }

        echo json_encode(['success' => true, 'data' => array_values($listings)]);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur base de données : ' . $e->getMessage()]);
        exit;
    }
}
