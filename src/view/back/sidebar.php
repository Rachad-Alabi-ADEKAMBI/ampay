<aside :class="['sidebar fixed w-64 bg-white dark:bg-gray-800 shadow-lg h-screen flex flex-col justify-between overflow-y-auto z-40', sidebarOpen ? 'open' : '']">
    <div class="p-6">
        <!-- Logo et titre -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 primary-gradient rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">AMPAY</span>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden text-gray-600 dark:text-gray-300">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="space-y-2 flex-1">
            <?php
            // Tableau des liens
            $links = [
                'index.php?action=home' => ['Accueil', 'fas fa-home'],
                'index.php?action=marketplace' => ['Marketplace', 'fas fa-store'],
                'index.php?action=dashboard' => ['Tableau de bord', 'fas fa-user-shield'],
                'index.php?action=transactions' => ['Transactions', 'fas fa-exchange-alt'],
                'index.php?action=sponsorships' => ['Parrainages', 'fas fa-hand-holding-usd'],
                'index.php?action=users' => ['Utilisateurs', 'fas fa-users'],
                'index.php?action=notifications' => ['Notifications', 'fas fa-bell'],
                'index.php?action=profile' => ['Profil', 'fas fa-user'],
            ];

            // Action courante
            $currentAction = $_GET['action'] ?? 'home';

            foreach ($links as $file => $data) {
                $title = $data[0];
                $icon = $data[1];

                // Extraire l'action du lien
                parse_str(parse_url($file, PHP_URL_QUERY), $params);
                $linkAction = $params['action'] ?? 'home';

                // Classe active
                $activeClass = ($currentAction == $linkAction)
                    ? 'primary-gradient text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700';

                echo "<a href='$file' class='flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors $activeClass'>
                        <i class='$icon'></i>
                        <span>$title</span>
                      </a>";
            }
            ?>
        </nav>
    </div>

    <!-- Déconnexion -->
    <div class="p-3">
        <a href="logout.php" class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>