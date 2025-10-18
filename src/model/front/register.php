<?php
//session_start();
require_once __DIR__ . '/../config.php';


function fetchSponsor($ref)
{
    // Assure-toi que $pdo est défini
    global $pdo;

    if (!$pdo) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Database connection not initialized.']);
        exit;
    }

    try {
        if (!$ref) {
            throw new Exception('No referral ID provided.');
        }

      

        $stmt = $pdo->prepare("SELECT id, first_name AS sponsor_first_name, last_name AS sponsor_last_name 
                               FROM users 
                               WHERE referral_link = :ref 
                               LIMIT 1");
        $stmt->execute(['ref' => $ref]);
        $sponsor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sponsor) {
            throw new Exception('Sponsor not found.');
        }

        header('Content-Type: application/json');
        echo json_encode($sponsor);
        exit;
    } catch (Exception $e) {
        header('Content-Type: application/json', true, 400);
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}
