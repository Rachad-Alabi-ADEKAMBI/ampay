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
