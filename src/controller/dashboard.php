<?php

function dashboardPage()
{
    if (!isset($_SESSION['role'])) {
        // Si l'utilisateur n'est pas connecté
        header('Location: index.php?action=login');
        exit;
    }

    if ($_SESSION['role'] === 'admin') {
        require './src/view/back/admin/dashboard_admin.php';
    } else {
        require './src/view/back/user/dashboard.php';
    }
}
