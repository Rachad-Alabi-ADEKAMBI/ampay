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
                m.receiver_id,
                m.message,
                m.created_at,

                -- Infos sender
                s.first_name AS sender_first_name,
                s.last_name AS sender_last_name,
                s.email AS sender_email,

                -- Infos receiver
                r.first_name AS receiver_first_name,
                r.last_name AS receiver_last_name,
                r.email AS receiver_email

            FROM messages m
            INNER JOIN users s ON m.sender_id = s.id
            LEFT JOIN users r ON m.receiver_id = r.id
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
