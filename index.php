<?php
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
require_once 'src/controller/transactions.php';
require_once 'src/controller/users.php';
require_once 'src/controller/sponsorships.php';
require_once 'src/controller/profile.php';
require_once 'src/controller/notifications.php';

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

        case 'sponsorships':
            sponsorshipsPage();
            break;

        case 'users':
            usersPage();
            break;

        case 'profile':
            profilePage();
            break;

        case 'notifications':
            notificationsPage();
            break;

        case 'loginPage':
            loginPage();
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
