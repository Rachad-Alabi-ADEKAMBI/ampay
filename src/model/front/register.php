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


function registerUser()
{
    global $pdo;

    if (!$pdo) {
        header('Content-Type: application/json', true, 500);
        echo json_encode(['error' => 'Database connection not initialized.']);
        exit;
    }

    // Récupération des données POST JSON
    $data = json_decode(file_get_contents('php://input'), true);

    $firstName = trim($data['firstName'] ?? '');
    $lastName = trim($data['lastName'] ?? '');
    $email = trim($data['email'] ?? '');
    $country = trim($data['country'] ?? '');
    $city = trim($data['city'] ?? '');
    $phonePrefix = trim($data['phonePrefix'] ?? '');
    $phone = trim($data['phone'] ?? '');
    $password = $data['password'] ?? '';
    $confirmPassword = $data['confirmPassword'] ?? '';
    $role = 'user';
    $account_verified = $data['account_verified'] ?? 'no';
    $is_sponsored = $data['is_sponsored'] ?? false;
    $sponsor_id = $data['sponsor_id'] ?? null;
    $status = "En attente";
    $username = $data['username'] ?? ''; // si tu as ce champ

    // Validation des champs
    if (!$firstName || !$lastName || !$email || !$country || !$city || !$phone || !$password || !$confirmPassword) {
        echo json_encode(['error' => 'Tous les champs sont obligatoires']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Email invalide']);
        exit;
    }

    if (strlen($password) < 8) {
        echo json_encode(['error' => 'Le mot de passe doit contenir au moins 8 caractères']);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['error' => 'Les mots de passe ne correspondent pas']);
        exit;
    }

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['error' => 'Cet email est déjà utilisé']);
        exit;
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Insérer l'utilisateur
    $stmt = $pdo->prepare("INSERT INTO users 
        (first_name, last_name, username, email, country, city, phone_prefix, phone, password, role, status, account_verified, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $result = $stmt->execute([
        $firstName,
        $lastName,
        $username,
        $email,
        $country,
        $city,
        $phonePrefix,
        $phone,
        $passwordHash,
        $role,
        $status,
        $account_verified
    ]);

    if ($result) {
        $userId = $pdo->lastInsertId();

        // Création du lien de parrainage : 2 premières lettres du nom de famille + jour + 'am25'
        $day = date('d');
        $referral_link = strtoupper(substr($lastName, 0, 2)) . $day . 'am25';

        // Mise à jour du lien de parrainage
        $stmt = $pdo->prepare("UPDATE users SET referral_link = ? WHERE id = ?");
        $stmt->execute([$referral_link, $userId]);

        // Gestion du parrainage si applicable
        if ($is_sponsored && $sponsor_id) {
            $stmt = $pdo->prepare("INSERT INTO sponsorships (sponsor_id, sponsored_id, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$sponsor_id, $userId]);
        }

        // Remplir la session
        $_SESSION['id'] = $userId;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $_SESSION['role'] = $role;
        $_SESSION['country'] = $country;
        $_SESSION['phone_prefix'] = $phonePrefix;
        $_SESSION['phone'] = $phone;
        $_SESSION['referral_link'] = $referral_link;

        // Réponse JSON au front
        echo json_encode([
            'success' => 'Compte créé avec succès',
            'user' => [
                'id' => $userId,
                'email' => $email,
                'username' => $username,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'role' => $role,
                'country' => $country,
                'phone_prefix' => $phonePrefix,
                'phone' => $phone,
                'referral_link' => $referral_link
            ]
        ]);
        exit;
    } else {
        $errorInfo = $stmt->errorInfo();
        echo json_encode(['error' => $errorInfo[2] ?? 'Erreur lors de la création du compte']);
        exit;
    }
}
