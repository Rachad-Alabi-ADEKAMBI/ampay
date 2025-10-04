<?php
$pageTitle = 'Transactions';
$currentPage = 'transactions';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - AMPAY</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #10B981;
            --primary-dark: #059669;
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

        .dark-mode i {
            color: inherit;
        }

        .primary-gradient {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {

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

        /* Added sidebar styles */
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

            .print-title {
                display: block !important;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }
        }

        .print-title {
            display: none;
        }
    </style>
</head>

<body>
    <div id="app">
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

        <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
            <?php include 'sidebar.php'; ?>

            <div class="flex-1 md:ml-0">

                <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print">
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
                <div class="p-4">
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Transactions</h1>
                            <p class="text-gray-600 dark:text-gray-400">Liste de toutes les transactions</p>
                        </div>
                        <button @click="printList" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-medium transition-all shadow-lg no-print">
                            <i class="fas fa-print mr-2"></i>Imprimer la liste
                        </button>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-list text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ allListings.length }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Annonces</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ offerCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Offres</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ requestCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Demandes</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ activeCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Actives</div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                            <input v-model="searchTerm" @input="applyFilters" type="text" placeholder="Rechercher par nom, ville..." class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

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

                            <input v-model.number="filterMinAmount" @input="applyFilters" type="number" placeholder="Montant min" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

                            <input v-model.number="filterMaxAmount" @input="applyFilters" type="number" placeholder="Montant max" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>

                    <!-- Listings Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Annonceur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Localisation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider no-print">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="listing in paginatedListings" :key="listing.id" class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" data-label="ID">
                                            #{{ listing.id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap" data-label="Annonceur">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 primary-gradient rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ listing.first_name }} {{ listing.last_name }}</div>
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ listing.email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" data-label="Type">
                                            <span :class="['px-2 py-1 text-xs font-semibold rounded-full', listing.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300']">
                                                {{ listing.type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-gray-100" data-label="Montant">
                                            {{ formatCurrency(listing.amount) }} {{ listing.currency }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Localisation">
                                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>{{ listing.city }}, {{ listing.country }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Date">
                                            {{ formatDate(listing.created_at) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print" data-label="Actions">
                                            <button @click="viewListingDetails(listing)" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-3" title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button @click="openMessageModal(listing)" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 mr-3" title="Envoyer un message">
                                                <i class="fas fa-envelope"></i>
                                            </button>
                                            <button @click="toggleStatus(listing)" :class="[listing.status === 'Actif' ? 'text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300' : 'text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300', 'mr-3']" :title="listing.status === 'Actif' ? 'Désactiver' : 'Activer'">
                                                <i :class="['fas', listing.status === 'Actif' ? 'fa-toggle-on' : 'fa-toggle-off']"></i>
                                            </button>
                                            <button @click="openMessagesModal(listing)" class="text-purple-600 hover:text-purple-800 dark:text-purple-400 dark:hover:text-purple-300" title="Gestion des messages">
                                                <i class="fas fa-comments"></i>
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

                    <div v-if="filteredListings.length === 0" class="text-center py-16">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Aucune annonce trouvée</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Essayez de modifier vos filtres</p>
                    </div>
                </div>


            </div>

            <!-- Details Modal -->
            <div v-if="showDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeDetailsModal">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            <i class="fas fa-info-circle text-primary mr-2"></i>Détails de l'annonce
                        </h3>
                        <button @click="closeDetailsModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div v-if="selectedListing" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Annonceur</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedListing.first_name }} {{ selectedListing.last_name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ selectedListing.email }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ selectedListing.phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Type</p>
                                <span :class="['inline-block px-3 py-1 text-sm font-semibold rounded-full', selectedListing.type === 'Offre' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700']">
                                    {{ selectedListing.type }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Montant</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Localisation</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedListing.city }}, {{ selectedListing.country }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Date de création</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ formatDate(selectedListing.created_at) }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Note</p>
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-star text-yellow-400"></i> {{ selectedListing.ratings }}/5
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Send Message Modal -->
            <div v-if="showMessageModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeMessageModal">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-lg w-full p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            <i class="fas fa-envelope text-primary mr-2"></i>Envoyer un message
                        </h3>
                        <button @click="closeMessageModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times text-xl"></i>
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

                        <div class="flex justify-end gap-3">
                            <button @click="closeMessageModal" class="px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                Annuler
                            </button>
                            <button @click="sendMessage" :disabled="!messageContent.trim()" class="px-4 py-2 primary-gradient text-white rounded-lg hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-paper-plane mr-2"></i>Envoyer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages Management Modal -->
            <div v-if="showMessagesModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeMessagesModal">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-3xl w-full p-6 max-h-[80vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                            <i class="fas fa-comments text-primary mr-2"></i>Messages reçus - Annonce #{{ selectedListing?.id }}
                        </h3>
                        <button @click="closeMessagesModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <div v-if="loadingMessages" class="text-center py-8">
                        <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">Chargement des messages...</p>
                    </div>

                    <div v-else-if="transactionMessages.length === 0" class="text-center py-8">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun message</h4>
                        <p class="text-gray-600 dark:text-gray-400">Aucun message reçu pour cette annonce</p>
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
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ formatDate(msg['created at']) }}</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 p-3 rounded-lg">{{ msg.message }}</p>
                            <div class="mt-3 flex gap-2">
                                <button @click="replyToMessage(msg)" class="text-sm text-primary hover:text-primary-dark">
                                    <i class="fas fa-reply mr-1"></i>Répondre
                                </button>
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
            baseURL: 'http://127.0.0.1/ampay/api/index.php'
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
                    filterMinAmount: null,
                    filterMaxAmount: null,
                    currentPage: 1,
                    itemsPerPage: 10,
                    showDetailsModal: false,
                    showMessageModal: false,
                    showMessagesModal: false,
                    selectedListing: null,
                    messageContent: '',
                    allListings: [],
                    allMessages: [],
                    transactionMessages: [],
                    loadingMessages: false,
                    countries: [],
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

                    if (this.filterType) {
                        filtered = filtered.filter(l => l.type === this.filterType);
                    }

                    if (this.filterCountry) {
                        filtered = filtered.filter(l => l.country === this.filterCountry);
                    }

                    if (this.filterStatus) {
                        filtered = filtered.filter(l => l.status === this.filterStatus);
                    }

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
                totalItems() {
                    return this.filteredListings.length;
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
                }
            },
            async mounted() {
                const savedDarkMode = localStorage.getItem('darkMode');
                if (savedDarkMode === 'true') {
                    this.darkMode = true;
                    document.body.classList.add('dark-mode');
                }

                await this.fetchListings();
                await this.fetchAllMessages();
            },
            methods: {
                async fetchListings() {
                    try {
                        const response = await api.get('?action=allListings');
                        this.allListings = response.data || [];
                        this.countries = [...new Set(this.allListings.map(l => l.country).filter(Boolean))];
                    } catch (error) {
                        console.error('Erreur lors du chargement des annonces:', error);
                        this.allListings = [];
                    }
                },
                async fetchAllMessages() {
                    try {
                        const response = await api.get('?action=allMessages');
                        this.allMessages = response.data || [];
                    } catch (error) {
                        console.error('Erreur lors du chargement des messages:', error);
                        this.allMessages = [];
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
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
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
                        // TODO: Replace with actual API endpoint for sending messages
                        await api.post('?action=sendMessage', {
                            transaction_id: this.selectedListing.id,
                            message: this.messageContent
                        });

                        alert('Message envoyé avec succès!');
                        this.closeMessageModal();
                    } catch (error) {
                        console.error('Erreur lors de l\'envoi du message:', error);
                        alert('Erreur lors de l\'envoi du message');
                    }
                },
                async toggleStatus(listing) {
                    const newStatus = listing.status === 'Actif' ? 'Inactif' : 'Actif';

                    try {
                        // TODO: Replace with actual API endpoint for updating status
                        await api.post('?action=updateListingStatus', {
                            id: listing.id,
                            status: newStatus
                        });

                        listing.status = newStatus;
                        alert(`Statut changé en ${newStatus}`);
                    } catch (error) {
                        console.error('Erreur lors du changement de statut:', error);
                        alert('Erreur lors du changement de statut');
                    }
                },
                async openMessagesModal(listing) {
                    this.selectedListing = listing;
                    this.showMessagesModal = true;
                    this.loadingMessages = true;

                    // Filter messages for this transaction
                    this.transactionMessages = this.allMessages.filter(msg => msg.transaction_id === listing.id);

                    this.loadingMessages = false;
                },
                closeMessagesModal() {
                    this.showMessagesModal = false;
                    this.selectedListing = null;
                    this.transactionMessages = [];
                },
                replyToMessage(msg) {
                    this.closeMessagesModal();
                    this.selectedListing = {
                        ...this.selectedListing,
                        first_name: msg.first_name,
                        last_name: msg.last_name,
                        email: msg.email
                    };
                    this.openMessageModal(this.selectedListing);
                },
                printList() {
                    window.print();
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
</body>

</html>