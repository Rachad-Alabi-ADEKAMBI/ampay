<?php

/*
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

    $sql = "INSERT INTO LISTINGS (user_id, type, amount, currency, country, city, delay, created_at)
            VALUES (:user_id, :type, :amount, :currency, :country, :city, :delay, NOW())";

    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':type' => $data['type'],
            ':amount' => $data['amount'],
            ':currency' => $data['currency'],
            ':country' => $data['country'],
            ':city' => $data['city'],
            ':delay' => $data['delay']
        ]);
        return ['success' => true, 'message' => 'Annonce créée avec succès.'];
    } catch (PDOException $e) {
        return ['success' => false, 'error' => 'Erreur base de données : ' . $e->getMessage()];
    }
}
*/

function fetchAllMessagesByListingId($listing_id)
{
    global $pdo;

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            SELECT 
                m.id,
                m.listing_id,
                m.user_id,
                m.message,
                m.created_at,
                u.first_name,
                u.last_name,
                u.email
            FROM messages m
            INNER JOIN users u ON m.user_id = u.id
            WHERE m.listing_id = :listing_id
            ORDER BY m.created_at DESC
        ");

        $stmt->bindParam(':listing_id', $listing_id, PDO::PARAM_INT);
        $stmt->execute();

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $messages
        ]);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Erreur de récupération des messages : ' . $e->getMessage()
        ]);
    }
}

function fetchAllListings()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT 
            listings.id AS listing_id,
            listings.created_at,
            listings.user_id,
            listings.type,
            listings.ratings,
            listings.amount,
            listings.currency,
            listings.country,
            listings.city,
            listings.status,
            listings.delay,
            users.first_name,
            users.last_name,
            users.phone,
            users.email,
            users.username
        FROM listings
        INNER JOIN users ON users.id = listings.user_id
        ORDER BY listings.id DESC
    ");

    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($listings);
}
