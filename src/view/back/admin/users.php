<?php $title = "AmPay - Liste des utilisateurs"; ?>


<?php


ob_start(); ?>

<div id="app">
    <!-- Added mobile overlay for sidebar -->
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <!-- Fixed sidebar layout with independent scrolling -->
    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../sidebar.php'; ?>


        <!-- Main Content -->
        <div class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden">
            <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print flex-shrink-0">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <!-- Added translation for page title -->
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ t.pageTitle }}
                            </h1>
                        </div>
                        <!-- Added language toggle button -->
                        <div class="flex items-center space-x-4">
                            <button @click="toggleLanguage" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ currentLanguage.toUpperCase() }}</span>
                            </button>
                            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6">
                <!-- Added translation for greeting -->
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center">
                        {{ t.greeting }}
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                            Admin
                        </span>
                    </div>
                </div>
                <!-- Stats -->
                <!-- Added translation for stats labels -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ t.stats.totalUsers }}</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ allUsers.length }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ t.stats.totalListings }}</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ totalListings }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list text-xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">{{ t.stats.bannedUsers }}</p>
                                <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ bannedUsers }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-ban text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <!-- Added translation for filters -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <input v-model="searchTerm" @input="applyFilters" type="text" :placeholder="t.filters.searchPlaceholder" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <select v-model="filterCountry" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">{{ t.filters.allCountries }}</option>
                            <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                        </select>
                        <select v-model="filterStatus" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">{{ t.filters.allStatuses }}</option>
                            <option value="active">{{ t.filters.active }}</option>
                            <option value="banned">{{ t.filters.banned }}</option>
                        </select>
                    </div>
                </div>

                <!-- Users Table -->
                <!-- Added translation for table headers and content -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.table.user }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.table.country }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.table.listings }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.table.status }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider no-print">{{ t.table.actions }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Updated hover to use gray-750 like transactions page, removed user icon, restructured user display -->
                                <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-750">
                                    <td class="px-6 py-4 whitespace-nowrap" :data-label="t.table.user">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ capitalizeFirstLetter(user.first_name) }} {{ capitalizeAll(user.last_name) }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ user.email }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" :data-label="t.table.country">
                                        <i class="fas fa-flag mr-1 text-primary"></i>{{ user.country || 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" :data-label="t.table.listings">
                                        {{ getUserListingsCount(user.id) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap" :data-label="t.table.status">
                                        <span :class="['px-2 py-1 text-xs font-semibold rounded-full', user.banned ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300']">
                                            {{ user.banned ? t.statusLabels.banned : t.statusLabels.active }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print" :data-label="t.table.actions">
                                        <button @click="viewUserListings(user)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3" :title="t.actions.viewListings">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button v-if="!user.banned" @click="openBanModal(user)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" :title="t.actions.ban">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                        <button v-else @click="unbanUser(user)" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" :title="t.actions.unban">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <!-- Added translation for pagination -->
                    <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6 no-print">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button @click="previousPage" :disabled="currentPage === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                {{ t.pagination.previous }}
                            </button>
                            <button @click="nextPage" :disabled="currentPage === totalPages" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                {{ t.pagination.next }}
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ t.pagination.showing }} <span class="font-medium">{{ startItem }}</span> {{ t.pagination.to }} <span class="font-medium">{{ endItem }}</span> {{ t.pagination.of }} <span class="font-medium">{{ totalItems }}</span> {{ t.pagination.results }}
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
        </div>
    </div>

    <!-- Ban User Modal -->
    <!-- Added translation for ban modal -->
    <div v-if="showBanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeBanModal">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-ban text-red-600 mr-2"></i>{{ t.banModal.title }}
                </h3>
                <button @click="closeBanModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div v-if="selectedUser" class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ t.banModal.aboutToBan }}</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.name }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ selectedUser.email }}</p>
            </div>

            <form @submit.prevent="submitBan">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ t.banModal.reasonLabel }}
                    </label>
                    <textarea v-model="banReason" rows="4" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" :placeholder="t.banModal.reasonPlaceholder"></textarea>
                </div>

                <div class="flex space-x-3">
                    <button type="button" @click="closeBanModal" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ t.banModal.cancel }}
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-ban mr-2"></i>{{ t.banModal.banButton }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Listings Modal -->
    <!-- Added translation for listings modal -->
    <div v-if="showListingsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeListingsModal">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full p-6 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-list text-primary mr-2"></i>{{ t.listingsModal.title.replace('{user}', selectedUser?.name) }}
                </h3>
                <button @click="closeListingsModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Filters for listings -->
            <div class="mb-4 flex space-x-3">
                <select v-model="listingsFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <option value="">{{ t.listingsModal.filters.allTypes }}</option>
                    <option value="Offre">{{ t.listingsModal.filters.offers }}</option>
                    <option value="Demande">{{ t.listingsModal.filters.requests }}</option>
                </select>
                <select v-model="listingsSortBy" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <option value="date">{{ t.listingsModal.sortBy.date }}</option>
                    <option value="amount">{{ t.listingsModal.sortBy.amount }}</option>
                    <option value="type">{{ t.listingsModal.sortBy.type }}</option>
                </select>
            </div>

            <div v-if="filteredUserListings.length === 0" class="text-center py-8">
                <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                <p class="text-gray-500 dark:text-gray-400">{{ t.listingsModal.noListings }}</p>
            </div>

            <div v-else class="space-y-4">
                <div v-for="listing in filteredUserListings" :key="listing.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <span :class="['px-3 py-1 rounded-full text-sm font-semibold', listing.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300']">
                            {{ listing.type === 'Offre' ? t.listingsModal.typeLabels.offer : t.listingsModal.typeLabels.request }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(listing.created_at) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ t.listingsModal.labels.amount }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ formatCurrency(listing.amount) }} {{ listing.currency }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ t.listingsModal.labels.location }}</p>
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ listing.city }}, {{ listing.country }}</p>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span :class="['px-2 py-1 text-xs font-semibold rounded-full', listing.status === 'Actif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700']">
                            {{ listing.status === 'Actif' ? t.listingsModal.statusLabels.active : t.listingsModal.statusLabels.inactive }}
                        </span>
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
                currentLanguage: 'fr',
                searchTerm: '',
                filterCountry: '',
                filterStatus: '',
                currentPage: 1,
                itemsPerPage: 10,
                showBanModal: false,
                showListingsModal: false,
                selectedUser: null,
                banReason: '',
                listingsFilter: '',
                listingsSortBy: 'date',
                countries: [],
                allUsers: [],
                listings: [],
                translations: {
                    fr: {
                        pageTitle: 'Liste des utilisateurs',
                        greeting: 'Bonjour',
                        stats: {
                            totalUsers: 'Total Utilisateurs',
                            totalListings: 'Total Annonces',
                            bannedUsers: 'Utilisateurs Bannis'
                        },
                        filters: {
                            searchPlaceholder: 'Rechercher par nom, email...',
                            allCountries: 'Tous les pays',
                            allStatuses: 'Tous les statuts',
                            active: 'Actifs',
                            banned: 'Bannis'
                        },
                        table: {
                            user: 'Utilisateur',
                            country: 'Pays',
                            listings: 'Annonces',
                            status: 'Statut',
                            actions: 'Actions'
                        },
                        statusLabels: {
                            active: 'Actif',
                            banned: 'Banni'
                        },
                        actions: {
                            viewListings: 'Voir les annonces',
                            ban: 'Bannir',
                            unban: 'Débannir'
                        },
                        pagination: {
                            previous: 'Précédent',
                            next: 'Suivant',
                            showing: 'Affichage de',
                            to: 'à',
                            of: 'sur',
                            results: 'résultats'
                        },
                        banModal: {
                            title: "Bannir l'utilisateur",
                            aboutToBan: 'Vous êtes sur le point de bannir:',
                            reasonLabel: 'Raison du bannissement',
                            reasonPlaceholder: 'Expliquez la raison du bannissement...',
                            cancel: 'Annuler',
                            banButton: 'Bannir'
                        },
                        listingsModal: {
                            title: 'Annonces de {user}',
                            filters: {
                                allTypes: 'Tous les types',
                                offers: 'Offres',
                                requests: 'Demandes'
                            },
                            sortBy: {
                                date: 'Date',
                                amount: 'Montant',
                                type: 'Type'
                            },
                            noListings: 'Aucune annonce trouvée',
                            typeLabels: {
                                offer: 'Offre',
                                request: 'Demande'
                            },
                            labels: {
                                amount: 'Montant',
                                location: 'Localisation'
                            },
                            statusLabels: {
                                active: 'Actif',
                                inactive: 'Inactif'
                            }
                        },
                        alerts: {
                            userBanned: 'Utilisateur {user} banni avec succès.\nRaison: {reason}',
                            userUnbanned: 'Utilisateur {user} débanni avec succès.',
                            confirmUnban: 'Êtes-vous sûr de vouloir débannir {user} ?'
                        },
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
                        pageTitle: 'Users List',
                        greeting: 'Hello',
                        stats: {
                            totalUsers: 'Total Users',
                            totalListings: 'Total Listings',
                            bannedUsers: 'Banned Users'
                        },
                        filters: {
                            searchPlaceholder: 'Search by name, email...',
                            allCountries: 'All countries',
                            allStatuses: 'All statuses',
                            active: 'Active',
                            banned: 'Banned'
                        },
                        table: {
                            user: 'User',
                            country: 'Country',
                            listings: 'Listings',
                            status: 'Status',
                            actions: 'Actions'
                        },
                        statusLabels: {
                            active: 'Active',
                            banned: 'Banned'
                        },
                        actions: {
                            viewListings: 'View listings',
                            ban: 'Ban',
                            unban: 'Unban'
                        },
                        pagination: {
                            previous: 'Previous',
                            next: 'Next',
                            showing: 'Showing',
                            to: 'to',
                            of: 'of',
                            results: 'results'
                        },
                        banModal: {
                            title: 'Ban User',
                            aboutToBan: 'You are about to ban:',
                            reasonLabel: 'Ban Reason',
                            reasonPlaceholder: 'Explain the reason for the ban...',
                            cancel: 'Cancel',
                            banButton: 'Ban'
                        },
                        listingsModal: {
                            title: "{user}'s Listings",
                            filters: {
                                allTypes: 'All types',
                                offers: 'Offers',
                                requests: 'Requests'
                            },
                            sortBy: {
                                date: 'Date',
                                amount: 'Amount',
                                type: 'Type'
                            },
                            noListings: 'No listings found',
                            typeLabels: {
                                offer: 'Offer',
                                request: 'Request'
                            },
                            labels: {
                                amount: 'Amount',
                                location: 'Location'
                            },
                            statusLabels: {
                                active: 'Active',
                                inactive: 'Inactive'
                            }
                        },
                        alerts: {
                            userBanned: 'User {user} successfully banned.\nReason: {reason}',
                            userUnbanned: 'User {user} successfully unbanned.',
                            confirmUnban: 'Are you sure you want to unban {user}?'
                        },
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
            filteredUsers() {
                let filtered = this.allUsers;

                if (this.searchTerm) {
                    filtered = filtered.filter(u =>
                        u.name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        u.email?.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }

                if (this.filterCountry) {
                    filtered = filtered.filter(u => u.country === this.filterCountry);
                }

                if (this.filterStatus === 'active') {
                    filtered = filtered.filter(u => !u.banned);
                } else if (this.filterStatus === 'banned') {
                    filtered = filtered.filter(u => u.banned);
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
            totalListings() {
                return this.listings.length;
            },
            bannedUsers() {
                return this.allUsers.filter(u => u.banned).length;
            },
            filteredUserListings() {
                if (!this.selectedUser) return [];

                let userListings = this.listings.filter(l => l.user_id === this.selectedUser.id);

                if (this.listingsFilter) {
                    userListings = userListings.filter(l => l.type === this.listingsFilter);
                }

                // Sort
                if (this.listingsSortBy === 'date') {
                    userListings.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                } else if (this.listingsSortBy === 'amount') {
                    userListings.sort((a, b) => parseFloat(b.amount) - parseFloat(a.amount));
                } else if (this.listingsSortBy === 'type') {
                    userListings.sort((a, b) => a.type.localeCompare(b.type));
                }

                return userListings;
            }
        },
        async mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            const savedLanguage = localStorage.getItem('language');
            if (savedLanguage && (savedLanguage === 'fr' || savedLanguage === 'en')) {
                this.currentLanguage = savedLanguage;
            }

            window.addEventListener('languageChanged', (event) => {
                this.currentLanguage = event.detail;
            });

            await this.fetchUsers();
            await this.fetchListings();
        },
        methods: {
            toggleLanguage() {
                this.currentLanguage = this.currentLanguage === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLanguage);

                window.dispatchEvent(new CustomEvent('languageChanged', {
                    detail: this.currentLanguage
                }));
            },
            async fetchUsers() {
                try {
                    const response = await api.get('?action=allUsers');
                    this.allUsers = (response.data || []).map(user => ({
                        ...user,
                        banned: user.banned || false
                    }));

                    // Extract unique countries
                    this.countries = [...new Set(this.allUsers.map(u => u.country).filter(Boolean))];
                } catch (error) {
                    console.error('Erreur lors du chargement des utilisateurs:', error);
                    this.allUsers = [];
                }
            },
            async fetchListings() {
                try {
                    const response = await api.get('?action=allListings');
                    this.listings = response.data || [];
                } catch (error) {
                    console.error('Erreur lors du chargement des listings:', error);
                    this.listings = [];
                }
            },
            getUserListingsCount(userId) {
                return this.listings.filter(l => l.user_id === userId).length;
            },
            viewUserListings(user) {
                this.selectedUser = user;
                this.showListingsModal = true;
                this.listingsFilter = '';
                this.listingsSortBy = 'date';
            },
            closeListingsModal() {
                this.showListingsModal = false;
                this.selectedUser = null;
            },
            openBanModal(user) {
                this.selectedUser = user;
                this.showBanModal = true;
                this.banReason = '';
            },
            closeBanModal() {
                this.showBanModal = false;
                this.selectedUser = null;
                this.banReason = '';
            },
            submitBan() {
                if (this.selectedUser && this.banReason.trim()) {
                    // API call would go here
                    this.selectedUser.banned = true;
                    this.selectedUser.banReason = this.banReason;
                    alert(this.t.alerts.userBanned.replace('{user}', this.selectedUser.name).replace('{reason}', this.banReason));
                    this.closeBanModal();
                }
            },
            unbanUser(user) {
                if (confirm(this.t.alerts.confirmUnban.replace('{user}', user.name))) {
                    // API call would go here
                    user.banned = false;
                    delete user.banReason;
                    alert(this.t.alerts.userUnbanned.replace('{user}', user.name));
                }
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
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
            formatDate(dateString) {
                const date = new Date(dateString);
                return date.toLocaleDateString(this.currentLanguage === 'fr' ? 'fr-FR' : 'en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },
            capitalizeFirstLetter(word) {
                if (!word) return '';
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            },
            capitalizeAll(word) {
                if (!word) return '';
                return word.toString().toUpperCase();
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
            }
        }
    }).mount('#app');
</script>

<style>
    :root {
        --primary: #10B981;
        --bg-dark: #0F172A;
        --bg-dark-secondary: #1E293B;
        /* Added custom gray-750 color for better dark mode hover like transactions page */
        --bg-gray-750: #1a2332;
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
    .dark-mode select,
    .dark-mode textarea {
        background-color: var(--bg-dark-secondary) !important;
        color: #F9FAFB !important;
        border-color: #475569 !important;
    }

    .dark-mode input::placeholder,
    .dark-mode textarea::placeholder {
        color: #64748B !important;
    }

    /* Added custom dark mode hover color like transactions page */
    .dark-mode tr:hover {
        background-color: var(--bg-gray-750) !important;
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

        .dark-mode tr {
            background: var(--bg-dark-secondary);
            border-color: #475569;
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

        .dark-mode td:before {
            color: #94A3B8;
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

        .bg-white,
        .bg-gray-50 {
            background: white !important;
        }

        .shadow-sm,
        .shadow-md {
            box-shadow: none !important;
        }

        table {
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }
</style>

<?php $content = ob_get_clean(); ?>

<?php require './src/view/layout.php'; ?>