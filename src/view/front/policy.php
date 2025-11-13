<?php $title = "AmPay - Politique de confidentialité";

ob_start();

$isAuthenticated = isset($_SESSION['id']);
?>
<script>
    window.isAuthenticated = <?php echo json_encode($isAuthenticated); ?>;
    window.user_id = <?php echo $_SESSION['id'] ?? 'null'; ?>;
</script>

<div id="app" v-cloak>
    <?php include 'header.php'; ?>

    <section class="parallax hero-gradient pt-32 pb-20" style="background-image: url('https://images.unsplash.com/photo-1516321318423-f06f70d504f0?w=1920&h=1080&fit=crop');">
        <div class="parallax-content container mx-auto px-4 sm:px-6">
            <div class="max-w-4xl fade-in-up">
                <div class="inline-block px-4 py-2 bg-primary/20 backdrop-blur-sm rounded-full text-primary-light border border-primary/30 mb-6">
                    <i class="fas fa-shield-alt mr-2"></i>
                    <span class="font-semibold text-white">{{ t.header_badge }}</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">
                    {{ t.page_title }}
                </h1>
                <p class="text-xl text-gray-300 leading-relaxed">
                    {{ t.page_subtitle }}
                </p>
                <div class="mt-8 text-gray-400 text-sm">
                    <i class="fas fa-calendar mr-2"></i>{{ t.effective_date }} 01/11/2025
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
            <!-- Table of contents -->
            <div class="mb-16 bg-blue-50 rounded-2xl p-8 fade-in-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-list-check text-primary mr-3"></i>{{ t.table_of_contents }}
                </h2>
                <nav class="space-y-3">
                    <a href="#section-1" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_1_title }}
                    </a>
                    <a href="#section-2" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_2_title }}
                    </a>
                    <a href="#section-3" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_3_title }}
                    </a>
                    <a href="#section-4" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_4_title }}
                    </a>
                    <a href="#section-5" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_5_title }}
                    </a>
                    <a href="#section-6" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_6_title }}
                    </a>
                    <a href="#section-7" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_7_title }}
                    </a>
                    <a href="#section-8" class="flex items-center text-primary hover:text-primary-dark transition-colors">
                        <i class="fas fa-chevron-right mr-2"></i>{{ t.section_8_title }}
                    </a>
                </nav>
            </div>

            <!-- Content sections -->
            <div class="space-y-12">
                <!-- Section 1 -->
                <div id="section-1" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_1_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_1_intro }}</p>
                        <ul class="space-y-3 list-none">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span><strong>{{ t.section_1_item_1_title }} :</strong> {{ t.section_1_item_1_content }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span><strong>{{ t.section_1_item_2_title }} :</strong> {{ t.section_1_item_2_content }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span><strong>{{ t.section_1_item_3_title }} :</strong> {{ t.section_1_item_3_content }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Section 2 -->
                <div id="section-2" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_2_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_2_intro }}</p>
                        <ul class="space-y-3 list-none">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_2_item_1 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_2_item_2 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_2_item_3 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_2_item_4 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Section 3 -->
                <div id="section-3" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_3_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_3_intro }}</p>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                            <p class="font-semibold text-yellow-800 mb-2">{{ t.section_3_highlight }}</p>
                            <p>{{ t.section_3_highlight_content }}</p>
                        </div>
                        <p>{{ t.section_3_additional }}</p>
                        <ul class="space-y-2 list-none">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-arrow-right text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_3_item_1 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-arrow-right text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_3_item_2 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Section 4 -->
                <div id="section-4" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_4_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_4_intro }}</p>
                        <ul class="space-y-3 list-none">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-shield-alt text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_4_item_1 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-lock text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_4_item_2 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-user-check text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_4_item_3 }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Section 5 -->
                <div id="section-5" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">5</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_5_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_5_intro }}</p>
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="font-bold text-blue-900 mb-3">{{ t.section_5_rights_title }}</h4>
                            <ul class="space-y-3 list-none">
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-primary mt-1 flex-shrink-0"></i>
                                    <span>{{ t.section_5_right_1 }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-primary mt-1 flex-shrink-0"></i>
                                    <span>{{ t.section_5_right_2 }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-primary mt-1 flex-shrink-0"></i>
                                    <span>{{ t.section_5_right_3 }}</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class="fas fa-check-circle text-primary mt-1 flex-shrink-0"></i>
                                    <span>{{ t.section_5_right_4 }}</span>
                                </li>
                            </ul>
                        </div>
                        <p class="pt-4">
                            <strong>{{ t.section_5_exercise_rights }} :</strong> <a href="mailto:contact@ampay.com" class="text-primary hover:text-primary-dark font-semibold">contact@ampay.com</a>
                        </p>
                    </div>
                </div>

                <!-- Section 6 -->
                <div id="section-6" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">6</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_6_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_6_intro }}</p>
                        <ul class="space-y-3 list-none">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-cookie text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_6_item_1 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-bar-chart text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_6_item_2 }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-palette text-primary mt-1 flex-shrink-0"></i>
                                <span>{{ t.section_6_item_3 }}</span>
                            </li>
                        </ul>
                        <div class="bg-orange-50 border-l-4 border-orange-400 p-4 rounded mt-4">
                            <p class="text-orange-800">{{ t.section_6_note }}</p>
                        </div>
                    </div>
                </div>

                <!-- Section 7 -->
                <div id="section-7" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">7</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_7_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-4 text-gray-700 leading-relaxed">
                        <p>{{ t.section_7_content }}</p>
                    </div>
                </div>

                <!-- Section 8 -->
                <div id="section-8" class="fade-in-up">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center flex-shrink-0 font-bold">8</div>
                        <div>
                            <h3 class="text-3xl font-bold text-gray-900">{{ t.section_8_title }}</h3>
                        </div>
                    </div>
                    <div class="ml-16 space-y-6 text-gray-700 leading-relaxed">
                        <p>{{ t.section_8_intro }}</p>
                        <div class="bg-gray-100 rounded-xl p-6 space-y-2">
                            <p class="flex items-center gap-2">
                                <i class="fas fa-envelope text-primary"></i>
                                <strong>{{ t.section_8_email }} :</strong> <a href="mailto:contact@ampay.com" class="text-primary hover:text-primary-dark">contact@ampay.com</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer CTA -->
            <div class="mt-20 p-8 bg-gradient-to-br from-primary/10 to-primary/5 rounded-2xl text-center fade-in-up">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ t.footer_cta_title }}</h3>
                <p class="text-gray-700 mb-6">{{ t.footer_cta_content }}</p>
                <a href="index.php?action=termsPage" class="inline-block px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    <i class="fas fa-file-contract mr-2"></i>{{ t.footer_cta_button }}
                </a>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
</div>

<script>
    const {
        createApp
    } = Vue;

    createApp({
        data() {
            return {
                darkMode: false,
                currentLang: 'fr',
                translations: {
                    fr: {
                        nav_home: 'Accueil',
                        nav_marketplace: 'Marketplace',
                        nav_dashboard: 'Tableau de bord',
                        nav_logout: 'Déconnexion',
                        nav_login: 'Connexion',
                        footer_description: 'Transferts d\'argent sans intermédiaire entre l\'Afrique et l\'Europe.',
                        footer_quick_links: 'Liens rapides',
                        footer_terms: 'Conditions générales d\'utilisation',
                        footer_privacy: 'Politique de confidentialité',
                        footer_support: 'Support',
                        footer_faq: 'FAQ',
                        footer_about: 'À propos',
                        footer_contact: 'Contact',
                        footer_follow_us: 'Suivez-nous',
                        footer_copyright: '© 2025 AMPAY. Tous droits réservés.',
                        header_badge: 'Protection de vos données personnelles',
                        page_title: 'Politique de Confidentialité',
                        page_subtitle: 'Chez Ampay, votre confidentialité est notre priorité absolue. Découvrez comment nous collectons, utilisons et protégeons vos données personnelles.',
                        effective_date: 'Effectif depuis le',
                        table_of_contents: 'Table des matières',
                        section_1_title: 'Collecte des informations',
                        section_2_title: 'Utilisation des informations',
                        section_3_title: 'Partage des informations',
                        section_4_title: 'Sécurité des données',
                        section_5_title: 'Vos droits',
                        section_6_title: 'Cookies et technologies similaires',
                        section_7_title: 'Modifications de la politique',
                        section_8_title: 'Contact',

                        section_1_intro: 'Nous collectons des informations lorsque vous utilisez notre plateforme, notamment :',
                        section_1_item_1_title: 'Informations personnelles',
                        section_1_item_1_content: 'nom, prénom, adresse e-mail, numéro de téléphone, informations de compte.',
                        section_1_item_2_title: 'Informations financières',
                        section_1_item_2_content: 'devises détenues, historique de transactions, commissions payées.',
                        section_1_item_3_title: 'Données techniques',
                        section_1_item_3_content: 'adresse IP, type de navigateur, données de connexion et activité sur le site.',

                        section_2_intro: 'Les informations collectées sont utilisées pour :',
                        section_2_item_1: 'Faciliter les transactions entre utilisateurs',
                        section_2_item_2: 'Assurer la sécurité et l\'intégrité de la plateforme',
                        section_2_item_3: 'Communiquer avec les utilisateurs pour le support et les notifications importantes',
                        section_2_item_4: 'Respecter les obligations légales et prévenir la fraude',

                        section_3_intro: 'Ampay respecte votre confidentialité en limitant le partage de vos données. Cependant, nous devons parfois partager vos informations avec des tiers de confiance pour assurer le bon fonctionnement de notre plateforme.',
                        section_3_highlight: 'Important',
                        section_3_highlight_content: 'Nous ne vendons ni ne louons vos données personnelles à des tiers.',
                        section_3_additional: 'Nous pouvons partager vos informations avec :',
                        section_3_item_1: 'Nos prestataires techniques ou partenaires pour assurer le fonctionnement de la plateforme',
                        section_3_item_2: 'Les autorités compétentes si la loi l\'exige',

                        section_4_intro: 'Nous mettons en place des mesures techniques et organisationnelles pour protéger vos données contre la perte, le vol ou l\'accès non autorisé :',
                        section_4_item_1: 'Authentification sécurisée pour les comptes',
                        section_4_item_2: 'Chiffrement des données sensibles',
                        section_4_item_3: 'Contrôle d\'accès interne strict',

                        section_5_intro: 'Conformément à la législation sur la protection des données, vous disposez de droits importants concernant vos informations personnelles. Ampay s\'engage à respecter ces droits et à faciliter leur exercice.',
                        section_5_rights_title: 'Vos droits concernant vos données :',
                        section_5_right_1: 'Accéder à vos données et obtenir une copie',
                        section_5_right_2: 'Demander la correction ou la suppression de vos informations',
                        section_5_right_3: 'Vous opposer à l\'utilisation de vos données à des fins commerciales',
                        section_5_right_4: 'Retirer votre consentement à tout moment',
                        section_5_exercise_rights: 'Pour exercer vos droits, contactez-nous',

                        section_6_intro: 'Ampay utilise des cookies et des technologies similaires pour améliorer votre expérience utilisateur et analyser comment vous interagissez avec notre plateforme.',
                        section_6_item_1: 'Améliorer l\'expérience utilisateur et mémoriser vos préférences',
                        section_6_item_2: 'Analyser l\'utilisation de la plateforme',
                        section_6_item_3: 'Personnaliser le contenu et les communications',
                        section_6_note: 'Vous pouvez désactiver les cookies via les paramètres de votre navigateur, mais certaines fonctionnalités du site pourraient ne plus fonctionner correctement.',

                        section_7_content: 'Ampay peut modifier cette politique de confidentialité à tout moment. Les utilisateurs seront informés des changements et la date de mise à jour sera modifiée en conséquence. Nous vous recommandons de consulter régulièrement cette page pour rester informé des éventuelles modifications.',

                        section_8_intro: 'Si vous avez des questions concernant cette politique de confidentialité ou souhaitez exercer vos droits, n\'hésitez pas à nous contacter. Nous répondrons à votre demande dans les meilleurs délais.',
                        section_8_email: 'Email',

                        footer_cta_title: 'Questions concernant votre confidentialité ?',
                        footer_cta_content: 'Consultez également nos conditions générales d\'utilisation pour comprendre l\'ensemble de nos politiques.',
                        footer_cta_button: 'Lire les conditions générales'
                    },
                    en: {
                        nav_home: 'Home',
                        nav_marketplace: 'Marketplace',
                        nav_dashboard: 'Dashboard',
                        nav_logout: 'Logout',
                        nav_login: 'Login',
                        footer_description: 'Money transfers without intermediaries between Africa and Europe.',
                        footer_quick_links: 'Quick Links',
                        footer_terms: 'Terms of Service',
                        footer_privacy: 'Privacy Policy',
                        footer_support: 'Support',
                        footer_faq: 'FAQ',
                        footer_about: 'About',
                        footer_contact: 'Contact',
                        footer_follow_us: 'Follow Us',
                        footer_copyright: '© 2025 AMPAY. All rights reserved.',
                        header_badge: 'Protection of your personal data',
                        page_title: 'Privacy Policy',
                        page_subtitle: 'At Ampay, your privacy is our top priority. Discover how we collect, use and protect your personal data.',
                        effective_date: 'Effective from',
                        table_of_contents: 'Table of Contents',
                        section_1_title: 'Information Collection',
                        section_2_title: 'Information Usage',
                        section_3_title: 'Information Sharing',
                        section_4_title: 'Data Security',
                        section_5_title: 'Your Rights',
                        section_6_title: 'Cookies and Similar Technologies',
                        section_7_title: 'Policy Modifications',
                        section_8_title: 'Contact',

                        section_1_intro: 'We collect information when you use our platform, including:',
                        section_1_item_1_title: 'Personal Information',
                        section_1_item_1_content: 'first name, last name, email address, phone number, account information.',
                        section_1_item_2_title: 'Financial Information',
                        section_1_item_2_content: 'currencies held, transaction history, commissions paid.',
                        section_1_item_3_title: 'Technical Data',
                        section_1_item_3_content: 'IP address, browser type, login data and website activity.',

                        section_2_intro: 'The information collected is used for:',
                        section_2_item_1: 'Facilitate transactions between users',
                        section_2_item_2: 'Ensure the security and integrity of the platform',
                        section_2_item_3: 'Communicate with users for support and important notifications',
                        section_2_item_4: 'Comply with legal obligations and prevent fraud',

                        section_3_intro: 'Ampay respects your privacy by limiting data sharing. However, we sometimes need to share your information with trusted third parties to ensure our platform operates properly.',
                        section_3_highlight: 'Important',
                        section_3_highlight_content: 'We do not sell or rent your personal data to third parties.',
                        section_3_additional: 'We may share your information with:',
                        section_3_item_1: 'Our technical providers or partners to ensure platform operation',
                        section_3_item_2: 'Competent authorities if required by law',

                        section_4_intro: 'We implement technical and organizational measures to protect your data against loss, theft or unauthorized access:',
                        section_4_item_1: 'Secure authentication for accounts',
                        section_4_item_2: 'Encryption of sensitive data',
                        section_4_item_3: 'Strict internal access control',

                        section_5_intro: 'Under data protection laws, you have important rights regarding your personal information. Ampay is committed to respecting these rights and facilitating their exercise.',
                        section_5_rights_title: 'Your rights concerning your data:',
                        section_5_right_1: 'Access your data and obtain a copy',
                        section_5_right_2: 'Request correction or deletion of your information',
                        section_5_right_3: 'Object to the use of your data for commercial purposes',
                        section_5_right_4: 'Withdraw your consent at any time',
                        section_5_exercise_rights: 'To exercise your rights, please contact us',

                        section_6_intro: 'Ampay uses cookies and similar technologies to improve your user experience and analyze how you interact with our platform.',
                        section_6_item_1: 'Improve user experience and remember your preferences',
                        section_6_item_2: 'Analyze platform usage',
                        section_6_item_3: 'Personalize content and communications',
                        section_6_note: 'You can disable cookies through your browser settings, but some site features may not work properly.',

                        section_7_content: 'Ampay may modify this privacy policy at any time. Users will be informed of changes and the update date will be modified accordingly. We recommend checking this page regularly to stay informed of any modifications.',

                        section_8_intro: 'If you have questions about this privacy policy or wish to exercise your rights, please don\'t hesitate to contact us. We will respond to your request as soon as possible.',
                        section_8_email: 'Email',

                        footer_cta_title: 'Questions about your privacy?',
                        footer_cta_content: 'Also check our general terms of use to understand all our policies.',
                        footer_cta_button: 'Read the terms of service'
                    }
                }
            };
        },
        computed: {
            t() {
                return this.translations[this.currentLang];
            }
        },
        mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            const savedLang = localStorage.getItem('language');
            if (savedLang) {
                this.currentLang = savedLang;
            }

            // Intersection Observer for fade-in animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-up').forEach(el => {
                el.style.opacity = '0';
                observer.observe(el);
            });
        },
        methods: {
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            toggleLanguage() {
                this.currentLang = this.currentLang === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLang);
            }
        }
    }).mount('#app');
</script>

<style>
    :root {
        --primary: #10B981;
        --primary-dark: #059669;
        --bg-light: #FFFFFF;
        --bg-dark: #0F172A;
        --bg-dark-secondary: #1E293B;
        --text-light: #111827;
        --text-dark: #F9FAFB;
        --text-dark-secondary: #94A3B8;
    }

    body.dark-mode {
        background-color: var(--bg-dark);
        color: var(--text-dark);
    }

    .dark-mode .bg-white {
        background-color: var(--bg-dark-secondary) !important;
    }

    .dark-mode .bg-blue-50 {
        background-color: var(--bg-dark-secondary) !important;
        border-color: #334155 !important;
    }

    .dark-mode .bg-yellow-50,
    .dark-mode .bg-orange-50,
    .dark-mode .bg-gray-100 {
        background-color: var(--bg-dark-secondary) !important;
    }

    .dark-mode .text-gray-900 {
        color: var(--text-dark) !important;
    }

    .dark-mode .text-gray-700 {
        color: var(--text-dark-secondary) !important;
    }

    .dark-mode .text-yellow-800,
    .dark-mode .text-orange-800,
    .dark-mode .text-blue-900 {
        color: var(--text-dark) !important;
    }

    .dark-mode .border-l-4 {
        border-color: var(--primary) !important;
    }

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    .hero-gradient {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
    }

    .parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }

    .parallax::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.85);
    }

    .parallax-content {
        position: relative;
        z-index: 1;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    a {
        color: var(--primary);
    }

    a:hover {
        color: var(--primary-dark);
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>