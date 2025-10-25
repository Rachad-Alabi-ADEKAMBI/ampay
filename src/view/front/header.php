<header class="bg-white dark:bg-dark-secondary shadow-md fixed w-full top-0 z-50 transition-colors duration-300">
    <nav class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <a href="index.php" class="flex items-center slide-in-left">
                <div class="w-10 h-10 primary-gradient rounded-lg flex items-center justify-center">
                    <i class="fas fa-bolt text-white text-xl"></i>
                </div>
                <span class="ml-2 text-2xl font-bold text-gray-900">AMPAY</span>
            </a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-gray-700 hover:text-primary transition-colors font-medium">
                    <i class="fas fa-home mr-1"></i> Accueil
                </a>
                <a href="index.php?action=marketplace" class="text-gray-700 hover:text-primary transition-colors font-medium">
                    <i class="fas fa-store mr-1"></i> Marketplace
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors" title="Toggle dark mode">
                    <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                </button>

                <div class="hidden sm:flex items-center space-x-3">
                    <?php if (isset($_SESSION['id'])): ?>
                        <a href="index.php?action=dashboard" class="px-4 py-2 text-gray-700 hover:text-primary transition-colors font-medium">
                            <i class="fas fa-user-shield mr-1"></i> Tableau de bord
                        </a>

                        <a href="index.php?action=logout" class="px-4 py-2 text-gray-700 hover:text-primary transition-colors font-medium">
                            <i class="fas fa-user-logout mr-1"></i> Déconnexion
                        </a>
                    <?php else: ?>
                        <a href="index.php?action=loginPage" class="px-6 py-2 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                            <i class="fas fa-sign-in-alt mr-1"></i> Connexion
                        </a>
                    <?php endif; ?>
                </div>

                <button @click="toggleMobileMenu" class="md:hidden p-2 text-gray-700 dark:text-gray-300">
                    <i :class="mobileMenuOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
                </button>
            </div>
        </div>

        <div v-if="mobileMenuOpen" class="md:hidden mt-4 pb-4 space-y-3 mobile-menu-enter">
            <a href="index.php" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <i class="fas fa-home mr-2"></i> Accueil
            </a>
            <a href="index.php?action=marketplace" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <i class="fas fa-store mr-2"></i> Marketplace
            </a>

            <?php if (isset($_SESSION['id'])): ?>
                <a href="index.php?action=dashboard" @click="mobileMenuOpen = false" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-user-shield mr-2"></i> Tableau de bord
                </a>
                <a href="index.php?action=logout" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-user-logout mr-1"></i> Déconnexion
                </a>

            <?php else: ?>
                <a href="index.php?action=loginPage" @click="mobileMenuOpen = false" class="block px-4 py-2 primary-gradient text-white rounded-lg font-semibold text-center hover:opacity-90 transition-opacity">
                    <i class="fas fa-sign-in-alt mr-2"></i> Connexion
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>