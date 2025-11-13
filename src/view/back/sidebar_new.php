<!-- Added Vue.js integration for translations -->
<aside :class="['sidebar fixed w-64 bg-white dark:bg-gray-800 shadow-lg h-screen flex flex-col justify-between overflow-y-auto z-40', sidebarOpen ? 'open' : '']">
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

        <!-- Navigation with Vue.js translations -->
        <nav class="space-y-2 flex-1">
            <?php
            // Tableau des liens admin
            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                $links = [
                    'index.php?action=dashboard' => ['nav_dashboard', 'fas fa-user-shield'],
                    'index.php?action=transactionsPage' => ['nav_transactions', 'fas fa-exchange-alt'],
                    'index.php?action=sponsorshipsPage' => ['nav_sponsorships', 'fas fa-hand-holding-usd'],
                    'index.php?action=usersPage' => ['nav_users', 'fas fa-users'],
                    'index.php?action=profilePage' => ['nav_profile', 'fas fa-user'],
                    'index.php?action=home' => ['nav_home', 'fas fa-home'],
                    'index.php?action=marketplace' => ['nav_marketplace', 'fas fa-store'],
                ];
            } else if (isset($_SESSION['role']) && $_SESSION['role'] === 'user') {
                $links = [
                    'index.php?action=dashboard' => ['nav_dashboard', 'fas fa-user-shield'],
                    'index.php?action=myTransactionsPage' => ['nav_my_transactions', 'fas fa-exchange-alt'],
                    'index.php?action=mySponsorshipsPage' => ['nav_my_sponsorships', 'fas fa-users'],
                    'index.php?action=profilePage' => ['nav_profile', 'fas fa-user'],
                    'index.php?action=home' => ['nav_home', 'fas fa-home'],
                    'index.php?action=marketplace' => ['nav_marketplace', 'fas fa-store'],
                ];
            } else {
                $links = [
                    'index.php?action=home' => ['nav_home', 'fas fa-home'],
                    'index.php?action=marketplace' => ['nav_marketplace', 'fas fa-store'],
                ];
            }

            $currentAction = $_GET['action'] ?? 'home';

            foreach ($links as $file => $data) {
                $translationKey = $data[0];
                $icon = $data[1];

                parse_str(parse_url($file, PHP_URL_QUERY), $params);
                $linkAction = $params['action'] ?? 'home';

                $activeClass = ($currentAction == $linkAction)
                    ? 'primary-gradient text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700';

                echo "<a href='$file' class='flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors $activeClass'>
                        <i class='$icon'></i>
                        <span>{{ t.$translationKey }}</span>
                      </a>";
            }
            ?>
        </nav>
    </div>

    <!-- Translated logout button -->
    <div class="p-3">
        <a href="index.php?action=logout" class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
            <i class="fas fa-sign-out-alt mr-2"></i>
            <span>{{ t.nav_logout }}</span>
        </a>
    </div>
</aside>

<style>
    .sidebar {
        transition: transform 0.3s ease;
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 40;
        }

        .sidebar.open {
            transform: translateX(0);
        }
    }
</style>