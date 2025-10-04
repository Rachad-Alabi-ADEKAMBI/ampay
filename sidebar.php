<aside :class="['sidebar fixed md:static w-64 bg-white dark:bg-gray-800 shadow-lg h-screen flex flex-col justify-between overflow-y-auto z-40', sidebarOpen ? 'open' : '']">
    <div class="p-6">
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

        <?php $currentPage = basename($_SERVER['PHP_SELF']); ?>

        <nav class="space-y-2 flex-1">
            <?php
            $links = [
                'index.php' => ['Accueil', 'fas fa-home'],
                'marketplace.php' => ['Marketplace', 'fas fa-store'],
                'profile.php' => ['Profil', 'fas fa-user'],
                'transactions.php' => ['Transactions', 'fas fa-exchange-alt'],
                'dashboard.php' => ['Admin', 'fas fa-user-shield'],
                'users.php' => ['Utilisateurs', 'fas fa-users'],
                'sponsorships.php' => ['Parrainages', 'fas fa-hand-holding-usd']
            ];

            foreach ($links as $file => $data) {
                $title = $data[0];
                $icon = $data[1];
                $activeClass = ($currentPage == $file) ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700';
                echo "<a href='$file' class='flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors $activeClass'>
                        <i class='$icon'></i>
                        <span>$title</span>
                      </a>";
            }
            ?>
        </nav>
    </div>

    <div class="p-6">
        <a href="logout.php" class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>