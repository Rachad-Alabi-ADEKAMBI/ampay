<?php $title = "AmPay - Mon Tableau de bord"; ?>


<?php
ob_start(); ?>

<div id="app">
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <!-- Added overflow-x-hidden to prevent horizontal scroll -->
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
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Tableau de bord
                            </h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Added overflow-x-hidden to content wrapper -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                <div class="px-4 sm:px-6 pb-2 pt-4">
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center">
                        Bonjour
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                            Admin
                        </span>
                    </div>
                </div>

                <div v-if="currentView === 'dashboard'" class="p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                                <span class="text-xs text-green-600 font-semibold">+12%</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.totalUsers }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Utilisateurs</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                                <span class="text-xs text-green-600 font-semibold">+8%</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.activeOffers }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Offres Actives</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-xl"></i>
                                </div>
                                <span class="text-xs text-green-600 font-semibold">+15%</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.activeRequests }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Demandes Actives</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-exchange-alt text-xl"></i>
                                </div>
                                <span class="text-xs text-green-600 font-semibold">+23%</span>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.totalTransactions }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Transactions</div>
                        </div>
                    </div>

                    <!-- Added max-w-full and overflow-hidden to chart containers -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 max-w-full overflow-hidden">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Offres et Demandes par mois</h3>
                            <div class="w-full max-w-full">
                                <canvas id="transactionsChart"></canvas>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 max-w-full overflow-hidden">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Répartition par type</h3>
                            <div class="w-full max-w-full">
                                <canvas id="typeChart"></canvas>
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
                currentView: 'dashboard',
                listings: [],
                users: [],
                recentActivities: [],
            };
        },
        computed: {
            stats() {
                return {
                    totalUsers: this.users.length,
                    activeOffers: this.listings.filter(l => l.type === 'Offre').length,
                    activeRequests: this.listings.filter(l => l.type === 'Demande').length,
                    totalTransactions: this.listings.length
                };
            }
        },
        mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            this.fetchUsers();
            this.fetchListings();
        },
        methods: {
            async fetchUsers() {
                try {
                    const response = await api.get('?action=allUsers');
                    this.users = response.data || [];
                    console.log('Utilisateurs chargés :', this.users);
                } catch (error) {
                    console.error('Erreur lors du chargement des utilisateurs:', error);
                    this.users = [];
                }
            },
            async fetchListings() {
                try {
                    const response = await api.get('?action=allListings');
                    this.listings = response.data || [];
                    this.recentActivities = this.listings.slice(0, 5).map(listing => ({
                        id: listing.id,
                        type: listing.type,
                        icon: listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart',
                        title: `${listing.type} #${listing.id} - ${listing.city}, ${listing.country}`,
                        time: this.formatTimeAgo(listing.created_at),
                        amount: parseFloat(listing.amount),
                        currency: listing.currency
                    }));
                    this.$nextTick(() => this.initCharts());
                } catch (error) {
                    console.error('Erreur lors du chargement des listings:', error);
                }
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
            initCharts() {
                const transactionsCtx = document.getElementById('transactionsChart');
                if (transactionsCtx) {
                    const monthlyData = this.getMonthlyData();
                    new Chart(transactionsCtx, {
                        type: 'line',
                        data: {
                            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                            datasets: [{
                                    label: 'Offres',
                                    data: monthlyData.offers,
                                    borderColor: '#10B981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    tension: 0.4
                                },
                                {
                                    label: 'Demandes',
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

                const typeCtx = document.getElementById('typeChart');
                if (typeCtx) {
                    new Chart(typeCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Offres', 'Demandes'],
                            datasets: [{
                                data: [this.stats.activeOffers, this.stats.activeRequests],
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
                const offers = [12, 18, 25, 32, 38, this.stats.activeOffers];
                const requests = [8, 15, 20, 28, 35, this.stats.activeRequests];
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
            printList() {
                window.print();
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

    .indicator-green {
        width: 12px;
        height: 12px;
        background-color: #10B981;
        border-radius: 50%;
        display: inline-block;
        animation: pulse 2s infinite;
    }

    .indicator-yellow {
        width: 12px;
        height: 12px;
        background-color: #F59E0B;
        border-radius: 50%;
        display: inline-block;
    }

    .indicator-wheel {
        width: 12px;
        height: 12px;
        border: 2px solid #3B82F6;
        border-top-color: transparent;
        border-radius: 50%;
        display: inline-block;
        animation: spin 1s linear infinite;
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

        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }

        thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        tr {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            background: white;
        }

        td {
            border: none;
            position: relative;
            padding-left: 50% !important;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        td:before {
            content: attr(data-label) ": ";
            position: absolute;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
            font-weight: bold;
            color: #374151;
        }
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        border-left: 4px solid var(--primary);
    }

    .dark-mode i {
        color: inherit;
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