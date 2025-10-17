<?php
function fetchMySponsorships()
{
    global $pdo;

    if (ob_get_level()) ob_end_clean(); // vide le tampon

    header('Content-Type: application/json; charset=utf-8');

    // Vérifie si l'utilisateur est connecté
    if (empty($_SESSION['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Utilisateur non connecté.'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    try {
        $stmt = $pdo->prepare("
            SELECT s.*, u.first_name AS sponsored_first_name, u.last_name AS sponsored_last_name
            FROM sponsorships s
            JOIN users u ON u.id = s.sponsored_id
            WHERE s.sponsor_id = ?
            ORDER BY s.id DESC
        ");
        $stmt->execute([$_SESSION['id']]);
        $sponsorships = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Renvoie toujours un JSON avec success et data/message
        if ($sponsorships) {
            echo json_encode([
                'success' => true,
                'data' => $sponsorships
            ], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Aucun parrainage trouvé.'
            ], JSON_UNESCAPED_UNICODE);
        }
        exit;
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Erreur lors de la récupération : ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
