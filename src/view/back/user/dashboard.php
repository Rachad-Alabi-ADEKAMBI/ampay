<?php $title = "AmPay - Mon Tableau de bord"; ?>


<?php
ob_start(); ?>

<div id="app">
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
                            <!-- Added translation for dashboard title -->
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ t.dashboard_title }}
                            </h1>
                        </div>

                        <!-- Added language switcher button next to theme toggle -->
                        <div class="flex items-center space-x-2">
                            <button @click="toggleLanguage" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ currentLang === 'fr' ? 'EN' : 'FR' }}</span>
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
                    <!-- Added translation for welcome message -->
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center">
                        {{ t.welcome }}
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                            {{ capitalizeFirstLetter(user_first_name) }} {{ capitalizeAll(user_last_name) }}
                        </span>
                    </div>
                </div>


                <div class="px-4 sm:px-6 pt-2">
                    <!-- Added translations for all stats cards -->
                    <div class=" grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                                <span v-if="stats.myOffersChange > 0" class="text-xs text-green-600 font-semibold"></span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.myOffers }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.my_offers }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-xl"></i>
                                </div>
                                <span v-if="stats.myRequestsChange > 0" class="text-xs text-green-600 font-semibold"></span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.myRequests }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.my_requests }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-exchange-alt text-xl"></i>
                                </div>
                                <span v-if="stats.myTransactionsChange > 0" class="text-xs text-green-600 font-semibold"></span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.myTransactions }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.my_transactions }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-friends text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.mySponsorships }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.my_sponsorships }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ formatCurrency(stats.totalVolume) }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.total_volume }}</div>
                        </div>
                    </div>

                    <!-- Added translations for chart titles -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 max-w-full overflow-hidden">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ t.monthly_activity }}</h3>
                            <div class="w-full max-w-full">
                                <canvas id="activityChart"></canvas>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 max-w-full overflow-hidden">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">{{ t.offers_requests_distribution }}</h3>
                            <div class="w-full max-w-full">
                                <canvas id="distributionChart"></canvas>
                            </div>
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
                myListings: [],
                mySponsorships: [],
                recentActivities: [],
                userId: <?= json_encode($_SESSION['id'] ?? ''); ?>,
                user_first_name: <?= json_encode($_SESSION['first_name'] ?? ''); ?>,
                user_last_name: <?= json_encode($_SESSION['last_name'] ?? ''); ?>,
                currentLang: 'fr',
                translations: {
                    fr: {
                        dashboard_title: 'Tableau de bord',
                        welcome: 'Bonjour',
                        my_offers: 'Mes Offres',
                        my_requests: 'Mes Demandes',
                        my_transactions: 'Mes Transactions',
                        my_sponsorships: 'Mes Parrainages',
                        total_volume: 'Volume Total',
                        monthly_activity: 'Mon activité mensuelle',
                        offers_requests_distribution: 'Répartition Offres/Demandes',
                        offers: 'Mes Offres',
                        requests: 'Mes Demandes',
                        months: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
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
                        dashboard_title: 'Dashboard',
                        welcome: 'Hello',
                        my_offers: 'My Offers',
                        my_requests: 'My Requests',
                        my_transactions: 'My Transactions',
                        my_sponsorships: 'My Sponsorships',
                        total_volume: 'Total Volume',
                        monthly_activity: 'My Monthly Activity',
                        offers_requests_distribution: 'Offers/Requests Distribution',
                        offers: 'My Offers',
                        requests: 'My Requests',
                        months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
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
            stats() {
                const listings = Array.isArray(this.myListings) ? this.myListings : [];
                const sponsorships = Array.isArray(this.mySponsorships) ? this.mySponsorships : [];

                const myOffers = listings.filter(l => l.type === 'Offre').length;
                const myRequests = listings.filter(l => l.type === 'Demande').length;
                const totalVolume = listings.reduce((sum, l) => sum + parseFloat(l.amount || 0), 0);

                return {
                    myOffers,
                    myRequests,
                    myTransactions: listings.length,
                    mySponsorships: sponsorships.length,
                    totalVolume,
                    myOffersChange: 12,
                    myRequestsChange: 8,
                    myTransactionsChange: 15
                };
            },
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
            if (savedLang && (savedLang === 'fr' || savedLang === 'en')) {
                this.currentLang = savedLang;
            }

            this.userId = <?= isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>;

            if (this.userId) {
                this.fetchMyData();
            }
        },
        methods: {
            async fetchMyData() {
                try {
                    const transactionsResponse = await api.get('index.php?action=myTransactionsList');
                    this.myListings = Array.isArray(transactionsResponse.data.data) ? transactionsResponse.data.data : [];
                    console.log('Transactions:', this.myListings);

                    const sponsorshipsResponse = await api.get('index.php?action=mySponsorshipsList');
                    this.mySponsorships = Array.isArray(sponsorshipsResponse.data.data) ? sponsorshipsResponse.data.data : [];
                    console.log('Sponsorships:', this.mySponsorships);

                    this.recentActivities = this.myListings.slice(0, 5).map(listing => ({
                        id: listing.id,
                        type: listing.type,
                        icon: listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart',
                        title: `${listing.type} #${listing.id} - ${listing.city}, ${listing.country}`,
                        time: this.formatTimeAgo(listing.created_at),
                        amount: parseFloat(listing.amount),
                        currency: listing.currency,
                        status: listing.status || 'Actif'
                    }));

                    this.$nextTick(() => this.initCharts());
                } catch (error) {
                    console.error('Erreur lors du chargement de mes données:', error);
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

            formatTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMs / 3600000);
                const diffDays = Math.floor(diffMs / 86400000);

                if (diffMins < 60) return `Il y a ${diffMins} min`;
                if (diffHours < 24) return `Il y a ${diffHours}h`;
                return `Il y a ${diffDays}j`;
            },

            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },

            toggleLanguage() {
                this.currentLang = this.currentLang === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLang);
                window.dispatchEvent(new CustomEvent('languageChanged', {
                    detail: this.currentLang
                }));
                this.$nextTick(() => this.initCharts());
            },

            initCharts() {
                if (window.activityChartInstance) {
                    window.activityChartInstance.destroy();
                }
                if (window.distributionChartInstance) {
                    window.distributionChartInstance.destroy();
                }

                const activityCtx = document.getElementById('activityChart');
                if (activityCtx) {
                    const monthlyData = this.getMonthlyData();
                    window.activityChartInstance = new Chart(activityCtx, {
                        type: 'line',
                        data: {
                            labels: this.t.months,
                            datasets: [{
                                    label: this.t.offers,
                                    data: monthlyData.offers,
                                    borderColor: '#10B981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    tension: 0.4
                                },
                                {
                                    label: this.t.requests,
                                    data: monthlyData.requests,
                                    borderColor: '#F59E0B',
                                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                                    tension: 0.4
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                }
                            }
                        }
                    });
                }

                const distributionCtx = document.getElementById('distributionChart');
                if (distributionCtx) {
                    window.distributionChartInstance = new Chart(distributionCtx, {
                        type: 'doughnut',
                        data: {
                            labels: [this.t.offers, this.t.requests],
                            datasets: [{
                                data: [this.stats.myOffers, this.stats.myRequests],
                                backgroundColor: ['#10B981', '#F59E0B']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }
                    });
                }
            },

            getMonthlyData() {
                const offers = [0, 0, 0, 0, 0, this.stats.myOffers];
                const requests = [0, 0, 0, 0, 0, this.stats.myRequests];
                return {
                    offers,
                    requests
                };
            },

            formatCurrency(amount) {
                return new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 0
                }).format(amount);
            },

            getStatusClass(status) {
                const statusClasses = {
                    'Active': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                    'En attente': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                    'Terminé': 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
                    'Annulé': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                };
                return statusClasses[status] || statusClasses['Active'];
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

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
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

    @media print {
        .no-print {
            display: none !important;
        }

        body {
            background: white !important;
            color: black !important;
        }

        .bg-white {
            background: white !important;
        }

        .shadow-sm,
        .shadow-md {
            box-shadow: none !important;
        }
    }
</style>

<?php $content = ob_get_clean(); ?>

<?php require './src/view/layout.php'; ?>