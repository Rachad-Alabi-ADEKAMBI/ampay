<?php $title = "AmPay - Mes Parrainages"; ?>

<?php
ob_start(); ?>

<div id="app">
    <!-- Overlay pour le sidebar en mobile -->
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden overflow-x-hidden">
        <?php include __DIR__ . '/../sidebar.php'; ?>

        <div class="flex-1 flex flex-col h-screen overflow-hidden md:ml-64">
            <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print flex-shrink-0">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <!-- Utilisation de la traduction pour le titre -->
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">{{ t.page_title }}</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Ajout du bouton de changement de langue -->
                            <button @click="toggleLanguage" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ currentLanguage === 'fr' ? 'FR' : 'EN' }}</span>
                            </button>
                            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                <div class="px-4 sm:px-6 pb-2 pt-4">
                    <!-- Utilisation de la traduction pour le message de bienvenue -->
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center mb-6">
                        {{ t.welcome }}
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                            {{ capitalizeFirstLetter(user_first_name) }} {{ capitalizeAll(user_last_name) }}
                        </span>
                    </div>

                    <!-- Section de parrainage avec traductions -->
                    <div class="mb-8 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-xl p-8 text-white">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-3xl font-bold mb-2">{{ t.invite_friends }}</h2>
                                <p class="text-emerald-100">{{ t.invite_subtitle }}</p>
                            </div>
                            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                                <i class="fas fa-gift text-4xl"></i>
                            </div>
                        </div>

                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 mb-6">
                            <label class="block text-sm font-medium mb-3">{{ t.referral_link }}</label>
                            <div class="flex gap-3">
                                <input :value="referralLink" readonly class="flex-1 px-4 py-3 bg-white text-gray-900 rounded-lg font-mono text-sm">
                                <button @click="copyLink" class="px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                                    <i class="fas fa-copy mr-2"></i>{{ copied ? t.copied : t.copy }}
                                </button>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm font-medium mb-3">{{ t.share_on }}</p>
                            <div class="flex flex-wrap gap-3">
                                <button @click="shareOnWhatsApp" class="flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 rounded-lg font-semibold transition-colors">
                                    <i class="fab fa-whatsapp text-xl"></i>
                                    WhatsApp
                                </button>
                                <button @click="shareOnFacebook" class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition-colors">
                                    <i class="fab fa-facebook text-xl"></i>
                                    Facebook
                                </button>
                                <button @click="shareOnTwitter" class="flex items-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-600 rounded-lg font-semibold transition-colors">
                                    <i class="fab fa-twitter text-xl"></i>
                                    Twitter
                                </button>
                                <button @click="shareByEmail" class="flex items-center gap-2 px-6 py-3 bg-gray-700 hover:bg-gray-800 rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-envelope text-xl"></i>
                                    Email
                                </button>
                                <button @click="shareOnLinkedIn" class="flex items-center gap-2 px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg font-semibold transition-colors">
                                    <i class="fab fa-linkedin text-xl"></i>
                                    LinkedIn
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques avec traductions -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-friends text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ mySponsorships.length }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.my_sponsorships }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ activeSponsored }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.active_sponsored }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-trophy text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ totalRewards }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.reward_points }}</div>
                        </div>
                    </div>

                    <!-- Filtres avec traductions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="relative">
                                <input v-model="searchQuery" type="text" :placeholder="t.search_placeholder" class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>

                            <select v-model="statusFilter" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="all">{{ t.all_statuses }}</option>
                                <option value="Actif">{{ t.active }}</option>
                                <option value="Inactif">{{ t.inactive }}</option>
                            </select>

                            <select v-model="sortBy" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="date-desc">{{ t.most_recent }}</option>
                                <option value="date-asc">{{ t.oldest }}</option>
                                <option value="name-asc">{{ t.name_asc }}</option>
                                <option value="name-desc">{{ t.name_desc }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tableau avec traductions -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <i class="fas fa-list mr-2 text-primary"></i>{{ t.my_godchildren }}
                            </h3>
                        </div>

                        <div v-if="filteredSponsorships.length === 0" class="text-center py-16">
                            <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ mySponsorships.length === 0 ? t.no_godchildren : t.no_results }}
                            </h4>
                            <p class="text-gray-600 dark:text-gray-400">
                                {{ mySponsorships.length === 0 ? t.share_link_prompt : t.modify_search }}
                            </p>
                        </div>

                        <div v-else class="overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead class="bg-gray-50 dark:bg-gray-700 hidden md:table-header-group">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t.godchild }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t.email }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t.registration_date }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t.status }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ t.reward }}</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr
                                        v-for="sponsorship in paginatedSponsorships"
                                        :key="sponsorship.id"
                                        class="block md:table-row hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-b md:border-0">
                                        <td :data-label="t.godchild" class="block md:table-cell px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ sponsorship.sponsored_first_name }} {{ sponsorship.sponsored_last_name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td :data-label="t.email" class="block md:table-cell px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ sponsorship.sponsored_email }}</div>
                                        </td>

                                        <td :data-label="t.registration_date" class="block md:table-cell px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                <i class="fas fa-calendar mr-1"></i>{{ formatDate(sponsorship.created_at) }}
                                            </div>
                                        </td>

                                        <td :data-label="t.status" class="block md:table-cell px-6 py-4 whitespace-nowrap">
                                            <span
                                                :class="sponsorship.status === 'Actif'
                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                        : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'"
                                                class="px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ sponsorship.status === 'Actif' ? t.active : t.inactive }}
                                            </span>
                                        </td>

                                        <td :data-label="t.reward" class="block md:table-cell px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-sm font-semibold text-yellow-600 dark:text-yellow-400">
                                                <i class="fas fa-trophy mr-1"></i>
                                                100 {{ t.pts }}
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination avec traductions -->
                        <div v-if="filteredSponsorships.length > 0" class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                {{ t.showing }} {{ startIndex + 1 }}-{{ endIndex }} {{ t.on }} {{ filteredSponsorships.length }} {{ t.godchildren_count }}
                            </div>
                            <nav class="inline-flex rounded-lg shadow-sm">
                                <button @click="currentPage--" :disabled="currentPage === 1"
                                    class="relative inline-flex items-center px-4 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button v-for="page in visiblePages" :key="page" @click="currentPage = page"
                                    :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium', 
                                                        currentPage === page ? 'z-10 primary-gradient border-primary text-white' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700']">
                                    {{ page }}
                                </button>
                                <button @click="currentPage++" :disabled="currentPage === totalPages"
                                    class="relative inline-flex items-center px-4 py-2 rounded-r-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const {
        createApp
    } = Vue;
    const api = axios.create({
        baseURL: 'index.php'
    });

    createApp({
        data() {
            return {
                darkMode: false,
                sidebarOpen: false,
                mySponsorships: [],
                copied: false,
                userId: <?= json_encode($_SESSION['id'] ?? ''); ?>,
                user_first_name: <?= json_encode($_SESSION['first_name'] ?? ''); ?>,
                user_last_name: <?= json_encode($_SESSION['last_name'] ?? ''); ?>,
                user_referral_link: 'https://am-pay.xo.je?action=registerPage&ref=' + <?= json_encode($_SESSION['referral_link'] ?? ''); ?>,
                searchQuery: '',
                statusFilter: 'all',
                sortBy: 'date-desc',
                currentPage: 1,
                itemsPerPage: 10,
                currentLanguage: 'fr',
                translations: {
                    fr: {
                        page_title: 'Mes Parrainages',
                        welcome: 'Bonjour',
                        invite_friends: 'Parrainez vos amis!',
                        invite_subtitle: 'Gagnez des récompenses en invitant vos proches',
                        referral_link: 'Votre lien de parrainage',
                        copy: 'Copier',
                        copied: 'Copié!',
                        share_on: 'Partager sur',
                        my_sponsorships: 'Mes Parrainages',
                        active_sponsored: 'Filleuls Actifs',
                        reward_points: 'Points de Récompense',
                        search_placeholder: 'Rechercher par nom ou email...',
                        all_statuses: 'Tous les statuts',
                        active: 'Actif',
                        inactive: 'Inactif',
                        most_recent: 'Plus récent',
                        oldest: 'Plus ancien',
                        name_asc: 'Nom (A-Z)',
                        name_desc: 'Nom (Z-A)',
                        my_godchildren: 'Mes Filleuls',
                        no_godchildren: 'Aucun filleul pour le moment',
                        no_results: 'Aucun résultat trouvé',
                        share_link_prompt: 'Partagez votre lien pour commencer à parrainer',
                        modify_search: 'Essayez de modifier vos critères de recherche',
                        godchild: 'Filleul',
                        email: 'Email',
                        registration_date: 'Date d\'inscription',
                        status: 'Statut',
                        reward: 'Récompense',
                        pts: 'pts',
                        showing: 'Affichage',
                        on: 'sur',
                        godchildren_count: 'filleuls',
                        // Sidebar translations
                        nav_dashboard: 'Tableau de bord',
                        nav_transactions: 'Transactions',
                        nav_sponsorships: 'Parrainages',
                        nav_users: 'Utilisateurs',
                        nav_profile: 'Profil',
                        nav_home: 'Accueil',
                        nav_marketplace: 'Marketplace',
                        nav_my_transactions: 'Mes transactions',
                        nav_my_sponsorships: 'Mes parrainages',
                        nav_logout: 'Déconnexion'
                    },
                    en: {
                        page_title: 'My Sponsorships',
                        welcome: 'Hello',
                        invite_friends: 'Refer your friends!',
                        invite_subtitle: 'Earn rewards by inviting your loved ones',
                        referral_link: 'Your referral link',
                        copy: 'Copy',
                        copied: 'Copied!',
                        share_on: 'Share on',
                        my_sponsorships: 'My Sponsorships',
                        active_sponsored: 'Active Referrals',
                        reward_points: 'Reward Points',
                        search_placeholder: 'Search by name or email...',
                        all_statuses: 'All statuses',
                        active: 'Active',
                        inactive: 'Inactive',
                        most_recent: 'Most recent',
                        oldest: 'Oldest',
                        name_asc: 'Name (A-Z)',
                        name_desc: 'Name (Z-A)',
                        my_godchildren: 'My Referrals',
                        no_godchildren: 'No referrals yet',
                        no_results: 'No results found',
                        share_link_prompt: 'Share your link to start referring',
                        modify_search: 'Try modifying your search criteria',
                        godchild: 'Referral',
                        email: 'Email',
                        registration_date: 'Registration Date',
                        status: 'Status',
                        reward: 'Reward',
                        pts: 'pts',
                        showing: 'Showing',
                        on: 'of',
                        godchildren_count: 'referrals',
                        // Sidebar translations
                        nav_dashboard: 'Dashboard',
                        nav_transactions: 'Transactions',
                        nav_sponsorships: 'Sponsorships',
                        nav_users: 'Users',
                        nav_profile: 'Profile',
                        nav_home: 'Home',
                        nav_marketplace: 'Marketplace',
                        nav_my_transactions: 'My Transactions',
                        nav_my_sponsorships: 'My Sponsorships',
                        nav_logout: 'Logout'
                    }
                }
            };
        },
        computed: {
            t() {
                return this.translations[this.currentLanguage];
            },
            referralLink() {
                return this.user_referral_link;
            },
            activeSponsored() {
                return this.mySponsorships.filter(s => s.status === 'Actif').length;
            },
            totalRewards() {
                return this.mySponsorships.length * 100;
            },
            filteredSponsorships() {
                let filtered = [...this.mySponsorships];

                if (this.searchQuery) {
                    const query = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(s =>
                        s.sponsored_first_name.toLowerCase().includes(query) ||
                        s.sponsored_last_name.toLowerCase().includes(query) ||
                        s.sponsored_email.toLowerCase().includes(query)
                    );
                }

                if (this.statusFilter !== 'all') {
                    filtered = filtered.filter(s => s.status === this.statusFilter);
                }

                filtered.sort((a, b) => {
                    switch (this.sortBy) {
                        case 'date-desc':
                            return new Date(b.created_at) - new Date(a.created_at);
                        case 'date-asc':
                            return new Date(a.created_at) - new Date(b.created_at);
                        case 'name-asc':
                            return (a.sponsored_first_name + a.sponsored_last_name).localeCompare(
                                b.sponsored_first_name + b.sponsored_last_name
                            );
                        case 'name-desc':
                            return (b.sponsored_first_name + b.sponsored_last_name).localeCompare(
                                a.sponsored_first_name + a.sponsored_last_name
                            );
                        default:
                            return 0;
                    }
                });

                return filtered;
            },
            totalPages() {
                return Math.ceil(this.filteredSponsorships.length / this.itemsPerPage);
            },
            paginatedSponsorships() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                return this.filteredSponsorships.slice(start, end);
            },
            startIndex() {
                return (this.currentPage - 1) * this.itemsPerPage;
            },
            endIndex() {
                return Math.min(this.startIndex + this.itemsPerPage, this.filteredSponsorships.length);
            },
            visiblePages() {
                const pages = [];
                const maxVisible = 5;
                let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
                let end = Math.min(this.totalPages, start + maxVisible - 1);

                if (end - start < maxVisible - 1) {
                    start = Math.max(1, end - maxVisible + 1);
                }

                for (let i = start; i <= end; i++) {
                    pages.push(i);
                }
                return pages;
            }
        },
        watch: {
            searchQuery() {
                this.currentPage = 1;
            },
            statusFilter() {
                this.currentPage = 1;
            },
            sortBy() {
                this.currentPage = 1;
            }
        },
        async mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            const savedLanguage = localStorage.getItem('language');
            if (savedLanguage) {
                this.currentLanguage = savedLanguage;
            }

            if (this.userId) {
                await this.fetchMySponsorships();
            }
        },
        methods: {
            async fetchMySponsorships() {
                try {
                    const response = await api.get('?action=mySponsorshipsList');
                    if (response?.data?.success) {
                        this.mySponsorships = response.data.data || [];
                    } else {
                        this.mySponsorships = [];
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.mySponsorships = [];
                }
            },
            capitalizeFirstLetter(word) {
                if (!word) return '';
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            },
            capitalizeAll(word) {
                if (!word) return '';
                return word.toString().toUpperCase();
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            toggleLanguage() {
                this.currentLanguage = this.currentLanguage === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLanguage);
                window.dispatchEvent(new CustomEvent('languageChanged', {
                    detail: this.currentLanguage
                }));
            },
            copyLink() {
                navigator.clipboard.writeText(this.referralLink);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            },
            shareOnWhatsApp() {
                const text = this.currentLanguage === 'fr' ?
                    `Rejoignez AmPay et profitez de transferts d'argent sans frais! Utilisez mon lien: ${this.referralLink}` :
                    `Join AmPay and enjoy free money transfers! Use my link: ${this.referralLink}`;
                window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
            },
            shareOnFacebook() {
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.referralLink)}`, '_blank');
            },
            shareOnTwitter() {
                const text = this.currentLanguage === 'fr' ?
                    `Rejoignez AmPay avec mon lien de parrainage!` :
                    `Join AmPay with my referral link!`;
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(this.referralLink)}`, '_blank');
            },
            shareByEmail() {
                const subject = this.currentLanguage === 'fr' ? 'Rejoignez AmPay!' : 'Join AmPay!';
                const body = this.currentLanguage === 'fr' ?
                    `Bonjour,\n\nJe vous invite à rejoindre AmPay pour des transferts d'argent sans frais.\n\nUtilisez mon lien de parrainage: ${this.referralLink}\n\nÀ bientôt!` :
                    `Hello,\n\nI invite you to join AmPay for free money transfers.\n\nUse my referral link: ${this.referralLink}\n\nSee you soon!`;
                window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            },
            shareOnLinkedIn() {
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(this.referralLink)}`, '_blank');
            },
            formatDate(dateString) {
                const locale = this.currentLanguage === 'fr' ? 'fr-FR' : 'en-US';
                return new Date(dateString).toLocaleDateString(locale, {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            }
        }
    }).mount('#app');
</script>

<style>
    :root {
        --primary: #10B981;
        --bg-dark: #0F172A;
        --bg-dark-secondary: #1E293B;
    }

    body.dark-mode {
        background-color: var(--bg-dark);
        color: #F9FAFB;
    }

    .dark-mode .bg-white {
        background-color: var(--bg-dark-secondary) !important;
    }

    .dark-mode .bg-gray-50 {
        background-color: var(--bg-dark) !important;
    }

    .dark-mode .bg-gray-100 {
        background-color: var(--bg-dark-secondary) !important;
    }

    .dark-mode .text-gray-900 {
        color: #F9FAFB !important;
    }

    .dark-mode .text-gray-700 {
        color: #94A3B8 !important;
    }

    .dark-mode .text-gray-600 {
        color: #94A3B8 !important;
    }

    .dark-mode .text-gray-500 {
        color: #64748B !important;
    }

    .dark-mode .border-gray-200 {
        border-color: #334155 !important;
    }

    .dark-mode .border-gray-300 {
        border-color: #475569 !important;
    }

    .dark-mode .shadow-sm {
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode .shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode input,
    .dark-mode select {
        background-color: var(--bg-dark-secondary) !important;
        color: #F9FAFB !important;
    }

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

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

<style>
    @media (max-width: 768px) {
        table thead {
            display: none;
        }

        table tr {
            display: block;
            margin-bottom: 1rem;
            background-color: var(--bg-dark-secondary);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        td[data-label] {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid rgba(107, 114, 128, 0.2);
        }

        td[data-label]::before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--text-muted, #6b7280);
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        body.dark-mode td[data-label]::before {
            color: #94a3b8;
        }
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>