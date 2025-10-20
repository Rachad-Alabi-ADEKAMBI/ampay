<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);



session_start();

// Configure le niveau de rapport des erreurs pour exclure les avertissements
error_reporting(E_ALL & ~E_WARNING);

// Affichage des erreurs
ini_set('display_errors', 1);

// Inclusion des contrôleurs nécessaires
require_once 'src/controller/front/home.php';
require_once 'src/controller/front/marketplace.php';
require_once 'src/controller/front/login.php';
require_once 'src/controller/front/register.php';

require_once 'src/controller/back/dashboard.php';
require_once 'src/controller/back/admin/transactions.php';
require_once 'src/controller/back/user/mytransactions.php';
require_once 'src/controller/back/user/mysponsorships.php';
require_once 'src/controller/back/admin/users.php';
require_once 'src/controller/back/admin/sponsorships.php';
require_once 'src/controller/back/profile.php';

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

        case 'transactionsPage':
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

        case 'getSponsor':
            getSponsor();
            break;

        case 'usersPage':
            usersPage();
            break;

        case 'profilePage':
            profilePage();
            break;

        case 'loginPage':
            loginPage();
            break;

        case 'login':
            login();
            break;

        case 'register':
            register();
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
