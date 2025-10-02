<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Transactions - AMPAY</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .dark-mode .border-gray-200 {
            border-color: #334155 !important;
        }

        .dark-mode .border-gray-300 {
            border-color: #475569 !important;
        }

        .dark-mode .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3) !important;
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
        <!-- Added mobile overlay for sidebar -->
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

        <!-- Added sidebar navigation -->
        <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
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
                        <a href="transactions.html" class="flex items-center space-x-3 px-4 py-3 primary-gradient text-white rounded-lg">
                            <i class="fas fa-exchange-alt"></i>
                            <span>Transactions</span>
                        </a>
                        <a href="admin.html" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-user-shield"></i>
                            <span>Admin</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 md:ml-0">
                <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print">
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

                <div class="p-4 sm:p-6">
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <p class="text-lg text-gray-600 dark:text-gray-400">Historique complet de vos transferts</p>
                        </div>
                        <div class="flex gap-2 no-print">
                            <button @click="showAddModal = true" class="px-4 py-2 primary-gradient text-white rounded-lg font-medium hover:opacity-90 transition-opacity">
                                <i class="fas fa-plus mr-2"></i>Nouvelle demande/offre
                            </button>
                            <button @click="printList" class="px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white rounded-lg font-medium transition-colors">
                                <i class="fas fa-print mr-2"></i>Imprimer
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.completed }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Complétées</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ stats.pending }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">En attente</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                    <i class="fas fa-euro-sign text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ formatCurrency(stats.totalAmount) }} EUR</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Montant total</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-4 sm:p-6 mb-8 no-print">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                <i class="fas fa-filter mr-2 text-primary"></i>Filtres
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                <button @click="filterStatus = 'all'" :class="['px-4 py-2 rounded-lg font-medium transition-colors', filterStatus === 'all' ? 'primary-gradient text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600']">
                                    Toutes
                                </button>
                                <button @click="filterStatus = 'completed'" :class="['px-4 py-2 rounded-lg font-medium transition-colors', filterStatus === 'completed' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600']">
                                    Complétées
                                </button>
                                <button @click="filterStatus = 'pending'" :class="['px-4 py-2 rounded-lg font-medium transition-colors', filterStatus === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600']">
                                    En attente
                                </button>
                                <button @click="filterStatus = 'cancelled'" :class="['px-4 py-2 rounded-lg font-medium transition-colors', filterStatus === 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600']">
                                    Annulées
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Contact</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Montant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Localisation</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider no-print">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="transaction in paginatedTransactions" :key="transaction.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" data-label="ID">{{ transaction.id }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100" data-label="Contact">{{ transaction.contact }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" data-label="Type">
                                            <span :class="['px-2 py-1 text-xs font-semibold rounded-full', transaction.type === 'sent' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300']">
                                                {{ transaction.type === 'sent' ? 'Envoyé' : 'Reçu' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold" :class="transaction.type === 'sent' ? 'text-red-600' : 'text-green-600'" data-label="Montant">
                                            {{ transaction.type === 'sent' ? '-' : '+' }}{{ formatCurrency(transaction.amount) }} {{ transaction.currency }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Date">{{ transaction.date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" data-label="Localisation">{{ transaction.location }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm" data-label="Statut">
                                            <span :class="['px-2 py-1 text-xs font-semibold rounded-full', getStatusBadgeColor(transaction.status)]">
                                                {{ getStatusText(transaction.status) }}
                                            </span>
                                        </td>
                                        <!-- Added edit and delete action buttons -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium no-print" data-label="Actions">
                                            <button @click="viewTransactionDetails(transaction)" class="text-primary hover:text-primary-dark mr-3" title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button @click="editTransaction(transaction)" class="text-blue-600 hover:text-blue-800 mr-3" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button @click="confirmDeleteTransaction(transaction)" class="text-red-600 hover:text-red-800" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

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

                    <div v-if="filteredTransactions.length === 0" class="text-center py-16">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Aucune transaction trouvée</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Essayez de modifier vos filtres</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Details Modal -->
        <div v-if="showDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-receipt text-primary mr-2"></i>Détails de la transaction
                    </h3>
                    <button @click="closeDetailsModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div v-if="selectedTransaction" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">ID Transaction</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedTransaction.id }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Statut</p>
                            <span :class="['inline-block px-3 py-1 text-sm font-semibold rounded-full', getStatusBadgeColor(selectedTransaction.status)]">
                                {{ getStatusText(selectedTransaction.status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Date</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedTransaction.date }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Montant</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(selectedTransaction.amount) }} {{ selectedTransaction.currency }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Contact</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedTransaction.contact }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Localisation</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ selectedTransaction.location }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Added Edit Transaction Modal -->
        <div v-if="showEditModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-edit text-primary mr-2"></i>Modifier la transaction
                    </h3>
                    <button @click="closeEditModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="submitEditTransaction" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contact</label>
                            <input v-model="editingTransaction.contact" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Montant</label>
                            <input v-model="editingTransaction.amount" type="number" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Devise</label>
                            <select v-model="editingTransaction.currency" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="EUR">EUR</option>
                                <option value="XOF">XOF</option>
                                <option value="GBP">GBP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Statut</label>
                            <select v-model="editingTransaction.status" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="completed">Complétée</option>
                                <option value="pending">En attente</option>
                                <option value="cancelled">Annulée</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localisation</label>
                        <input v-model="editingTransaction.location" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="submit" class="flex-1 px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                            <i class="fas fa-save mr-2"></i>Enregistrer
                        </button>
                        <button type="button" @click="closeEditModal" class="px-8 py-3 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg font-semibold hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Added Delete Confirmation Modal -->
        <div v-if="showDeleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-exclamation-triangle text-red-600 mr-2"></i>Confirmer la suppression
                    </h3>
                    <button @click="closeDeleteModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Êtes-vous sûr de vouloir supprimer cette transaction ? Cette action est irréversible.
                </p>

                <div v-if="transactionToDelete" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Transaction ID</p>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ transactionToDelete.id }}</p>
                </div>

                <div class="flex gap-3">
                    <button @click="deleteTransaction" class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                    <button @click="closeDeleteModal" class="px-6 py-3 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg font-semibold hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                        Annuler
                    </button>
                </div>
            </div>
        </div>

        <!-- Add Transaction Modal -->
        <div v-if="showAddModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-2xl w-full p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-plus-circle text-primary mr-2"></i>Nouvelle demande/offre
                    </h3>
                    <button @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <form @submit.prevent="submitNewTransaction" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                        <select v-model="newTransaction.type" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="offer">Offre</option>
                            <option value="request">Demande</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Montant</label>
                            <input v-model="newTransaction.amount" type="number" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Devise</label>
                            <select v-model="newTransaction.currency" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="EUR">EUR</option>
                                <option value="XOF">XOF</option>
                                <option value="GBP">GBP</option>
                                <option value="USD">USD</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pays</label>
                            <input v-model="newTransaction.country" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Ville</label>
                            <input v-model="newTransaction.city" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" required>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                            <i class="fas fa-check mr-2"></i>Créer
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

        createApp({
            data() {
                return {
                    darkMode: false,
                    sidebarOpen: false,
                    filterStatus: 'all',
                    showDetailsModal: false,
                    showAddModal: false,
                    showEditModal: false,
                    showDeleteModal: false,
                    selectedTransaction: null,
                    transactionToDelete: null,
                    editingTransaction: {},
                    currentPage: 1,
                    itemsPerPage: 10,
                    newTransaction: {
                        type: 'offer',
                        amount: '',
                        currency: 'EUR',
                        country: '',
                        city: ''
                    },
                    transactions: [{
                            id: 'TRX001',
                            type: 'sent',
                            contact: 'Marie Laurent',
                            amount: 500,
                            currency: 'EUR',
                            date: '20/01/2025',
                            location: 'Paris, France',
                            status: 'completed'
                        },
                        {
                            id: 'TRX002',
                            type: 'received',
                            contact: 'Aminata Diallo',
                            amount: 250000,
                            currency: 'XOF',
                            date: '18/01/2025',
                            location: 'Dakar, Sénégal',
                            status: 'completed'
                        },
                        {
                            id: 'TRX003',
                            type: 'sent',
                            contact: 'Kofi Mensah',
                            amount: 800,
                            currency: 'EUR',
                            date: '15/01/2025',
                            location: 'Accra, Ghana',
                            status: 'pending'
                        },
                        {
                            id: 'TRX004',
                            type: 'received',
                            contact: 'Sophie Dubois',
                            amount: 1200,
                            currency: 'EUR',
                            date: '12/01/2025',
                            location: 'Lyon, France',
                            status: 'completed'
                        },
                        {
                            id: 'TRX005',
                            type: 'sent',
                            contact: 'Ibrahim Traoré',
                            amount: 300000,
                            currency: 'XOF',
                            date: '10/01/2025',
                            location: 'Thiès, Sénégal',
                            status: 'cancelled'
                        },
                        {
                            id: 'TRX006',
                            type: 'received',
                            contact: 'Emma Wilson',
                            amount: 750,
                            currency: 'GBP',
                            date: '08/01/2025',
                            location: 'Londres, UK',
                            status: 'completed'
                        },
                        {
                            id: 'TRX007',
                            type: 'sent',
                            contact: 'Yao Kouassi',
                            amount: 180000,
                            currency: 'XOF',
                            date: '05/01/2025',
                            location: 'Abidjan, CI',
                            status: 'completed'
                        },
                        {
                            id: 'TRX008',
                            type: 'received',
                            contact: 'Pierre Martin',
                            amount: 950,
                            currency: 'EUR',
                            date: '03/01/2025',
                            location: 'Berlin, Allemagne',
                            status: 'pending'
                        }
                    ]
                };
            },
            computed: {
                filteredTransactions() {
                    if (this.filterStatus === 'all') {
                        return this.transactions;
                    }
                    return this.transactions.filter(t => t.status === this.filterStatus);
                },
                paginatedTransactions() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredTransactions.slice(start, start + this.itemsPerPage);
                },
                totalPages() {
                    return Math.ceil(this.filteredTransactions.length / this.itemsPerPage);
                },
                totalItems() {
                    return this.filteredTransactions.length;
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
                        completed: this.transactions.filter(t => t.status === 'completed').length,
                        pending: this.transactions.filter(t => t.status === 'pending').length,
                        totalAmount: this.transactions
                            .filter(t => t.status === 'completed' && t.currency === 'EUR')
                            .reduce((sum, t) => sum + (t.type === 'received' ? t.amount : 0), 0)
                    };
                }
            },
            mounted() {
                const savedDarkMode = localStorage.getItem('darkMode');
                if (savedDarkMode === 'true') {
                    this.darkMode = true;
                    document.body.classList.add('dark-mode');
                }
            },
            methods: {
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    document.body.classList.toggle('dark-mode');
                    localStorage.setItem('darkMode', this.darkMode);
                },
                formatCurrency(amount) {
                    return new Intl.NumberFormat('fr-FR', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(amount);
                },
                getStatusBadgeColor(status) {
                    const colors = {
                        completed: 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                        pending: 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300',
                        cancelled: 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300'
                    };
                    return colors[status] || 'bg-gray-100 text-gray-700';
                },
                getStatusText(status) {
                    const texts = {
                        completed: 'Complétée',
                        pending: 'En attente',
                        cancelled: 'Annulée'
                    };
                    return texts[status] || 'Inconnue';
                },
                viewTransactionDetails(transaction) {
                    this.selectedTransaction = transaction;
                    this.showDetailsModal = true;
                },
                closeDetailsModal() {
                    this.showDetailsModal = false;
                    this.selectedTransaction = null;
                },
                editTransaction(transaction) {
                    this.editingTransaction = {
                        ...transaction
                    };
                    this.showEditModal = true;
                },
                closeEditModal() {
                    this.showEditModal = false;
                    this.editingTransaction = {};
                },
                submitEditTransaction() {
                    const index = this.transactions.findIndex(t => t.id === this.editingTransaction.id);
                    if (index !== -1) {
                        this.transactions[index] = {
                            ...this.editingTransaction
                        };
                    }
                    alert('Transaction modifiée avec succès !');
                    this.closeEditModal();
                },
                confirmDeleteTransaction(transaction) {
                    this.transactionToDelete = transaction;
                    this.showDeleteModal = true;
                },
                closeDeleteModal() {
                    this.showDeleteModal = false;
                    this.transactionToDelete = null;
                },
                deleteTransaction() {
                    const index = this.transactions.findIndex(t => t.id === this.transactionToDelete.id);
                    if (index !== -1) {
                        this.transactions.splice(index, 1);
                    }
                    alert('Transaction supprimée avec succès !');
                    this.closeDeleteModal();
                },
                printList() {
                    window.print();
                },
                submitNewTransaction() {
                    alert('Nouvelle demande/offre créée avec succès !');
                    this.showAddModal = false;
                    this.newTransaction = {
                        type: 'offer',
                        amount: '',
                        currency: 'EUR',
                        country: '',
                        city: ''
                    };
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