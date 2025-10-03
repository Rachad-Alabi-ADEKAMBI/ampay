<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AMPAY</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Added axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        /* Added dark mode icon fixes */
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
</head>

<body>
    <div id="app">
        <!-- Mobile Overlay -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

        <!-- Improved sidebar layout with better positioning -->
        <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
            <!-- Sidebar -->
            <aside :class="['sidebar fixed md:static w-64 bg-white dark:bg-gray-800 shadow-lg h-screen overflow-y-auto z-40', sidebarOpen ? 'open' : '']">
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

                    <nav class="space-y-2">
                        <a @click="currentView = 'dashboard'" :class="['flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors cursor-pointer', currentView === 'dashboard' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700']">
                            <i class="fas fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                        <a @click="currentView = 'users'" :class="['flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors cursor-pointer', currentView === 'users' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700']">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                        <a @click="currentView = 'transactions'" :class="['flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors cursor-pointer', currentView === 'transactions' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700']">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Transactions</span>
                        </a>
                        <a @click="currentView = 'analytics'" :class="['flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors cursor-pointer', currentView === 'analytics' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700']">
                            <i class="fas fa-chart-pie"></i>
                            <span>Analytiques</span>
                        </a>
                        <a @click="currentView = 'settings'" :class="['flex items-center space-x-3 px-4 py-3 rounded-lg transition-colors cursor-pointer', currentView === 'settings' ? 'primary-gradient text-white' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700']">
                            <i class="fas fa-cog"></i>
                            <span>Paramètres</span>
                        </a>
                    </nav>

                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <a href="index.html" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-home"></i>
                            <span>Accueil</span>
                        </a>
                        <a href="marketplace.html" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-store"></i>
                            <span>Marketplace</span>
                        </a>
                        <a href="profile.html" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="transactions.html" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Transactions</span>
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 md:ml-0">
                <!-- Top Bar -->
                <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print">
                    <div class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-bars text-xl"></i>
                                </button>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Dashboard Admin</h1>
                            </div>
                            <div class="flex items-center space-x-4">
                                <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                    <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                                </button>
                                <div class="hidden sm:flex items-center space-x-3">
                                    <div class="w-10 h-10 primary-gradient rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-white"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">Admin</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Administrateur</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Dashboard View -->
                <div v-if="currentView === 'dashboard'" class="p-4 sm:p-6">
                    <!-- Stats Grid -->
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
                            <!-- Updated to use dynamic listings data -->
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
                            <!-- Updated to use dynamic listings data -->
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
                            <!-- Updated to use dynamic listings data -->
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.totalTransactions }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Transactions</div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <!-- Updated chart title -->
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Offres et Demandes par mois</h3>
                            <canvas id="transactionsChart"></canvas>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Répartition par type</h3>
                            <canvas id="typeChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Activité récente</h3>
                        <!-- Updated to use dynamic listings data -->
                        <div v-if="recentActivities.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <i class="fas fa-spinner fa-spin text-3xl mb-2"></i>
                            <p>Chargement des activités...</p>
                        </div>
                        <div v-else class="space-y-4">
                            <div v-for="activity in recentActivities" :key="activity.id" class="flex items-center space-x-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div :class="['w-10 h-10 rounded-full flex items-center justify-center', activity.type === 'Offre' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600']">
                                    <i :class="activity.icon"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ activity.title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ activity.time }}</div>
                                </div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                    {{ formatCurrency(activity.amount) }} {{ activity.currency }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users View -->
                <div v-if="currentView === 'users'" class="p-4 sm:p-6">
                    <!-- Indicators Legend -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Légende des indicateurs</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="flex items-center space-x-3">
                                <span class="indicator-green"></span>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Offreur avec disponibilité</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="indicator-yellow"></span>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Offreur sans disponibilité</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="indicator-wheel"></span>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Demandeur actif</span>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <input v-model="searchTerm" @input="applyFilters" type="text" placeholder="Rechercher..." class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <select v-model="filterType" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les types</option>
                                <option value="offerer">Offreurs</option>
                                <option value="requester">Demandeurs</option>
                            </select>
                            <select v-model="filterCountry" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les pays</option>
                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                            </select>
                            <select v-model="filterStatus" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les statuts</option>
                                <option value="active">Actifs</option>
                                <option value="inactive">Inactifs</option>
                            </select>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Indicateur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pays</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ville</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider no-print">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Removed hover effect in dark mode for table rows -->
                                    <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Indicateur">
                                            <span v-if="user.type === 'offerer' && user.hasAvailability" class="indicator-green"></span>
                                            <span v-else-if="user.type === 'offerer' && !user.hasAvailability" class="indicator-yellow"></span>
                                            <span v-else class="indicator-wheel"></span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Utilisateur">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 primary-gradient rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ user.name }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Type">
                                            <span :class="['px-2 py-1 text-xs font-semibold rounded-full', user.type === 'offerer' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300']">
                                                {{ user.type === 'offerer' ? 'Offreur' : 'Demandeur' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Pays">
                                            <!-- Improved icon visibility -->
                                            <i class="fas fa-flag mr-1" style="color: var(--primary);"></i>{{ user.country }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Ville">
                                            <!-- Improved icon visibility -->
                                            <i class="fas fa-map-marker-alt mr-1" style="color: var(--primary);"></i>{{ user.city }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" data-label="Montant">
                                            {{ formatCurrency(user.amount) }} {{ user.currency }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print" data-label="Actions">
                                            <button @click="viewDetails(user)" class="text-primary hover:text-primary-dark mr-3">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button @click="editUser(user)" class="text-blue-600 hover:text-blue-800 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button @click="deleteUser(user.id)" class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6 no-print">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <button @click="previousPage" :disabled="currentPage === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                    Précédent
                                </button>
                                <button @click="nextPage" :disabled="currentPage === totalPages" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                    Suivant
                                </button>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        Affichage de <span class="font-medium">{{ startItem }}</span> à <span class="font-medium">{{ endItem }}</span> sur <span class="font-medium">{{ totalItems }}</span> résultats
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                        <button @click="previousPage" :disabled="currentPage === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button v-for="page in visiblePages" :key="page" @click="goToPage(page)" :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium', currentPage === page ? 'z-10 primary-gradient border-primary text-white' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700']">
                                            {{ page }}
                                        </button>
                                        <button @click="nextPage" :disabled="currentPage === totalPages" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other Views Placeholder -->
                <div v-if="currentView !== 'dashboard' && currentView !== 'users'" class="p-4 sm:p-6">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-12 text-center">
                        <i class="fas fa-construction text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Section en construction</h3>
                        <p class="text-gray-600 dark:text-gray-400">Cette section sera bientôt disponible</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Modal -->
        <div v-if="showDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-user-circle mr-2 text-primary"></i>Détails de l'utilisateur
                    </h3>
                    <button @click="closeDetailsModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div v-if="selectedUser" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Nom</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Email</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Type</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.type === 'offerer' ? 'Offreur' : 'Demandeur' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Pays</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.country }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Ville</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.city }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Montant</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(selectedUser.amount) }} {{ selectedUser.currency }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Téléphone</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.phone }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Date d'inscription</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.joinDate }}</p>
                        </div>
                    </div>
                    <div v-if="selectedUser.type === 'offerer'">
                        <p class="text-sm text-gray-600 dark:text-gray-300">Disponibilité</p>
                        <p class="text-lg font-semibold" :class="selectedUser.hasAvailability ? 'text-green-600' : 'text-yellow-600'">
                            {{ selectedUser.hasAvailability ? 'Disponible' : 'Non disponible' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add User Modal -->
        <div v-if="showAddUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-user-plus text-primary mr-2"></i>Ajouter un utilisateur
                    </h3>
                    <button @click="showAddUserModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="submitNewUser" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom</label>
                            <input v-model="newUser.name" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input v-model="newUser.email" type="email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                            <select v-model="newUser.type" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="offerer">Offreur</option>
                                <option value="requester">Demandeur</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Téléphone</label>
                            <input v-model="newUser.phone" type="tel" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pays</label>
                            <select v-model="newUser.country" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ville</label>
                            <input v-model="newUser.city" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Montant</label>
                            <input v-model="newUser.amount" type="number" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Devise</label>
                            <select v-model="newUser.currency" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="EUR">EUR</option>
                                <option value="XOF">XOF</option>
                                <option value="GBP">GBP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                            <i class="fas fa-check mr-2"></i>Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const {
            createApp
        } = Vue;

        const api = axios.create({
            baseURL: 'http://127.0.0.1/ampay/api/index.php'
        });

        createApp({
            data() {
                return {
                    darkMode: false,
                    sidebarOpen: false,
                    currentView: 'dashboard',
                    searchTerm: '',
                    filterType: '',
                    filterCountry: '',
                    filterStatus: '',
                    currentPage: 1,
                    itemsPerPage: 10,
                    showDetailsModal: false,
                    selectedUser: null,
                    showAddUserModal: false,
                    newUser: {
                        name: '',
                        email: '',
                        type: 'offerer',
                        phone: '',
                        country: 'France',
                        city: '',
                        amount: '',
                        currency: 'EUR'
                    },
                    countries: ['France', 'Sénégal', 'Côte d\'Ivoire', 'Nigeria', 'Ghana', 'Royaume-Uni', 'Allemagne', 'Bénin', 'Togo'],
                    recentActivities: [],
                    listings: [],
                    allUsers: [{
                            id: 1,
                            name: 'Jean Dupont',
                            email: 'jean.dupont@email.com',
                            type: 'offerer',
                            country: 'France',
                            city: 'Paris',
                            amount: 500,
                            currency: 'EUR',
                            hasAvailability: true,
                            phone: '+33 6 12 34 56 78',
                            joinDate: '15/01/2025'
                        },
                        {
                            id: 2,
                            name: 'Aminata Diallo',
                            email: 'aminata.diallo@email.com',
                            type: 'requester',
                            country: 'Sénégal',
                            city: 'Dakar',
                            amount: 250000,
                            currency: 'XOF',
                            hasAvailability: false,
                            phone: '+221 77 123 45 67',
                            joinDate: '12/01/2025'
                        },
                        {
                            id: 3,
                            name: 'Kofi Mensah',
                            email: 'kofi.mensah@email.com',
                            type: 'offerer',
                            country: 'Ghana',
                            city: 'Accra',
                            amount: 2000,
                            currency: 'GHS',
                            hasAvailability: true,
                            phone: '+233 24 123 4567',
                            joinDate: '10/01/2025'
                        },
                        {
                            id: 4,
                            name: 'Marie Laurent',
                            email: 'marie.laurent@email.com',
                            type: 'requester',
                            country: 'France',
                            city: 'Paris',
                            amount: 800,
                            currency: 'EUR',
                            hasAvailability: false,
                            phone: '+33 6 98 76 54 32',
                            joinDate: '18/01/2025'
                        },
                        {
                            id: 5,
                            name: 'Adeola Okonkwo',
                            email: 'adeola.okonkwo@email.com',
                            type: 'offerer',
                            country: 'Nigeria',
                            city: 'Lagos',
                            amount: 150000,
                            currency: 'NGN',
                            hasAvailability: false,
                            phone: '+234 803 123 4567',
                            joinDate: '08/01/2025'
                        },
                        {
                            id: 6,
                            name: 'Pierre Martin',
                            email: 'pierre.martin@email.com',
                            type: 'requester',
                            country: 'Allemagne',
                            city: 'Berlin',
                            amount: 1200,
                            currency: 'EUR',
                            hasAvailability: false,
                            phone: '+49 151 12345678',
                            joinDate: '14/01/2025'
                        },
                        {
                            id: 7,
                            name: 'Fatou Sow',
                            email: 'fatou.sow@email.com',
                            type: 'offerer',
                            country: 'Côte d\'Ivoire',
                            city: 'Abidjan',
                            amount: 300000,
                            currency: 'XOF',
                            hasAvailability: true,
                            phone: '+225 07 12 34 56 78',
                            joinDate: '16/01/2025'
                        },
                        {
                            id: 8,
                            name: 'John Smith',
                            email: 'john.smith@email.com',
                            type: 'requester',
                            country: 'Royaume-Uni',
                            city: 'Londres',
                            amount: 600,
                            currency: 'GBP',
                            hasAvailability: false,
                            phone: '+44 7700 123456',
                            joinDate: '11/01/2025'
                        },
                        {
                            id: 9,
                            name: 'Yao Kouassi',
                            email: 'yao.kouassi@email.com',
                            type: 'offerer',
                            country: 'Bénin',
                            city: 'Cotonou',
                            amount: 180000,
                            currency: 'XOF',
                            hasAvailability: true,
                            phone: '+229 97 12 34 56',
                            joinDate: '13/01/2025'
                        },
                        {
                            id: 10,
                            name: 'Sophie Dubois',
                            email: 'sophie.dubois@email.com',
                            type: 'requester',
                            country: 'France',
                            city: 'Lyon',
                            amount: 950,
                            currency: 'EUR',
                            hasAvailability: false,
                            phone: '+33 6 45 67 89 01',
                            joinDate: '17/01/2025'
                        },
                        {
                            id: 11,
                            name: 'Kwame Asante',
                            email: 'kwame.asante@email.com',
                            type: 'offerer',
                            country: 'Ghana',
                            city: 'Kumasi',
                            amount: 3500,
                            currency: 'GHS',
                            hasAvailability: false,
                            phone: '+233 24 987 6543',
                            joinDate: '09/01/2025'
                        },
                        {
                            id: 12,
                            name: 'Ibrahim Traoré',
                            email: 'ibrahim.traore@email.com',
                            type: 'requester',
                            country: 'Sénégal',
                            city: 'Thiès',
                            amount: 400000,
                            currency: 'XOF',
                            hasAvailability: false,
                            phone: '+221 77 987 65 43',
                            joinDate: '19/01/2025'
                        }
                    ]
                };
            },
            computed: {
                filteredUsers() {
                    let filtered = this.allUsers;

                    if (this.searchTerm) {
                        filtered = filtered.filter(u =>
                            u.name.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                            u.email.toLowerCase().includes(this.searchTerm.toLowerCase())
                        );
                    }

                    if (this.filterType) {
                        filtered = filtered.filter(u => u.type === this.filterType);
                    }

                    if (this.filterCountry) {
                        filtered = filtered.filter(u => u.country === this.filterCountry);
                    }

                    if (this.filterStatus) {
                        if (this.filterStatus === 'active') {
                            filtered = filtered.filter(u => u.type === 'offerer' ? u.hasAvailability : true);
                        } else if (this.filterStatus === 'inactive') {
                            filtered = filtered.filter(u => u.type === 'offerer' ? !u.hasAvailability : false);
                        }
                    }

                    return filtered;
                },
                paginatedUsers() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredUsers.slice(start, start + this.itemsPerPage);
                },
                totalPages() {
                    return Math.ceil(this.filteredUsers.length / this.itemsPerPage);
                },
                totalItems() {
                    return this.filteredUsers.length;
                },
                startItem() {
                    return (this.currentPage - 1) * this.itemsPerPage + 1;
                },
                endItem() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
                },
                visiblePages() {
                    const pages = [];
                    const total = this.totalPages;
                    const current = this.currentPage;
                    for (let i = 1; i <= total; i++) {
                        if (i === 1 || i === total || (i >= current - 1 && i <= current + 1)) {
                            pages.push(i);
                        }
                    }
                    return pages;
                },
                stats() {
                    return {
                        totalUsers: this.allUsers.length,
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

                this.fetchListings();
            },
            methods: {
                async fetchListings() {
                    try {
                        const response = await api.get('?action=allListings');
                        this.listings = response.data || [];
                        console.log('[v0] Listings fetched:', this.listings);

                        // Map listings to recent activities (take 5 most recent)
                        this.recentActivities = this.listings.slice(0, 5).map(listing => ({
                            id: listing.id,
                            type: listing.type,
                            icon: listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart',
                            title: `${listing.type} #${listing.id} - ${listing.city}, ${listing.country}`,
                            time: this.formatTimeAgo(listing.created_at),
                            amount: parseFloat(listing.amount),
                            currency: listing.currency
                        }));

                        // Initialize charts after data is loaded
                        this.$nextTick(() => {
                            this.initCharts();
                        });
                    } catch (error) {
                        console.error('[v0] Erreur lors du chargement des listings:', error);
                        this.listings = [];
                        this.recentActivities = [];
                    }
                },
                formatTimeAgo(dateString) {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffMs = now - date;
                    const diffMins = Math.floor(diffMs / 60000);
                    const diffHours = Math.floor(diffMs / 3600000);
                    const diffDays = Math.floor(diffMs / 86400000);

                    if (diffMins < 60) {
                        return `Il y a ${diffMins} min`;
                    } else if (diffHours < 24) {
                        return `Il y a ${diffHours}h`;
                    } else {
                        return `Il y a ${diffDays}j`;
                    }
                },
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    document.body.classList.toggle('dark-mode');
                    localStorage.setItem('darkMode', this.darkMode);
                },
                initCharts() {
                    const transactionsCtx = document.getElementById('transactionsChart');
                    if (transactionsCtx) {
                        // Group listings by month and type
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
                                        display: true,
                                        position: 'top'
                                    }
                                }
                            }
                        });
                    }

                    // Type Chart
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
                    // Mock data for now - in production, this would aggregate real data by month
                    const offers = [12, 18, 25, 32, 38, this.stats.activeOffers];
                    const requests = [8, 15, 20, 28, 35, this.stats.activeRequests];

                    return {
                        offers,
                        requests
                    };
                },
                applyFilters() {
                    this.currentPage = 1;
                },
                formatCurrency(amount) {
                    return new Intl.NumberFormat('fr-FR', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(amount);
                },
                viewDetails(user) {
                    this.selectedUser = user;
                    this.showDetailsModal = true;
                },
                closeDetailsModal() {
                    this.showDetailsModal = false;
                    this.selectedUser = null;
                },
                editUser(user) {
                    // API call placeholder: PUT /api/admin/users/:id
                    alert(`Modifier l'utilisateur: ${user.name}`);
                },
                deleteUser(userId) {
                    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                        // API call placeholder: DELETE /api/admin/users/:id
                        const index = this.allUsers.findIndex(u => u.id === userId);
                        if (index !== -1) this.allUsers.splice(index, 1);
                        alert('Utilisateur supprimé avec succès');
                    }
                },
                previousPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },
                goToPage(page) {
                    this.currentPage = page;
                },
                printList() {
                    window.print();
                },
                submitNewUser() {
                    alert('Utilisateur ajouté avec succès !');
                    this.showAddUserModal = false;
                    this.newUser = {
                        name: '',
                        email: '',
                        type: 'offerer',
                        phone: '',
                        country: 'France',
                        city: '',
                        amount: '',
                        currency: 'EUR'
                    };
                }
            }
        }).mount('#app');
    </script>
</body>

</html>