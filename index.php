<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);



session_start();

// Configure le niveau de rapport des erreurs pour exclure les avertissements
error_reporting(E_ALL & ~E_WARNING);

// Affichage des erreurs
ini_set('display_errors', 1);

// Inclusion des contrôleurs nécessaires
require_once 'src/controller/home.php';
require_once 'src/controller/marketplace.php';
require_once 'src/controller/login.php';
require_once 'src/controller/register.php';

require_once 'src/controller/dashboard.php';
require_once 'src/controller/admin/transactions.php';
require_once 'src/controller/mytransactions.php';
require_once 'src/controller/mysponsorships.php';
require_once 'src/controller/admin/users.php';
require_once 'src/controller/admin/sponsorships.php';
require_once 'src/controller/profile.php';

if (isset($_GET['action']) && !empty($_GET['action'])) {
    switch ($_GET['action']) {
        case 'home':
            homePage();
            break;

        case 'marketplace':
            marketplacePage();
            break;

        case 'dashboard':
            dashboardPage();
            break;

        case 'transactions':
            transactionsPage();
            break;

        case 'myTransactionsPage':
            myTransactionsPage();
            break;

        case 'myTransactionsList':
            myTransactionsList();
            exit;
            break;

        case 'createTransaction':
            createTransaction();
            exit;
            break;

        case 'mySponsorshipsPage':
            mySponsorshipsPage();
            break;

        case 'mySponsorshipsList':
            mySponsorshipsList();
            break;

        case 'sponsorshipsPage':
            sponsorshipsPage();
            break;

        case 'usersPage':
            usersPage();
            break;

        case 'profile':
            profilePage();
            break;

        case 'loginPage':
            loginPage();
            break;

        case 'login':
            login();
            break;

        case 'logout':
            // Vérifie si une session est active
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Détruit toutes les variables de session
            $_SESSION = [];

            // Détruit le cookie de session si nécessaire
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }

            // Termine la session
            session_destroy();

            // Redirection vers la page d'accueil
            header("Location: index.php?action=home");
            exit();
            break;


        case 'registerPage':
            registerPage();
            break;

        default: ?>
            <script>
                alert("Page non trouvée ! Merci de vérifier cette adresse ! ");
                window.history.back();
                exit();
            </script>
<?php
    }
} else {
    // Page d'accueil par défaut
    homePage();
}
