<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs - AMPAY</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .dark-mode i {
            color: inherit;
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
</head>

<body>
    <div id="app">
        <!-- Mobile Overlay -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden no-print"></div>

        <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
            <!-- Sidebar -->
            <?php include 'sidebar.php'; ?>

            <!-- Main Content -->
            <div class="flex-1 md:ml-0">
                <!-- Top Bar -->
                <?php include 'header.php'; ?>

                <div class="p-4 sm:p-6">
                    <!-- Stats -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Utilisateurs</p>
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
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Annonces</p>
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
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Utilisateurs Bannis</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ bannedUsers }}</p>
                                </div>
                                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-ban text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <input v-model="searchTerm" @input="applyFilters" type="text" placeholder="Rechercher par nom, email..." class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <select v-model="filterCountry" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les pays</option>
                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                            </select>
                            <select v-model="filterStatus" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les statuts</option>
                                <option value="active">Actifs</option>
                                <option value="banned">Bannis</option>
                            </select>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Utilisateur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pays</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Annonces</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider no-print">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="user in paginatedUsers" :key="user.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" data-label="ID">
                                            #{{ user.id }}
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
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Pays">
                                            <i class="fas fa-flag mr-1 text-primary"></i>{{ user.country || 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" data-label="Annonces">
                                            {{ getUserListingsCount(user.id) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Statut">
                                            <span :class="['px-2 py-1 text-xs font-semibold rounded-full', user.banned ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300']">
                                                {{ user.banned ? 'Banni' : 'Actif' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print" data-label="Actions">
                                            <button @click="viewUserListings(user)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3" title="Voir les annonces">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button v-if="!user.banned" @click="openBanModal(user)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" title="Bannir">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <button v-else @click="unbanUser(user)" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300" title="Débannir">
                                                <i class="fas fa-check-circle"></i>
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
            </div>
        </div>

        <!-- Ban User Modal -->
        <div v-if="showBanModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeBanModal">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-ban text-red-600 mr-2"></i>Bannir l'utilisateur
                    </h3>
                    <button @click="closeBanModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div v-if="selectedUser" class="mb-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Vous êtes sur le point de bannir:</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedUser.name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ selectedUser.email }}</p>
                </div>

                <form @submit.prevent="submitBan">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Raison du bannissement
                        </label>
                        <textarea v-model="banReason" rows="4" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Expliquez la raison du bannissement..."></textarea>
                    </div>

                    <div class="flex space-x-3">
                        <button type="button" @click="closeBanModal" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Annuler
                        </button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-ban mr-2"></i>Bannir
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- View Listings Modal -->
        <div v-if="showListingsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeListingsModal">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-4xl w-full p-6 max-h-[90vh] overflow-y-auto">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-list text-primary mr-2"></i>Annonces de {{ selectedUser?.name }}
                    </h3>
                    <button @click="closeListingsModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Filters for listings -->
                <div class="mb-4 flex space-x-3">
                    <select v-model="listingsFilter" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Tous les types</option>
                        <option value="Offre">Offres</option>
                        <option value="Demande">Demandes</option>
                    </select>
                    <select v-model="listingsSortBy" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="date">Date</option>
                        <option value="amount">Montant</option>
                        <option value="type">Type</option>
                    </select>
                </div>

                <div v-if="filteredUserListings.length === 0" class="text-center py-8">
                    <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500 dark:text-gray-400">Aucune annonce trouvée</p>
                </div>

                <div v-else class="space-y-4">
                    <div v-for="listing in filteredUserListings" :key="listing.id" class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-2">
                            <span :class="['px-3 py-1 rounded-full text-sm font-semibold', listing.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300']">
                                {{ listing.type }}
                            </span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(listing.created_at) }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Montant</p>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ formatCurrency(listing.amount) }} {{ listing.currency }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Localisation</p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">{{ listing.city }}, {{ listing.country }}</p>
                            </div>
                        </div>
                        <div class="mt-2">
                            <span :class="['px-2 py-1 text-xs font-semibold rounded-full', listing.status === 'Actif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700']">
                                {{ listing.status }}
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
            baseURL: 'http://127.0.0.1/ampay/api/index.php'
        });

        createApp({
            data() {
                return {
                    darkMode: false,
                    sidebarOpen: false,
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
                    listings: []
                };
            },
            computed: {
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

                await this.fetchUsers();
                await this.fetchListings();
            },
            methods: {
                async fetchUsers() {
                    try {
                        const response = await api.get('?action=allUsers');
                        this.allUsers = (response.data || []).map(user => ({
                            ...user,
                            banned: user.banned || false
                        }));

                        // Extract unique countries
                        this.countries = [...new Set(this.allUsers.map(u => u.country).filter(Boolean))];

                        console.log('[v0] Users fetched:', this.allUsers);
                    } catch (error) {
                        console.error('Erreur lors du chargement des utilisateurs:', error);
                        this.allUsers = [];
                    }
                },
                async fetchListings() {
                    try {
                        const response = await api.get('?action=allListings');
                        this.listings = response.data || [];
                        console.log('[v0] Listings fetched:', this.listings);
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
                        alert(`Utilisateur ${this.selectedUser.name} banni avec succès.\nRaison: ${this.banReason}`);
                        this.closeBanModal();
                    }
                },
                unbanUser(user) {
                    if (confirm(`Êtes-vous sûr de vouloir débannir ${user.name} ?`)) {
                        // API call would go here
                        user.banned = false;
                        delete user.banReason;
                        alert(`Utilisateur ${user.name} débanni avec succès.`);
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
                    return date.toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
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
                printPage() {
                    window.print();
                }
            }
        }).mount('#app');
    </script>
</body>

</html>