<?php

function fetchAllMessagesByListingId($listing_id)
{
    global $pdo;

    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("
            SELECT 
                m.id,
                m.listing_id,
                m.sender_id,
                m.message,
                m.created_at,
                u.first_name,
                u.last_name,
                u.email
            FROM messages m
            INNER JOIN users u ON m.sender_id = u.id
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
