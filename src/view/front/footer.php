<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-10 h-10 primary-gradient rounded-lg flex items-center justify-center">
                        <i class="fas fa-bolt text-white"></i>
                    </div>
                    <span class="text-2xl font-bold">AMPAY</span>
                </div>
                <!-- Using translation variable instead of hardcoded text -->
                <p class="text-gray-400 leading-relaxed">{{ t.footer_description }}</p>
            </div>
            <div>
                <!-- Using translation variables for all footer links -->
                <h4 class="text-lg font-semibold mb-4">{{ t.footer_quick_links }}</h4>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-primary transition-colors">{{ t.nav_home }}</a></li>
                    <li><a href="index.php?action=marketplace" class="text-gray-400 hover:text-primary transition-colors">{{ t.nav_marketplace }}</a></li>
                    <li><a href="index.php?action=termsPage" class="text-gray-400 hover:text-primary transition-colors">{{ t.footer_terms }}</a></li>
                    <li><a href="index.php?action=policyPage" class="text-gray-400 hover:text-primary transition-colors">{{ t.footer_privacy }}</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">{{ t.footer_support }}</h4>
                <ul class="space-y-2">
                    <li><a href="index.php#faq" class="text-gray-400 hover:text-primary transition-colors">{{ t.footer_faq }}</a></li>
                    <li><a href="index.php#about" class="text-gray-400 hover:text-primary transition-colors">{{ t.footer_about }}</a></li>
                    <li><a href="index.php#contact" class="text-gray-400 hover:text-primary transition-colors">{{ t.footer_contact }}</a></li>

                    <?php if (isset($_SESSION['user'])): ?>
                        <li>
                            <a href="index.php?action=dashboardPage" class="text-gray-400 hover:text-primary transition-colors">
                                {{ t.nav_dashboard }}
                            </a>
                        </li>
                        <li>
                            <a href="index.php?action=logout" class="text-gray-400 hover:text-primary transition-colors">
                                {{ t.nav_logout }}
                            </a>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="index.php?action=loginPage" class="text-gray-400 hover:text-primary transition-colors">
                                {{ t.nav_login }}
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

            </div>
            <div>
                <h4 class="text-lg font-semibold mb-4">{{ t.footer_follow_us }}</h4>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
            <!-- Using translation variable for copyright text -->
            <p>{{ t.footer_copyright }} <br>
                Built with Blood, Sweat and Tears by
                <a href="https://rachad-alabi-adekambi.github.io/portfolio/#/"><strong
                        style="color:  #10B981; ">CC</strong></a>
            </p>
        </div>
    </div>
</footer>