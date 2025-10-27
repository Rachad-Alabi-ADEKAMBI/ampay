<?php $title = "AmPay - Mes Transactions"; ?>

<script>
    const USER_ID = <?= json_encode($_SESSION['user_id'] ?? 0); ?>;
</script>

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
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Mes Transactions</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                <div class="px-4 sm:px-6 pb-2 pt-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                        <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center">
                            Bonjour
                            <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                                {{ capitalizeFirstLetter(user_first_name) }} {{ capitalizeAll(user_last_name) }}
                            </span>
                        </div>
                        <!-- Buttons stacked vertically on mobile -->
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <button @click="toggleView" class="w-full sm:w-auto px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition-all shadow-lg no-print">
                                <i :class="showCommentedView ? 'fas fa-list' : 'fas fa-comments'" class="mr-2"></i>
                                {{ showCommentedView ? 'Mes Annonces' : 'Transactions Commentées' }}
                            </button>
                            <button @click="openCreateModal" class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg font-medium transition-all shadow-lg no-print">
                                <i class="fas fa-plus mr-2"></i>Nouvelle Annonce
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-4 sm:px-6 pt-2">
                    <!-- Statistiques -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-list text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ myListings.length }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Annonces</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ offerCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Mes Offres</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ requestCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Mes Demandes</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ activeCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Actives</div>
                        </div>
                    </div>

                    <div v-if="showCommentedView" class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-comments text-purple-600 mr-2"></i>Transactions commentées
                                </h2>
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300 rounded-full text-sm font-semibold">
                                    {{ commentedTransactions.length }} transaction(s)
                                </span>
                            </div>
                        </div>

                        <div v-if="commentedTransactions.length === 0" class="text-center py-16">
                            <i class="fas fa-comment-slash text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Aucune transaction commentée</h3>
                            <p class="text-gray-600 dark:text-gray-400">Vous n'avez envoyé de message sur aucune transaction pour le moment</p>
                        </div>

                        <!-- Responsive table with data-label attributes -->
                        <div class="overflow-x-auto">
                            <table class="w-full responsive-table">
                                <thead class="bg-gray-50 dark:bg-gray-700 hidden md:table-header-group">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Localisation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Délai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="transaction in commentedTransactions" :key="transaction.listing_id" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors md:table-row flex flex-col md:flex-row mb-4 md:mb-0 border-b-4 md:border-b-0 border-gray-200 dark:border-gray-700">
                                        <td class="px-6 py-4 md:whitespace-nowrap" data-label="Type">
                                            <span :class="transaction.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                <i :class="transaction.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart'" class="mr-1"></i>
                                                {{ transaction.type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap" data-label="Montant">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(transaction.amount) }} {{ transaction.currency }}</div>
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap" data-label="Localisation">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                {{ transaction.city }}, {{ transaction.country }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap" data-label="Délai">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">{{ transaction.delay || 'N/A' }}</div>
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap" data-label="Date">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(transaction.listing_created_at) }}</div>
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap" data-label="Statut">
                                            <span :class="transaction.status === 'Actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ transaction.status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 md:whitespace-nowrap text-sm font-medium" data-label="Actions">
                                            <button @click="viewCommentedMessages(transaction)" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300" title="Voir mes messages">
                                                <i class="fas fa-comments"></i>
                                                <span class="ml-1">({{ transaction.messages.length }})</span>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div v-if="!showCommentedView">
                        <!-- Filtres -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                <i class="fas fa-list mr-2"></i>Mes Annonces
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <input v-model="searchTerm" @input="applyFilters" type="text" placeholder="Rechercher..." class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

                                <select v-model="filterType" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Tous les types</option>
                                    <option value="Offre">Offres</option>
                                    <option value="Demande">Demandes</option>
                                </select>

                                <select v-model="filterStatus" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    <option value="">Tous les statuts</option>
                                    <option value="Actif">Actif</option>
                                    <option value="Inactif">Inactif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tableau -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                            <!-- Responsive table with data-label attributes -->
                            <div class="overflow-x-auto">
                                <table class="w-full responsive-table">
                                    <thead class="bg-gray-50 dark:bg-gray-700 hidden md:table-header-group">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Localisation</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Délai</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr v-for="listing in paginatedListings" :key="listing.id" class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors md:table-row flex flex-col md:flex-row mb-4 md:mb-0 border-b-4 md:border-b-0 border-gray-200 dark:border-gray-700">
                                            <td class="px-6 py-4 md:whitespace-nowrap" data-label="Type">
                                                <span :class="listing.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                    <i :class="listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart'" class="mr-1"></i>
                                                    {{ listing.type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 md:whitespace-nowrap" data-label="Montant">
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(listing.amount) }} {{ listing.currency }}</div>
                                            </td>
                                            <td class="px-6 py-4 md:whitespace-nowrap" data-label="Localisation">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                    {{ listing.city }}, {{ listing.country }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 md:whitespace-nowrap" data-label="Délai">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">{{ listing.delay || 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 md:whitespace-nowrap" data-label="Date">
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(listing.created_at) }}</div>
                                            </td>
                                            <td class="px-6 py-4 md:whitespace-nowrap" data-label="Statut">
                                                <span :class="listing.status === 'Actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                    {{ listing.status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 md:whitespace-nowrap text-sm font-medium" data-label="Actions">
                                                <div class="flex gap-2">
                                                    <button @click="viewDetails(listing)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Voir">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button @click="viewAdminMessages(listing)" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300" title="Messages admin">
                                                        <i class="fas fa-comments"></i>
                                                        <span v-if="getAdminMessageCount(listing.id) > 0" class="ml-1">({{ getAdminMessageCount(listing.id) }})</span>
                                                    </button>
                                                    <button @click="editListing(listing)" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300" title="Modifier">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button @click="deleteListing(listing)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div v-if="filteredListings.length === 0" class="text-center py-16">
                                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Aucune transaction trouvée</h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6">Créez votre première annonce pour commencer</p>
                                <button @click="openCreateModal" class="px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                    <i class="fas fa-plus mr-2"></i>Créer une annonce
                                </button>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div v-if="totalPages > 1" class="flex justify-center mb-8">
                            <nav class="inline-flex rounded-lg shadow-sm">
                                <button @click="previousPage" :disabled="currentPage === 1"
                                    class="relative inline-flex items-center px-4 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button v-for="page in visiblePages" :key="page" @click="goToPage(page)"
                                    :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium', 
                                             currentPage === page ? 'z-10 primary-gradient border-primary text-white' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700']">
                                    {{ page }}
                                </button>
                                <button @click="nextPage" :disabled="currentPage === totalPages"
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

    <!-- Modal de création -->
    <div v-if="showCreateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" @click.self="closeCreateModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-plus-circle text-primary mr-2"></i>Nouvelle Annonce
                </h3>
                <button @click="closeCreateModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form @submit.prevent="submitListing" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-tag mr-1 text-primary"></i>Type d'annonce
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="newListing.type = 'Offre'" :class="['p-4 rounded-lg border-2 transition-all', newListing.type === 'Offre' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600']">
                            <i class="fas fa-hand-holding-usd text-2xl mb-2" :class="newListing.type === 'Offre' ? 'text-green-600' : 'text-gray-400'"></i>
                            <div class="font-semibold" :class="newListing.type === 'Offre' ? 'text-green-700 dark:text-green-400' : 'text-gray-700 dark:text-gray-300'">Offre</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Je propose de l'argent</div>
                        </button>
                        <button type="button" @click="newListing.type = 'Demande'" :class="['p-4 rounded-lg border-2 transition-all', newListing.type === 'Demande' ? 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20' : 'border-gray-300 dark:border-gray-600']">
                            <i class="fas fa-hand-holding-heart text-2xl mb-2" :class="newListing.type === 'Demande' ? 'text-yellow-600' : 'text-gray-400'"></i>
                            <div class="font-semibold" :class="newListing.type === 'Demande' ? 'text-yellow-700 dark:text-yellow-400' : 'text-gray-700 dark:text-gray-300'">Demande</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Je recherche de l'argent</div>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-money-bill-wave mr-1 text-primary"></i>Montant
                        </label>
                        <input v-model.number="newListing.amount" type="number" required min="1"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            placeholder="10000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-coins mr-1 text-primary"></i>Devise
                        </label>
                        <select v-model="newListing.currency" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Sélectionner</option>
                            <option value="USD">USD ($) - Dollar américain</option>
                            <option value="EUR">EUR (€) - Euro</option>
                            <option value="GBP">GBP (£) - Livre sterling</option>
                            <option value="JPY">JPY (¥) - Yen japonais</option>
                            <option value="CHF">CHF (₣) - Franc suisse</option>
                            <option value="CAD">CAD ($) - Dollar canadien</option>
                            <option value="AUD">AUD ($) - Dollar australien</option>
                            <option value="CNY">CNY (¥) - Yuan chinois</option>
                            <option value="INR">INR (₹) - Roupie indienne</option>
                            <option value="XAF">XAF (FCFA) - Franc CFA (Afrique centrale)</option>
                            <option value="XOF">XOF (FCFA) - Franc CFA (Afrique de l'Ouest)</option>
                            <option value="NGN">NGN (₦) - Naira nigérian</option>
                            <option value="GHS">GHS (₵) - Cedi ghanéen</option>
                            <option value="KES">KES (Sh) - Shilling kényan</option>
                            <option value="GNF">GNF (FG) - Franc guinéen</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-globe-africa mr-1 text-primary"></i>Pays
                        </label>
                        <input v-model="newListing.country" type="text" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            placeholder="France">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>Ville
                        </label>
                        <input v-model="newListing.city" type="text" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                            placeholder="Paris">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-hourglass-half mr-1 text-primary"></i>Délai
                    </label>
                    <select v-model="newListing.delay" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="">Sélectionner</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Deux semaines">Dans deux semaines</option>
                        <option value="Nulle">Nulle</option>
                    </select>
                </div>

                <div class="flex gap-4">
                    <button type="button" @click="closeCreateModal"
                        class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-check mr-2"></i>
                        {{ submitting ? 'Création...' : 'Créer l\'annonce' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de détails -->
    <div v-if="showDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeDetailsModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-primary to-green-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1">
                            <i class="fas fa-file-invoice-dollar mr-2"></i>Détails de l'annonce
                        </h3>
                        <p class="text-green-100 text-sm">Annonce #{{ selectedListing?.id }}</p>
                    </div>
                    <button @click="closeDetailsModal" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <div v-if="selectedListing" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-xl border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <i :class="selectedListing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart'" class="text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Type</p>
                                <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ selectedListing.type }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-4 rounded-xl border border-green-200 dark:border-green-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-money-bill-wave text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">Montant</p>
                                <p class="text-lg font-bold text-green-900 dark:text-green-100">{{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-4 rounded-xl border border-purple-200 dark:border-purple-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">Localisation</p>
                                <p class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ selectedListing.city }}, {{ selectedListing.country }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 p-4 rounded-xl border border-orange-200 dark:border-orange-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-hourglass-half text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">Délai</p>
                                <p class="text-lg font-bold text-orange-900 dark:text-orange-100">{{ selectedListing.delay || 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 dark:from-indigo-900/20 dark:to-indigo-800/20 p-4 rounded-xl border border-indigo-200 dark:border-indigo-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-calendar-alt text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Date de création</p>
                                <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">{{ formatDate(selectedListing.created_at) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 p-4 rounded-xl border border-teal-200 dark:border-teal-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-info-circle text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-teal-600 dark:text-teal-400 font-medium">Statut</p>
                                <p class="text-lg font-bold text-teal-900 dark:text-teal-100">{{ selectedListing.status }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button @click="editListing(selectedListing)" class="flex-1 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-colors">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </button>
                    <button @click="deleteListing(selectedListing)" class="flex-1 px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition-colors">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de modification -->
    <div v-if="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50" @click.self="closeEditModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-2xl w-full p-8 max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-edit text-yellow-500 mr-2"></i>Modifier l'annonce
                </h3>
                <button @click="closeEditModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form @submit.prevent="updateListing" class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-tag mr-1 text-primary"></i>Type d'annonce
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" @click="editingListing.type = 'Offre'" :class="['p-4 rounded-lg border-2 transition-all', editingListing.type === 'Offre' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-300 dark:border-gray-600']">
                            <i class="fas fa-hand-holding-usd text-2xl mb-2" :class="editingListing.type === 'Offre' ? 'text-green-600' : 'text-gray-400'"></i>
                            <div class="font-semibold" :class="editingListing.type === 'Offre' ? 'text-green-700 dark:text-green-400' : 'text-gray-700 dark:text-gray-300'">Offre</div>
                        </button>
                        <button type="button" @click="editingListing.type = 'Demande'" :class="['p-4 rounded-lg border-2 transition-all', editingListing.type === 'Demande' ? 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20' : 'border-gray-300 dark:border-gray-600']">
                            <i class="fas fa-hand-holding-heart text-2xl mb-2" :class="editingListing.type === 'Demande' ? 'text-yellow-600' : 'text-gray-400'"></i>
                            <div class="font-semibold" :class="editingListing.type === 'Demande' ? 'text-yellow-700 dark:text-yellow-400' : 'text-gray-700 dark:text-gray-300'">Demande</div>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-money-bill-wave mr-1 text-primary"></i>Montant
                        </label>
                        <input v-model.number="editingListing.amount" type="number" required min="1"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-coins mr-1 text-primary"></i>Devise
                        </label>
                        <select v-model="editingListing.currency" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="XOF">XOF</option>
                            <option value="XAF">XAF</option>
                            <option value="GNF">GNF</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-globe-africa mr-1 text-primary"></i>Pays
                        </label>
                        <input v-model="editingListing.country" type="text" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>Ville
                        </label>
                        <input v-model="editingListing.city" type="text" required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-hourglass-half mr-1 text-primary"></i>Délai
                    </label>
                    <select v-model="editingListing.delay" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <option value="Urgent">Urgent</option>
                        <option value="Deux semaines">Dans deux semaines</option>
                        <option value="Nulle">Nulle</option>
                    </select>
                </div>

                <div class="flex gap-4">
                    <button type="button" @click="closeEditModal"
                        class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="flex-1 px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-colors disabled:opacity-50">
                        <i class="fas fa-save mr-2"></i>
                        {{ submitting ? 'Enregistrement...' : 'Enregistrer' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour voir les messages des transactions commentées -->
    <div v-if="showCommentedMessagesModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeCommentedMessagesModal">
        <!-- Improved responsive modal with better mobile support -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col h-[90vh] md:max-h-[85vh]">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-comments text-purple-600 mr-2"></i>
                        <span class="hidden sm:inline">Mes messages - Annonce #{{ selectedCommentedTransaction?.listing_id }}</span>
                        <span class="sm:hidden">Annonce #{{ selectedCommentedTransaction?.listing_id }}</span>
                    </h3>
                    <button @click="closeCommentedMessagesModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl sm:text-2xl"></i>
                    </button>
                </div>
            </div>

            <div v-if="selectedCommentedTransaction" class="px-4 sm:px-6 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <span :class="selectedCommentedTransaction.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'" class="px-3 py-1 rounded-full text-xs font-semibold mr-2">
                            {{ selectedCommentedTransaction.type }}
                        </span>
                        <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ formatCurrency(selectedCommentedTransaction.amount) }} {{ selectedCommentedTransaction.currency }}
                        </span>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ selectedCommentedTransaction.city }}, {{ selectedCommentedTransaction.country }}
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-4 sm:px-6 py-4 space-y-3" ref="commentedChatContainer">
                <div v-if="loadingCommentedMessages" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-4xl text-purple-600 mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">Chargement des messages...</p>
                </div>

                <div v-else-if="commentedConversation.length === 0" class="text-center py-8">
                    <i class="fas fa-inbox text-4xl sm:text-6xl text-gray-300 mb-4"></i>
                    <h4 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun message</h4>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Commencez la conversation en envoyant un message</p>
                </div>

                <!-- Improved message colors for better readability -->
                <div v-else v-for="msg in commentedConversation" :key="msg.message_id" :class="['flex', msg.sender_id === userId ? 'justify-end' : 'justify-start']">
                    <div :class="['max-w-[85%] sm:max-w-[70%] rounded-lg p-3 sm:p-4', msg.sender_id === userId ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100']">
                        <div class="flex items-center mb-2">
                            <div :class="['w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center mr-2', msg.sender_id === userId ? 'bg-blue-600' : 'bg-gray-400 dark:bg-gray-600']">
                                <i :class="msg.sender_id === userId ? 'fas fa-user' : 'fas fa-user-shield'" class="text-white text-xs sm:text-sm"></i>
                            </div>
                            <div>
                                <p :class="['text-xs font-semibold', msg.sender_id === userId ? 'text-blue-100' : 'text-gray-700 dark:text-gray-300']">
                                    {{ msg.sender_id === userId ? 'Vous' : 'Admin' }}
                                </p>
                                <p :class="['text-xs', msg.sender_id === userId ? 'text-blue-200' : 'text-gray-500 dark:text-gray-400']">
                                    {{ formatDate(msg.message_created_at) }}
                                </p>
                            </div>
                        </div>
                        <p class="text-sm break-words">{{ msg.message }}</p>
                    </div>
                </div>
            </div>

            <!-- Improved form with better mobile button visibility -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700 flex-shrink-0 bg-white dark:bg-gray-800">
                <form @submit.prevent="sendCommentedMessage" class="flex gap-2">
                    <textarea
                        v-model="newCommentedMessage"
                        rows="2"
                        placeholder="Écrivez votre message..."
                        class="flex-1 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 resize-none text-sm"></textarea>
                    <button
                        type="submit"
                        :disabled="!newCommentedMessage.trim() || sendingCommentedMessage"
                        class="px-4 sm:px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center min-w-[60px] sm:min-w-[80px]">
                        <i class="fas fa-paper-plane text-base sm:text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal pour voir les messages de l'admin sur mes propres transactions -->
    <div v-if="showAdminMessagesModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeAdminMessagesModal">
        <!-- Improved responsive modal with better mobile support -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col h-[90vh] md:max-h-[85vh]">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-envelope text-primary mr-2"></i>
                        <span class="hidden sm:inline">Messages Admin - Annonce #{{ selectedListingForMessages?.id }}</span>
                        <span class="sm:hidden">Annonce #{{ selectedListingForMessages?.id }}</span>
                    </h3>
                    <button @click="closeAdminMessagesModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl sm:text-2xl"></i>
                    </button>
                </div>
            </div>

            <div v-if="selectedListingForMessages" class="px-4 sm:px-6 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <span :class="selectedListingForMessages.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'" class="px-3 py-1 rounded-full text-xs font-semibold mr-2">
                            {{ selectedListingForMessages.type }}
                        </span>
                        <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ formatCurrency(selectedListingForMessages.amount) }} {{ selectedListingForMessages.currency }}
                        </span>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ selectedListingForMessages.city }}, {{ selectedListingForMessages.country }}
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-4 sm:px-6 py-4 space-y-3" ref="adminChatContainer">
                <div v-if="loadingAdminMessages" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">Chargement des messages...</p>
                </div>

                <div v-else-if="adminConversation.length === 0" class="text-center py-8">
                    <i class="fas fa-inbox text-4xl sm:text-6xl text-gray-300 mb-4"></i>
                    <h4 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun message</h4>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Aucune conversation pour le moment</p>
                </div>

                <!-- Improved message colors for better readability -->
                <div v-else v-for="msg in adminConversation" :key="msg.id" :class="['flex', msg.sender_id === userId ? 'justify-end' : 'justify-start']">
                    <div :class="['max-w-[85%] sm:max-w-[70%] rounded-lg p-3 sm:p-4', msg.sender_id === userId ? 'bg-green-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100']">
                        <div class="flex items-center mb-2">
                            <div :class="['w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center mr-2', msg.sender_id === userId ? 'bg-green-600' : 'bg-gray-400 dark:bg-gray-600']">
                                <i :class="msg.sender_id === userId ? 'fas fa-user' : 'fas fa-user-shield'" class="text-white text-xs sm:text-sm"></i>
                            </div>
                            <div>
                                <p :class="['text-xs font-semibold', msg.sender_id === userId ? 'text-green-100' : 'text-gray-700 dark:text-gray-300']">
                                    {{ msg.sender_id === userId ? 'Vous' : 'Admin' }}
                                </p>
                                <p :class="['text-xs', msg.sender_id === userId ? 'text-green-200' : 'text-gray-500 dark:text-gray-400']">
                                    {{ formatDate(msg.created_at) }}
                                </p>
                            </div>
                        </div>
                        <p class="text-sm break-words">{{ msg.message }}</p>
                    </div>
                </div>
            </div>

            <!-- Improved form with better mobile button visibility -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700 flex-shrink-0 bg-white dark:bg-gray-800">
                <form @submit.prevent="sendAdminMessage" class="flex gap-2">
                    <textarea
                        v-model="newAdminMessage"
                        rows="2"
                        placeholder="Écrivez votre message..."
                        class="flex-1 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 resize-none text-sm"></textarea>
                    <button
                        type="submit"
                        :disabled="!newAdminMessage.trim() || sendingAdminMessage"
                        class="px-4 sm:px-6 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center min-w-[60px] sm:min-w-[80px]">
                        <i class="fas fa-paper-plane text-base sm:text-lg"></i>
                    </button>
                </form>
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
                showCommentedView: false,
                searchTerm: '',
                filterType: '',
                filterStatus: '',
                currentPage: 1,
                itemsPerPage: 10,
                showCreateModal: false,
                showDetailsModal: false,
                showEditModal: false,
                showCommentedMessagesModal: false,
                showAdminMessagesModal: false,
                selectedListing: null,
                selectedListingForMessages: null,
                selectedCommentedTransaction: null,
                editingListing: null,
                submitting: false,
                myListings: [],
                commentedTransactions: [],
                allMessages: [],
                commentedConversation: [],
                adminConversation: [],
                loadingCommentedMessages: false,
                loadingAdminMessages: false,
                newCommentedMessage: '',
                newAdminMessage: '',
                sendingCommentedMessage: false,
                sendingAdminMessage: false,
                adminMessageCounts: {},
                userId: <?= json_encode($_SESSION['id'] ?? ''); ?>,
                user_first_name: <?= json_encode($_SESSION['first_name'] ?? ''); ?>,
                user_last_name: <?= json_encode($_SESSION['last_name'] ?? ''); ?>,
                newListing: {
                    type: 'Offre',
                    amount: '',
                    currency: '',
                    country: '',
                    city: '',
                    delay: ''
                }
            };
        },
        computed: {
            offerCount() {
                return this.myListings.filter(l => l.type === 'Offre').length;
            },
            requestCount() {
                return this.myListings.filter(l => l.type === 'Demande').length;
            },
            activeCount() {
                return this.myListings.filter(l => l.status === 'Actif').length;
            },
            filteredListings() {
                let filtered = this.myListings;
                if (this.searchTerm) {
                    filtered = filtered.filter(l =>
                        l.city?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.country?.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }
                if (this.filterType) filtered = filtered.filter(l => l.type === this.filterType);
                if (this.filterStatus) filtered = filtered.filter(l => l.status === this.filterStatus);
                return filtered;
            },
            paginatedListings() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                return this.filteredListings.slice(start, start + this.itemsPerPage);
            },
            totalPages() {
                return Math.ceil(this.filteredListings.length / this.itemsPerPage);
            },
            visiblePages() {
                const pages = [];
                for (let i = 1; i <= this.totalPages; i++) {
                    if (i === 1 || i === this.totalPages || (i >= this.currentPage - 1 && i <= this.currentPage + 1)) {
                        pages.push(i);
                    }
                }
                return pages;
            }
        },
        async mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            if (this.userId) {
                await this.fetchMyListings();
                await this.fetchCommentedTransactions();
                await this.fetchAllMessages();
            }
        },
        methods: {
            toggleView() {
                this.showCommentedView = !this.showCommentedView;
            },
            async fetchMyListings() {
                try {
                    const res = await fetch('index.php?action=myTransactionsList');
                    const data = await res.json();
                    if (data.success && Array.isArray(data.data)) {
                        this.myListings = data.data;
                    } else {
                        this.myListings = [];
                    }
                } catch (error) {
                    console.error("Erreur backend:", error);
                    this.myListings = [];
                }
            },
            async fetchCommentedTransactions() {
                try {
                    const res = await fetch('index.php?action=commentedTransactions');
                    const data = await res.json();
                    if (data.success && Array.isArray(data.data)) {
                        this.commentedTransactions = data.data;
                    } else {
                        this.commentedTransactions = [];
                    }
                } catch (error) {
                    console.error("Erreur lors de la récupération des transactions commentées:", error);
                    this.commentedTransactions = [];
                }
            },
            async fetchAllMessages() {
                try {
                    const res = await fetch('http://127.0.0.1/ampay/index.php?action=allMessages');
                    const data = await res.json();
                    if (Array.isArray(data)) {
                        this.allMessages = data;
                        // Calculer le nombre de messages par listing
                        this.adminMessageCounts = {};
                        this.myListings.forEach(listing => {
                            const count = this.allMessages.filter(msg => msg.listing_id === listing.id && msg.receiver_id === this.userId).length;
                            this.adminMessageCounts[listing.id] = count;
                        });
                    } else {
                        this.allMessages = [];
                    }
                } catch (error) {
                    console.error("Erreur lors de la récupération des messages:", error);
                    this.allMessages = [];
                }
            },
            getAdminMessageCount(listingId) {
                return this.adminMessageCounts[listingId] || 0;
            },
            async viewCommentedMessages(transaction) {
                this.selectedCommentedTransaction = transaction;
                this.showCommentedMessagesModal = true;
                this.loadingCommentedMessages = true;
                this.commentedConversation = [];

                try {
                    // Fetch all messages for this listing_id where user is sender or receiver
                    const res = await fetch(`index.php?action=getConversation&listing_id=${transaction.listing_id}`);
                    const data = await res.json();

                    if (data.success && Array.isArray(data.messages)) {
                        this.commentedConversation = data.messages.sort((a, b) =>
                            new Date(a.message_created_at) - new Date(b.message_created_at)
                        );
                    }
                } catch (error) {
                    console.error("Erreur lors du chargement de la conversation:", error);
                } finally {
                    this.loadingCommentedMessages = false;
                    this.$nextTick(() => {
                        this.scrollToBottom('commentedChatContainer');
                    });
                }
            },
            closeCommentedMessagesModal() {
                this.showCommentedMessagesModal = false;
                this.selectedCommentedTransaction = null;
                this.commentedConversation = [];
                this.newCommentedMessage = '';
            },
            async sendCommentedMessage() {
                if (!this.newCommentedMessage.trim() || this.sendingCommentedMessage) return;

                this.sendingCommentedMessage = true;
                try {
                    const response = await axios.post('index.php?action=sendMessage', {
                        listing_id: this.selectedCommentedTransaction.listing_id,
                        message: this.newCommentedMessage.trim(),
                        sender_id: this.userId,
                        receiver_id: 1
                    });

                    if (response.data?.success) {
                        // Add message to conversation immediately
                        this.commentedConversation.push({
                            message_id: Date.now(),
                            listing_id: this.selectedCommentedTransaction.listing_id,
                            sender_id: this.userId,
                            message: this.newCommentedMessage.trim(),
                            message_created_at: new Date().toISOString()
                        });

                        this.newCommentedMessage = '';
                        this.$nextTick(() => {
                            this.scrollToBottom('commentedChatContainer');
                        });
                    }
                } catch (error) {
                    console.error('Erreur lors de l\'envoi du message:', error);
                    alert('Erreur lors de l\'envoi du message.');
                } finally {
                    this.sendingCommentedMessage = false;
                }
            },
            async viewAdminMessages(listing) {
                this.selectedListingForMessages = listing;
                this.showAdminMessagesModal = true;
                this.loadingAdminMessages = true;
                this.adminConversation = [];

                try {
                    // Fetch all messages for this listing_id where user is sender or receiver
                    const res = await fetch(`index.php?action=getConversation&listing_id=${listing.id}`);
                    const data = await res.json();

                    if (data.success && Array.isArray(data.messages)) {
                        this.adminConversation = data.messages.sort((a, b) =>
                            new Date(a.created_at || a.message_created_at) - new Date(b.created_at || b.message_created_at)
                        );
                    }
                } catch (error) {
                    console.error("Erreur lors du chargement de la conversation:", error);
                } finally {
                    this.loadingAdminMessages = false;
                    this.$nextTick(() => {
                        this.scrollToBottom('adminChatContainer');
                    });
                }
            },
            closeAdminMessagesModal() {
                this.showAdminMessagesModal = false;
                this.selectedListingForMessages = null;
                this.adminConversation = [];
                this.newAdminMessage = '';
            },
            async sendAdminMessage() {
                if (!this.newAdminMessage.trim() || this.sendingAdminMessage) return;

                this.sendingAdminMessage = true;
                try {
                    const response = await axios.post('index.php?action=sendMessage', {
                        listing_id: this.selectedListingForMessages.id,
                        message: this.newAdminMessage.trim(),
                        sender_id: this.userId,
                        receiver_id: 1
                    });

                    if (response.data?.success) {
                        // Add message to conversation immediately
                        this.adminConversation.push({
                            id: Date.now(),
                            listing_id: this.selectedListingForMessages.id,
                            sender_id: this.userId,
                            message: this.newAdminMessage.trim(),
                            created_at: new Date().toISOString()
                        });

                        this.newAdminMessage = '';
                        this.$nextTick(() => {
                            this.scrollToBottom('adminChatContainer');
                        });
                    }
                } catch (error) {
                    console.error('Erreur lors de l\'envoi du message:', error);
                    alert('Erreur lors de l\'envoi du message.');
                } finally {
                    this.sendingAdminMessage = false;
                }
            },
            scrollToBottom(refName) {
                const container = this.$refs[refName];
                if (container) {
                    container.scrollTop = container.scrollHeight;
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
            applyFilters() {
                this.currentPage = 1;
            },
            formatCurrency(amount) {
                return new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 0
                }).format(amount);
            },
            formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            },
            openCreateModal() {
                this.newListing = {
                    type: 'Offre',
                    amount: '',
                    currency: '',
                    country: '',
                    city: '',
                    delay: ''
                };
                this.showCreateModal = true;
            },
            closeCreateModal() {
                this.showCreateModal = false;
            },
            async submitListing() {
                this.submitting = true;
                try {
                    const response = await axios.post('index.php?action=createTransaction', {
                        ...this.newListing,
                        user_id: this.userId
                    });
                    if (response.data?.success) {
                        alert(response.data.message || 'Annonce créée avec succès.');
                        this.closeCreateModal();
                        await this.fetchMyListings();
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la création de l\'annonce.');
                } finally {
                    this.submitting = false;
                }
            },
            viewDetails(listing) {
                this.selectedListing = listing;
                this.showDetailsModal = true;
            },
            closeDetailsModal() {
                this.showDetailsModal = false;
                this.selectedListing = null;
            },
            editListing(listing) {
                this.editingListing = {
                    ...listing
                };
                this.showDetailsModal = false;
                this.showEditModal = true;
            },
            closeEditModal() {
                this.showEditModal = false;
                this.editingListing = null;
            },
            async updateListing() {
                this.submitting = true;
                try {
                    const response = await api.post('?action=updateTransaction', this.editingListing);
                    if (response.data?.success) {
                        alert('Annonce modifiée avec succès.');
                        this.closeEditModal();
                        await this.fetchMyListings();
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la modification.');
                } finally {
                    this.submitting = false;
                }
            },
            async deleteListing(listing) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cette annonce ?')) return;
                try {
                    const response = await api.post('?action=deleteTransaction', {
                        id: listing.id
                    });
                    if (response.data?.success) {
                        alert('Annonce supprimée avec succès.');
                        this.closeDetailsModal();
                        await this.fetchMyListings();
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la suppression.');
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
            }
        }
    }).mount('#app');
</script>

<style>
    :root {
        --primary: #10B981;
        --bg-dark: #0F172A;
        --bg-dark-secondary: #1E293B;
        /* Added custom gray-750 color for better dark mode hover */
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
    }

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    .sidebar {
        transition: transform 0.3s ease;
    }

    /* Added responsive table styles */
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

        .responsive-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .dark-mode .responsive-table tbody tr {
            border-color: #374151;
        }

        .responsive-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .dark-mode .responsive-table tbody td {
            border-bottom-color: #1f2937;
        }

        .responsive-table tbody td:last-child {
            border-bottom: none;
        }

        .responsive-table tbody td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6b7280;
            margin-right: 1rem;
        }

        .dark-mode .responsive-table tbody td::before {
            color: #9ca3af;
        }
    }

    /* Added custom dark mode hover color for better visual feedback */
    .dark-mode tr:hover {
        background-color: var(--bg-gray-750) !important;
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