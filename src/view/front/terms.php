<?php $title = "AmPay - Conditions Générales";

ob_start();

$isAuthenticated = isset($_SESSION['id']);

?>
<script>
    window.isAuthenticated = <?php echo json_encode($isAuthenticated); ?>;
    window.user_id = <?php echo $_SESSION['id'] ?? 'null'; ?>;
</script>

<div id="app" v-cloak>
    <?php include 'header.php'; ?>

    <!-- Hero Section -->
    <section class="hero-gradient pt-20 pb-12 min-h-fit">
        <div class="container mx-auto px-4 sm:px-6 py-12">
            <div class="text-center text-white fade-in-up">
                <div class="inline-block px-4 py-2 bg-primary/20 backdrop-blur-sm rounded-full text-primary-light border border-primary/30 mb-6">
                    <i class="fas fa-file-contract mr-2"></i>
                    <span class="font-semibold">{{ t.legal_title }}</span>
                </div>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight mb-4">
                    {{ t.cgu_title }}
                </h1>
                <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                    {{ t.effective_date }}: 01/11/2025
                </p>
            </div>
        </div>
    </section>

    <!-- Table of Contents -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
            <div class="bg-gray-50 rounded-xl p-8 fade-in-up">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <i class="fas fa-list mr-3 text-primary"></i>{{ t.table_of_contents }}
                </h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    <a href="#section-1" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">1.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_1_title }}</span>
                    </a>
                    <a href="#section-2" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">2.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_2_title }}</span>
                    </a>
                    <a href="#section-3" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">3.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_3_title }}</span>
                    </a>
                    <a href="#section-4" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">4.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_4_title }}</span>
                    </a>
                    <a href="#section-5" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">5.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_5_title }}</span>
                    </a>
                    <a href="#section-6" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">6.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_6_title }}</span>
                    </a>
                    <a href="#section-7" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">7.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_7_title }}</span>
                    </a>
                    <a href="#section-8" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">8.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_8_title }}</span>
                    </a>
                    <a href="#section-9" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">9.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_9_title }}</span>
                    </a>
                    <a href="#section-10" class="group flex items-start p-3 rounded-lg hover:bg-white transition-colors">
                        <span class="text-primary font-bold mr-3">10.</span>
                        <span class="text-gray-700 group-hover:text-primary transition-colors">{{ t.section_10_title }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CGU Content -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
            <!-- Section 1: Introduction -->
            <div id="section-1" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">1.</span>{{ t.section_1_title }}
                </h2>
                <div class="text-gray-600 space-y-4 leading-relaxed">
                    <p>{{ t.section_1_content_1 }}</p>
                    <p>{{ t.section_1_content_2 }}</p>
                </div>
            </div>

            <!-- Section 2: Definitions -->
            <div id="section-2" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">2.</span>{{ t.section_2_title }}
                </h2>
                <div class="text-gray-600 space-y-3 leading-relaxed">
                    <p><strong>{{ t.def_user }}:</strong> {{ t.def_user_text }}</p>
                    <p><strong>{{ t.def_platform }}:</strong> {{ t.def_platform_text }}</p>
                    <p><strong>{{ t.def_transaction }}:</strong> {{ t.def_transaction_text }}</p>
                    <p><strong>{{ t.def_commission }}:</strong> {{ t.def_commission_text }}</p>
                </div>
            </div>

            <!-- Section 3: Access Conditions -->
            <div id="section-3" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">3.</span>{{ t.section_3_title }}
                </h2>
                <ul class="text-gray-600 space-y-3 leading-relaxed">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_3_item_1 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_3_item_2 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_3_item_3 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Section 4: Transaction Rules -->
            <div id="section-4" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">4.</span>{{ t.section_4_title }}
                </h2>
                <ul class="text-gray-600 space-y-3 leading-relaxed">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_4_item_1 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_4_item_2 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_4_item_3 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_4_item_4 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Section 5: Security and Privacy -->
            <div id="section-5" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">5.</span>{{ t.section_5_title }}
                </h2>
                <ul class="text-gray-600 space-y-3 leading-relaxed">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_5_item_1 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_5_item_2 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_5_item_3 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Section 6: Obligations and Prohibitions -->
            <div id="section-6" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">6.</span>{{ t.section_6_title }}
                </h2>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded mb-4">
                    <p class="text-red-800 font-semibold mb-3">{{ t.section_6_intro }}</p>
                    <ul class="text-red-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-600 mr-3 flex-shrink-0 mt-1"></i>
                            <span>{{ t.section_6_item_1 }}</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-600 mr-3 flex-shrink-0 mt-1"></i>
                            <span>{{ t.section_6_item_2 }}</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-ban text-red-600 mr-3 flex-shrink-0 mt-1"></i>
                            <span>{{ t.section_6_item_3 }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Section 7: Liability -->
            <div id="section-7" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">7.</span>{{ t.section_7_title }}
                </h2>
                <ul class="text-gray-600 space-y-3 leading-relaxed">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_7_item_1 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_7_item_2 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Section 8: Modifications -->
            <div id="section-8" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">8.</span>{{ t.section_8_title }}
                </h2>
                <ul class="text-gray-600 space-y-3 leading-relaxed">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_8_item_1 }}</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-primary mt-1 mr-3 flex-shrink-0"></i>
                        <span>{{ t.section_8_item_2 }}</span>
                    </li>
                </ul>
            </div>

            <!-- Section 9: Applicable Law -->
            <div id="section-9" class="bg-white rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">9.</span>{{ t.section_9_title }}
                </h2>
                <div class="text-gray-600 space-y-3 leading-relaxed">
                    <p>{{ t.section_9_content_1 }}</p>
                    <p>{{ t.section_9_content_2 }}</p>
                </div>
            </div>

            <!-- Section 10: Contact -->
            <div id="section-10" class="bg-primary/10 rounded-xl shadow-md p-8 mb-8 fade-in-up">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 flex items-center">
                    <span class="text-primary mr-3">10.</span>{{ t.section_10_title }}
                </h2>
                <div class="text-gray-600 space-y-3 leading-relaxed">
                    <p>{{ t.section_10_content }}</p>
                    <div class="mt-4 p-4 bg-white rounded-lg border-l-4 border-primary">
                        <p class="text-gray-900 font-semibold">{{ t.contact_email }}</p>
                        <p class="text-primary text-lg font-bold">contact@ampay.com</p>
                    </div>
                </div>
            </div>

            <!-- Acceptance Note -->
            <div class="bg-gray-100 rounded-xl p-8 fade-in-up">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-primary text-2xl mr-4 flex-shrink-0 mt-1"></i>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ t.acceptance_title }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ t.acceptance_text }}</p>
                    </div>
                </div>
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
                        legal_title: 'Documents Juridiques',
                        cgu_title: 'Conditions Générales d\'Utilisation',
                        effective_date: 'Date d\'entrée en vigueur',
                        table_of_contents: 'Table des matières',

                        section_1_title: 'Introduction',
                        section_2_title: 'Définitions',
                        section_3_title: 'Conditions d\'accès',
                        section_4_title: 'Règles de transaction',
                        section_5_title: 'Sécurité et confidentialité',
                        section_6_title: 'Obligations et interdictions',
                        section_7_title: 'Responsabilité',
                        section_8_title: 'Modification des conditions',
                        section_9_title: 'Loi applicable et juridiction',
                        section_10_title: 'Contact',

                        section_1_content_1: 'Bienvenue sur Ampay, une marketplace internationale qui met en relation des utilisateurs possédant des devises physiques (dollars, euros, etc.) et des utilisateurs en ayant besoin. En utilisant notre plateforme, vous acceptez de respecter les présentes Conditions Générales d\'Utilisation (CGU).',
                        section_1_content_2: 'Si vous n\'acceptez pas ces conditions, veuillez ne pas utiliser Ampay.',

                        def_user: 'Utilisateur',
                        def_user_text: 'toute personne utilisant la plateforme, qu\'elle vende ou achète des devises.',
                        def_platform: 'Plateforme / Ampay',
                        def_platform_text: 'la société opérant le site et les services associés.',
                        def_transaction: 'Transaction',
                        def_transaction_text: 'échange de devises entre utilisateurs via la plateforme.',
                        def_commission: 'Commission',
                        def_commission_text: 'frais prélevés par Ampay sur chaque transaction réalisée via la plateforme.',

                        section_3_item_1: 'L\'accès à Ampay est réservé aux personnes âgées de 18 ans et plus.',
                        section_3_item_2: 'Chaque utilisateur doit fournir des informations exactes et véridiques lors de la création de son compte.',
                        section_3_item_3: 'L\'utilisateur est responsable de la confidentialité de ses identifiants et de toute activité effectuée depuis son compte.',

                        section_4_item_1: 'Ampay se limite à mettre en relation les utilisateurs ; la plateforme ne possède pas et ne gère pas directement les devises échangées.',
                        section_4_item_2: 'Les utilisateurs sont entièrement responsables de leurs transactions, notamment en ce qui concerne le respect des lois locales et internationales.',
                        section_4_item_3: 'Une commission est prélevée automatiquement par Ampay sur chaque transaction. Le pourcentage exact est indiqué lors de la transaction.',
                        section_4_item_4: 'En cas de litige entre utilisateurs, Ampay peut intervenir pour faciliter la résolution, mais ne peut garantir l\'issue de la transaction.',

                        section_5_item_1: 'Ampay collecte certaines données personnelles afin de faciliter les transactions et sécuriser la plateforme.',
                        section_5_item_2: 'Les informations collectées sont protégées par des mesures de sécurité adaptées (authentification, chiffrement, etc.).',
                        section_5_item_3: 'Ampay ne peut être tenu responsable en cas de perte ou vol de fonds due à la négligence de l\'utilisateur ou à des fraudes externes.',

                        section_6_intro: 'Il est strictement interdit de :',
                        section_6_item_1: 'Utiliser Ampay pour des activités illégales, incluant le blanchiment d\'argent et la fraude.',
                        section_6_item_2: 'Fournir des informations fausses ou trompeuses, ou usurper l\'identité d\'un autre utilisateur.',
                        section_6_item_3: 'Tenter de contourner les mécanismes de sécurité ou les frais de commission de la plateforme.',

                        section_7_item_1: 'Ampay n\'est pas responsable des pertes financières résultant des transactions entre utilisateurs.',
                        section_7_item_2: 'La responsabilité de la plateforme se limite aux dommages directs causés par une négligence prouvée de sa part.',

                        section_8_item_1: 'Ampay se réserve le droit de modifier ces CGU à tout moment.',
                        section_8_item_2: 'Les utilisateurs seront informés des changements et devront accepter la nouvelle version pour continuer à utiliser la plateforme.',

                        section_9_content_1: 'Les présentes CGU sont régies par la loi béninoise.',
                        section_9_content_2: 'Tout litige relatif à l\'utilisation de la plateforme sera soumis à la juridiction des tribunaux compétents de Cotonou, Bénin.',

                        section_10_content: 'Pour toute question relative aux CGU ou à l\'utilisation d\'Ampay, veuillez nous contacter :',
                        contact_email: 'Email :',

                        acceptance_title: 'Acceptation des conditions',
                        acceptance_text: 'En accédant à la plateforme Ampay, vous reconnaissez avoir lu, compris et accepté sans réserve l\'ensemble de ces Conditions Générales d\'Utilisation. Si vous n\'acceptez pas l\'une quelconque de ces conditions, vous ne devez pas utiliser la plateforme.',
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
                        legal_title: 'Legal Documents',
                        cgu_title: 'Terms of Service',
                        effective_date: 'Effective date',
                        table_of_contents: 'Table of contents',

                        section_1_title: 'Introduction',
                        section_2_title: 'Definitions',
                        section_3_title: 'Access Conditions',
                        section_4_title: 'Transaction Rules',
                        section_5_title: 'Security and Privacy',
                        section_6_title: 'Obligations and Prohibitions',
                        section_7_title: 'Liability',
                        section_8_title: 'Modification of Terms',
                        section_9_title: 'Applicable Law and Jurisdiction',
                        section_10_title: 'Contact',

                        section_1_content_1: 'Welcome to Ampay, an international marketplace that connects users who own physical currencies (dollars, euros, etc.) with those who need them. By using our platform, you agree to comply with these Terms of Service.',
                        section_1_content_2: 'If you do not accept these terms, please do not use Ampay.',

                        def_user: 'User',
                        def_user_text: 'any person using the platform, whether buying or selling currencies.',
                        def_platform: 'Platform / Ampay',
                        def_platform_text: 'the company operating the site and associated services.',
                        def_transaction: 'Transaction',
                        def_transaction_text: 'exchange of currencies between users via the platform.',
                        def_commission: 'Commission',
                        def_commission_text: 'fees charged by Ampay on each transaction made through the platform.',

                        section_3_item_1: 'Access to Ampay is restricted to individuals aged 18 and older.',
                        section_3_item_2: 'Each user must provide accurate and truthful information when creating their account.',
                        section_3_item_3: 'Users are responsible for maintaining the confidentiality of their credentials and all activity from their account.',

                        section_4_item_1: 'Ampay is limited to connecting users; the platform does not directly own or manage the exchanged currencies.',
                        section_4_item_2: 'Users are entirely responsible for their transactions, including compliance with local and international laws.',
                        section_4_item_3: 'A commission is automatically deducted by Ampay from each transaction. The exact percentage is indicated before the transaction.',
                        section_4_item_4: 'In case of disputes between users, Ampay may intervene to facilitate resolution, but cannot guarantee the outcome.',

                        section_5_item_1: 'Ampay collects certain personal data to facilitate transactions and secure the platform.',
                        section_5_item_2: 'Collected information is protected by appropriate security measures (authentication, encryption, etc.).',
                        section_5_item_3: 'Ampay is not liable for loss or theft of funds due to user negligence or external fraud.',

                        section_6_intro: 'It is strictly prohibited to:',
                        section_6_item_1: 'Use Ampay for illegal activities, including money laundering and fraud.',
                        section_6_item_2: 'Provide false or misleading information, or impersonate another user.',
                        section_6_item_3: 'Attempt to circumvent security mechanisms or platform commission fees.',

                        section_7_item_1: 'Ampay is not responsible for financial losses resulting from transactions between users.',
                        section_7_item_2: 'Platform liability is limited to direct damages caused by proven negligence.',

                        section_8_item_1: 'Ampay reserves the right to modify these Terms at any time.',
                        section_8_item_2: 'Users will be notified of changes and must accept the new version to continue using the platform.',

                        section_9_content_1: 'These Terms of Service are governed by the laws of Benin.',
                        section_9_content_2: 'Any disputes relating to the use of the platform will be subject to the jurisdiction of the competent courts of Cotonou, Benin.',

                        section_10_content: 'For any questions regarding these Terms or the use of Ampay, please contact us:',
                        contact_email: 'Email:',

                        acceptance_title: 'Acceptance of Terms',
                        acceptance_text: 'By accessing the Ampay platform, you acknowledge that you have read, understood, and unconditionally accepted all of these Terms of Service. If you do not accept any of these terms, you must not use the platform.',
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

            // Fade-in animations
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
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.8s ease-out, transform 0.8s ease-out';
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
        --accent: #F59E0B;
    }

    body.dark-mode {
        background-color: #0F172A;
        color: #F9FAFB;
    }

    .dark-mode .bg-white {
        background-color: #1E293B !important;
    }

    .dark-mode .bg-gray-50 {
        background-color: #0F172A !important;
    }

    .dark-mode .bg-gray-100 {
        background-color: #1E293B !important;
    }

    .dark-mode .text-gray-900 {
        color: #F9FAFB !important;
    }

    .dark-mode .text-gray-600 {
        color: #94A3B8 !important;
    }

    .dark-mode .border-gray-200 {
        border-color: #334155 !important;
    }

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    .hero-gradient {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
    }

    .dark-mode .hero-gradient {
        background: linear-gradient(135deg, #000000 0%, #0F172A 50%, #1E293B 100%);
    }

    .fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>