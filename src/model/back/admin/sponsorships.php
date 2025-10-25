<?php

function fetchAllSponsorships()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT 
            s.id,
            s.created_at,
            sponsor.id AS sponsor_id,
            sponsor.first_name AS sponsor_first_name,
            sponsor.last_name AS sponsor_last_name,
            sponsored.id AS sponsored_id,
            sponsored.first_name AS sponsored_first_name,
            sponsored.last_name AS sponsored_last_name
        FROM sponsorships s
        INNER JOIN users sponsor ON sponsor.id = s.sponsor_id
        INNER JOIN users sponsored ON sponsored.id = s.sponsored_id
        ORDER BY s.id DESC
    ");

    $sponsorships = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($sponsorships);
}
