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
                  <p class="text-gray-400 leading-relaxed">Transferts d'argent sans intermédiaire entre l'Afrique et l'Europe.</p>
              </div>
              <div>
                  <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                  <ul class="space-y-2">
                      <li><a href="index.php" class="text-gray-400 hover:text-primary transition-colors">Accueil</a></li>
                      <li><a href="index.php?action=marketplace" class="text-gray-400 hover:text-primary transition-colors">Marketplace</a></li>
                      <li><a href="index.php?action=terms" class="text-gray-400 hover:text-primary transition-colors">Conditions générales d'utilisation</a></li>
                      <li><a href="index.php?action=policy" class="text-gray-400 hover:text-primary transition-colors">Politique de confidentialité</a></li>
                  </ul>
              </div>
              <div>
                  <h4 class="text-lg font-semibold mb-4">Support</h4>
                  <ul class="space-y-2">
                      <li><a href="index.php#faq" class="text-gray-400 hover:text-primary transition-colors">FAQ</a></li>
                      <li><a href="index.php#about" class="text-gray-400 hover:text-primary transition-colors">À propos</a></li>
                      <li><a href="index.php#contact" class="text-gray-400 hover:text-primary transition-colors">Contact</a></li>

                      <?php if (isset($_SESSION['user'])): ?>
                          <li>
                              <a href="index.php?action=dashboard" class="text-gray-400 hover:text-primary transition-colors">
                                  Tableau de bord
                              </a>
                          </li>
                          <li>
                              <a href="index.php?action=logout" class="text-gray-400 hover:text-primary transition-colors">
                                  Déconnexion
                              </a>
                          </li>
                      <?php else: ?>
                          <li>
                              <a href="index.php?action=loginPage" class="text-gray-400 hover:text-primary transition-colors">
                                  Connexion
                              </a>
                          </li>
                      <?php endif; ?>
                  </ul>

              </div>
              <div>
                  <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
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
              <p>&copy; 2025 AMPAY. Tous droits réservés. </p>
          </div>
      </div>
  </footer>