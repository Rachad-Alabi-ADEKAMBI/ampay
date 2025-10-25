<?php $title = "AmPay - Transactions"; ?>

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
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Transactions</h1>
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
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center mb-6">
                        Bonjour
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">Admin</span>
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
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ allListings.length }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Annonces</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ offerCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Offres</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ requestCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Demandes</div>
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

                    <!-- Filtres -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                            <input v-model="searchTerm" @input="applyFilters" type="text" placeholder="Rechercher..." class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

                            <select v-model="filterType" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les types</option>
                                <option value="Offre">Offres</option>
                                <option value="Demande">Demandes</option>
                            </select>

                            <select v-model="filterCountry" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les pays</option>
                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                            </select>

                            <select v-model="filterStatus" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les statuts</option>
                                <option value="Actif">Actif</option>
                                <option value="Inactif">Inactif</option>
                            </select>

                            <!-- Changed from sort to filter with proper delay options -->
                            <select v-model="filterDelay" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">Tous les délais</option>
                                <option value="Urgent">Urgent</option>
                                <option value="Deux semaines">Deux semaines</option>
                                <option value="Nulle">Nulle</option>
                            </select>

                            <input v-model.number="filterMinAmount" @input="applyFilters" type="number" placeholder="Montant min" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

                            <input v-model.number="filterMaxAmount" @input="applyFilters" type="number" placeholder="Montant max" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>

                    <!-- Tableau -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full responsive-table">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Annonceur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Localisation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <!-- Removed white hover in dark mode, changed to darker gray -->
                                    <tr v-for="listing in paginatedListings" :key="listing.listing_id" class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                        <td data-label="Annonceur" class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ listing.first_name }} {{ listing.last_name }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ listing.email }}</div>
                                            </div>
                                        </td>
                                        <td data-label="Type" class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span :class="getDelayDotColor(listing.delay)" class="w-3 h-3 rounded-full flex-shrink-0"></span>
                                                <span :class="listing.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                    <i :class="listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart'" class="mr-1"></i>
                                                    {{ listing.type }}
                                                </span>
                                            </div>
                                        </td>
                                        <td data-label="Montant" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(listing.amount) }} {{ listing.currency }}</div>
                                        </td>
                                        <td data-label="Localisation" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                {{ listing.city }}, {{ listing.country }}
                                            </div>
                                        </td>
                                        <td data-label="Date" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(listing.created_at) }}</div>
                                        </td>
                                        <td data-label="Statut" class="px-6 py-4 whitespace-nowrap">
                                            <span :class="listing.status === 'Actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ listing.status }}
                                            </span>
                                        </td>
                                        <td data-label="Actions" class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button @click="viewListingDetails(listing)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button @click="openMessageModal(listing)" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="Message">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <button @click="toggleStatus(listing)" :class="listing.status === 'Actif' ? 'text-red-600 hover:text-red-900 dark:text-red-400' : 'text-green-600 hover:text-green-900 dark:text-green-400'" :title="listing.status === 'Actif' ? 'Désactiver' : 'Activer'">
                                                    <i :class="listing.status === 'Actif' ? 'fas fa-pause' : 'fas fa-play'"></i>
                                                </button>
                                                <!-- Added unread message count badge next to messages icon -->
                                                <button @click="openMessagesModal(listing.listing_id)" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 relative" title="Messages">
                                                    <i class="fas fa-comments"></i>
                                                    <span v-if="getUnreadCount(listing.listing_id) > 0" class="ml-1 text-xs font-semibold">({{ getUnreadCount(listing.listing_id) }})</span>
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
                            <p class="text-gray-600 dark:text-gray-400">Essayez de modifier vos filtres</p>
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

    <!-- Modal de détails -->
    <div v-if="showDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeDetailsModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-primary to-green-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1">
                            <i class="fas fa-file-invoice-dollar mr-2"></i>Détails de l'annonce
                        </h3>
                        <p class="text-green-100 text-sm">Annonce #{{ selectedListing?.listing_id }}</p>
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
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">Annonceur</p>
                                <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ selectedListing.first_name }} {{ selectedListing.last_name }}</p>
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
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">Téléphone</p>
                                <p class="text-lg font-bold text-orange-900 dark:text-orange-100">{{ selectedListing.phone || 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Added delay display in details modal -->
                    <div :class="getDelayCardColor(selectedListing.delay)" class="p-4 rounded-xl border">
                        <div class="flex items-center mb-2">
                            <div :class="getDelayIconBgColor(selectedListing.delay)" class="w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium" :class="getDelayTextColor(selectedListing.delay)">Délai</p>
                                <div class="flex items-center">
                                    <span :class="getDelayDotColor(selectedListing.delay)" class="w-3 h-3 rounded-full mr-2"></span>
                                    <p class="text-lg font-bold" :class="getDelayTextDarkColor(selectedListing.delay)">{{ selectedListing.delay }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'envoi de message -->
    <div v-if="showMessageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeMessageModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-envelope text-primary mr-2"></i>Envoyer un message
                </h3>
                <button @click="closeMessageModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="selectedListing" class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Destinataire</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedListing.first_name }} {{ selectedListing.last_name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ selectedListing.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Votre message</label>
                    <textarea v-model="messageContent" rows="6" placeholder="Écrivez votre message ici..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>

                <div class="flex gap-3">
                    <button @click="closeMessageModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button @click="sendMessage" :disabled="!messageContent.trim()" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de gestion des messages -->
    <div v-if="showMessagesModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeMessagesModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full p-8 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-comments text-primary mr-2"></i>Messages - Annonce #{{ selectedListing?.listing_id }}
                </h3>
                <button @click="closeMessagesModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="loadingMessages" class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                <p class="text-gray-600 dark:text-gray-400">Chargement des messages...</p>
            </div>

            <div v-else-if="transactionMessages.length === 0" class="text-center py-8">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun message</h4>
                <p class="text-gray-600 dark:text-gray-400">Aucun message pour cette annonce</p>
            </div>

            <div v-else class="space-y-4">
                <div v-for="msg in transactionMessages" :key="msg.id" class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="w-10 h-10 primary-gradient rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ msg.first_name }} {{ msg.last_name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ msg.email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span v-if="msg.status" :class="msg.status === 'Envoyé' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300'" class="px-2 py-1 rounded-full text-xs font-semibold">
                                {{ msg.status }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ formatDate(msg.created_at) }}</span>
                        </div>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 p-3 rounded-lg mb-3">{{ msg.message }}</p>
                    <div class="flex justify-end gap-2">
                        <button v-if="msg.status === 'Envoyé'" @click="markAsRead(msg)" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                            <i class="fas fa-check mr-2"></i>Marquer comme lu
                        </button>
                        <button @click="openReplyModal(msg)" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition-colors text-sm font-medium">
                            <i class="fas fa-reply mr-2"></i>Répondre
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New reply modal for individual message responses -->
    <div v-if="showReplyModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] flex items-center justify-center p-4" @click.self="closeReplyModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-reply text-primary mr-2"></i>Répondre au message
                </h3>
                <button @click="closeReplyModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="selectedMessage" class="space-y-4">
                <!-- Original message display -->
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border-l-4 border-primary">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Message original de:</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ selectedMessage.first_name }} {{ selectedMessage.last_name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ selectedMessage.email }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 italic mt-2">"{{ selectedMessage.message }}"</p>
                </div>

                <!-- Reply form -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Votre réponse</label>
                    <textarea v-model="replyContent" rows="6" placeholder="Écrivez votre réponse ici..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>

                <div class="flex gap-3">
                    <button @click="closeReplyModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button @click="sendReply" :disabled="!replyContent.trim()" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer
                    </button>
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
                searchTerm: '',
                filterType: '',
                filterCountry: '',
                filterStatus: '',
                filterDelay: '',
                filterMinAmount: null,
                filterMaxAmount: null,
                currentPage: 1,
                itemsPerPage: 10,
                showDetailsModal: false,
                showMessageModal: false,
                showMessagesModal: false,
                showReplyModal: false,
                selectedListing: null,
                selectedMessage: null,
                messageContent: '',
                replyContent: '',
                allListings: [],
                transactionMessages: [],
                loadingMessages: false,
                countries: [],
                messageCounts: {},
            };
        },
        computed: {
            offerCount() {
                return this.allListings.filter(l => l.type === 'Offre').length;
            },
            requestCount() {
                return this.allListings.filter(l => l.type === 'Demande').length;
            },
            activeCount() {
                return this.allListings.filter(l => l.status === 'Actif').length;
            },
            filteredListings() {
                let filtered = this.allListings;
                if (this.searchTerm) {
                    filtered = filtered.filter(l =>
                        l.first_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.last_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.city?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.email?.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }
                if (this.filterType) filtered = filtered.filter(l => l.type === this.filterType);
                if (this.filterCountry) filtered = filtered.filter(l => l.country === this.filterCountry);
                if (this.filterStatus) filtered = filtered.filter(l => l.status === this.filterStatus);
                if (this.filterDelay) filtered = filtered.filter(l => l.delay === this.filterDelay);
                if (this.filterMinAmount !== null && this.filterMinAmount !== '') {
                    filtered = filtered.filter(l => parseFloat(l.amount) >= this.filterMinAmount);
                }
                if (this.filterMaxAmount !== null && this.filterMaxAmount !== '') {
                    filtered = filtered.filter(l => parseFloat(l.amount) <= this.filterMaxAmount);
                }

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
            await this.fetchListings();
            await this.fetchAllMessageCounts();
        },
        methods: {
            async fetchListings() {
                try {
                    const response = await api.get('?action=allListings');
                    this.allListings = response.data || [];
                    this.countries = [...new Set(this.allListings.map(l => l.country).filter(Boolean))];
                } catch (error) {
                    console.error('Erreur:', error);
                    this.allListings = [];
                }
            },
            async fetchAllMessageCounts() {
                const promises = this.allListings.map(async (listing) => {
                    const messages = await this.fetchAllMessagesByListingId(listing.listing_id);
                    const unreadCount = messages.filter(m => m.status === 'Envoyé').length;
                    this.messageCounts[listing.listing_id] = unreadCount;
                });
                await Promise.all(promises);
            },
            getUnreadCount(listingId) {
                return this.messageCounts[listingId] || 0;
            },
            async fetchAllMessagesByListingId(listingId) {
                try {
                    const response = await api.get(`?action=allMessagesByListingId&id=${listingId}`);
                    if (response.data && response.data.success) {
                        return response.data.data;
                    } else {
                        return [];
                    }
                } catch (error) {
                    console.error('Erreur lors de la récupération des messages :', error);
                    return [];
                }
            },
            getDelayDotColor(delay) {
                if (delay === 'Urgent') return 'bg-green-500';
                if (delay === 'Deux semaines') return 'bg-yellow-500';
                if (delay === 'Nulle') return 'bg-red-500';
                return 'bg-gray-500';
            },
            getDelayCardColor(delay) {
                if (delay === 'Urgent') return 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-green-200 dark:border-green-700';
                if (delay === 'Deux semaines') return 'bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border-yellow-200 dark:border-yellow-700';
                if (delay === 'Nulle') return 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-red-200 dark:border-red-700';
                return 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900/20 dark:to-gray-800/20 border-gray-200 dark:border-gray-700';
            },
            getDelayIconBgColor(delay) {
                if (delay === 'Urgent') return 'bg-green-500';
                if (delay === 'Deux semaines') return 'bg-yellow-500';
                if (delay === 'Nulle') return 'bg-red-500';
                return 'bg-gray-500';
            },
            getDelayTextColor(delay) {
                if (delay === 'Urgent') return 'text-green-600 dark:text-green-400';
                if (delay === 'Deux semaines') return 'text-yellow-600 dark:text-yellow-400';
                if (delay === 'Nulle') return 'text-red-600 dark:text-red-400';
                return 'text-gray-600 dark:text-gray-400';
            },
            getDelayTextDarkColor(delay) {
                if (delay === 'Urgent') return 'text-green-900 dark:text-green-100';
                if (delay === 'Deux semaines') return 'text-yellow-900 dark:text-yellow-100';
                if (delay === 'Nulle') return 'text-red-900 dark:text-red-100';
                return 'text-gray-900 dark:text-gray-100';
            },
            async markAsRead(message) {
                try {
                    await api.post('?action=markMessageAsRead', {
                        id: message.id
                    });
                    message.status = 'Lu';
                    if (this.selectedListing) {
                        const messages = await this.fetchAllMessagesByListingId(this.selectedListing.listing_id);
                        const unreadCount = messages.filter(m => m.status === 'Envoyé').length;
                        this.messageCounts[this.selectedListing.listing_id] = unreadCount;
                    }
                    alert('Message marqué comme lu!');
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors du marquage du message');
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
                    minimumFractionDigits: 0
                }).format(amount);
            },
            formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },
            viewListingDetails(listing) {
                this.selectedListing = listing;
                this.showDetailsModal = true;
            },
            closeDetailsModal() {
                this.showDetailsModal = false;
                this.selectedListing = null;
            },
            openMessageModal(listing) {
                this.selectedListing = listing;
                this.messageContent = '';
                this.showMessageModal = true;
            },
            closeMessageModal() {
                this.showMessageModal = false;
                this.selectedListing = null;
                this.messageContent = '';
            },
            async sendMessage() {
                if (!this.messageContent.trim()) return;
                try {
                    await api.post('?action=sendMessage', {
                        transaction_id: this.selectedListing.listing_id,
                        message: this.messageContent
                    });
                    alert('Message envoyé avec succès!');
                    this.closeMessageModal();
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'envoi du message');
                }
            },
            async toggleStatus(listing) {
                const newStatus = listing.status === 'Actif' ? 'Inactif' : 'Actif';
                try {
                    await api.post('?action=updateListingStatus', {
                        id: listing.listing_id,
                        status: newStatus
                    });
                    listing.status = newStatus;
                } catch (error) {
                    console.error('Erreur:', error);
                }
            },
            async openMessagesModal(listingId) {
                const listing = this.allListings.find(l => l.listing_id === listingId);
                if (!listing) {
                    console.error('Listing not found for ID:', listingId);
                    return;
                }

                this.selectedListing = listing;
                this.showMessagesModal = true;
                this.loadingMessages = true;

                const messages = await this.fetchAllMessagesByListingId(listingId);
                this.transactionMessages = messages;

                this.loadingMessages = false;
            },
            closeMessagesModal() {
                this.showMessagesModal = false;
                this.selectedListing = null;
                this.transactionMessages = [];
            },
            openReplyModal(message) {
                this.selectedMessage = message;
                this.replyContent = '';
                this.showReplyModal = true;
            },
            closeReplyModal() {
                this.showReplyModal = false;
                this.selectedMessage = null;
                this.replyContent = '';
            },
            async sendReply() {
                if (!this.replyContent.trim()) return;
                try {
                    await api.post('?action=sendMessage', {
                        transaction_id: this.selectedListing.listing_id,
                        message: this.replyContent,
                        recipient_email: this.selectedMessage.email
                    });
                    alert('Réponse envoyée avec succès!');
                    this.closeReplyModal();
                    const messages = await this.fetchAllMessagesByListingId(this.selectedListing.listing_id);
                    this.transactionMessages = messages;
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de l\'envoi de la réponse');
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

        .responsive-table thead {
            display: none;
        }

        .responsive-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .dark-mode .responsive-table tbody tr {
            border-color: #334155;
        }

        .responsive-table tbody tr:hover {
            background-color: transparent !important;
        }

        .responsive-table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            position: relative;
            padding-left: 50%;
        }

        .dark-mode .responsive-table tbody td {
            border-bottom-color: #1e293b;
        }

        .responsive-table tbody td:last-child {
            border-bottom: none;
        }

        .responsive-table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: 45%;
            text-align: left;
            font-weight: 600;
            color: #374151;
        }

        .dark-mode .responsive-table tbody td::before {
            color: #94A3B8;
        }

        .responsive-table tbody td[data-label="Annonceur"] {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .responsive-table tbody td[data-label="Actions"] .flex {
            justify-content: flex-end;
            gap: 1rem;
        }

        .responsive-table tbody td[data-label="Actions"] .flex button {
            font-size: 1.125rem;
        }
    }

    /* Added custom dark mode hover color */
    .dark-mode tr:hover {
        background-color: var(--bg-gray-750) !important;
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>