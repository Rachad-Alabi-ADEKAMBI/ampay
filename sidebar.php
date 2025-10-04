<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar fixed md:static w-64 bg-white dark:bg-gray-800 shadow-lg h-screen overflow-y-auto z-40">
    <div class="p-6">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 primary-gradient rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">AMPAY</span>
            </div>
        </div>

        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'dashboard.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>
            <a href="users.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'users.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-users"></i>
                <span>Utilisateurs</span>
            </a>
            <a href="transactions.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'transactions.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-exchange-alt"></i>
                <span>Transactions</span>
            </a>
            <a href="analytics.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'analytics.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Analytiques</span>
            </a>
            <a href="settings.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'settings.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-cog"></i>
                <span>Paramètres</span>
            </a>
        </nav>

        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
            <a href="index.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'index.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-home"></i>
                <span>Accueil</span>
            </a>
            <a href="marketplace.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'marketplace.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-store"></i>
                <span>Marketplace</span>
            </a>
            <a href="profile.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'profile.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
            <a href="transactions.php" class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors 
                <?php echo $currentPage == 'transactions.php' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700'; ?>">
                <i class="fas fa-exchange-alt"></i>
                <span>Transactions</span>
            </a>
        </div>
    </div>
</aside>