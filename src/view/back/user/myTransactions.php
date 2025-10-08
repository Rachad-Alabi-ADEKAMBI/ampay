<?php $title = "AmPay - Mes Transactions"; ?>

<?php
ob_start(); ?>

<div id="app">
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
        <?php include __DIR__ . '/../sidebar.php'; ?>

        <div class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden">
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

            <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6">
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Mes Transactions</h1>
                        <p class="text-gray-600 dark:text-gray-400">Gérez vos offres et demandes</p>
                    </div>
                    <button @click="openCreateModal" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg font-medium transition-all shadow-lg no-print">
                        <i class="fas fa-plus mr-2"></i>Nouvelle Annonce
                    </button>
                </div>

                Stats Cards
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 sm:gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ myListings.length }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Annonces</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hand-holding-usd text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ offerCount }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Mes Offres</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hand-holding-heart text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ requestCount }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Mes Demandes</div>
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

                Filters
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
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

                Listings Grid
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div v-for="listing in paginatedListings" :key="listing.id"
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden card-hover"
                        :class="listing.type === 'Offre' ? 'border-l-4 border-green-500' : 'border-l-4 border-yellow-500'">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span :class="listing.type === 'Offre' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'" class="px-3 py-1 rounded-full text-sm font-semibold">
                                    <i :class="listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart'" class="mr-1"></i>
                                    {{ listing.type }}
                                </span>
                                <span :class="listing.status === 'Actif' ? 'text-green-600' : 'text-gray-400'">
                                    <i :class="listing.status === 'Actif' ? 'fas fa-circle' : 'fas fa-circle'" class="text-xs"></i>
                                </span>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fas fa-map-marker-alt w-5 text-primary"></i>
                                    <span class="font-medium">{{ listing.city }}, {{ listing.country }}</span>
                                </div>
                            </div>

                            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Montant</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ listing.currency }}</span>
                                </div>
                                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    {{ formatCurrency(listing.amount) }}
                                </div>
                            </div>

                            <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                                <i class="fas fa-clock mr-1"></i>{{ formatDate(listing.created_at) }}
                            </div>

                            <div class="flex gap-2">
                                <button @click="viewDetails(listing)" class="flex-1 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-medium transition-colors">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </button>
                                <button @click="toggleStatus(listing)" :class="listing.status === 'Actif' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'" class="flex-1 py-2 text-white rounded-lg font-medium transition-colors">
                                    <i :class="listing.status === 'Actif' ? 'fas fa-pause' : 'fas fa-play'" class="mr-1"></i>
                                    {{ listing.status === 'Actif' ? 'Désactiver' : 'Activer' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="filteredListings.length === 0" class="text-center py-16">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Aucune transaction trouvée</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Créez votre première annonce pour commencer</p>
                    <button @click="openCreateModal" class="px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        <i class="fas fa-plus mr-2"></i>Créer une annonce
                    </button>
                </div>

                Pagination
                <div v-if="totalPages > 1" class="flex justify-center">
                    <nav class="inline-flex rounded-lg shadow-sm">
                        <button @click="previousPage" :disabled="currentPage === 1"
                            class="relative inline-flex items-center px-4 py-2 rounded-l-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button v-for="page in visiblePages" :key="page" @click="goToPage(page)"
                            :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium', 
                                     currentPage === page ? 'z-10 primary-gradient border-primary text-white' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50']">
                            {{ page }}
                        </button>
                        <button @click="nextPage" :disabled="currentPage === totalPages"
                            class="relative inline-flex items-center px-4 py-2 rounded-r-lg border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>


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
                        <input v-model.number="newListing.amount" type="number" required min="1" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="10000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-coins mr-1 text-primary"></i>Devise
                        </label>
                        <select v-model="newListing.currency" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">Sélectionner</option>
                            <option value="EUR">EUR (€)</option>
                            <option value="USD">USD ($)</option>
                            <option value="XAF">XAF (FCFA)</option>
                            <option value="GNF">GNF (Franc guinéen)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-globe-africa mr-1 text-primary"></i>Pays
                        </label>
                        <input v-model="newListing.country" type="text" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="France">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>Ville
                        </label>
                        <input v-model="newListing.city" type="text" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="Paris">
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="button" @click="closeCreateModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" :disabled="submitting" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-check mr-2"></i>
                        {{ submitting ? 'Création...' : 'Créer l\'annonce' }}
                    </button>
                </div>
            </form>
        </div>
    </div>


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
                        <p class="text-sm text-gray-600 dark:text-gray-400">Type</p>
                        <span :class="['inline-block px-3 py-1 text-sm font-semibold rounded-full', selectedListing.type === 'Offre' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700']">
                            {{ selectedListing.type }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Statut</p>
                        <span :class="['inline-block px-3 py-1 text-sm font-semibold rounded-full', selectedListing.status === 'Actif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700']">
                            {{ selectedListing.status }}
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
                            <i class="fas fa-star text-yellow-400"></i> {{ selectedListing.ratings || 5 }}/5
                        </p>
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
                filterStatus: '',
                currentPage: 1,
                itemsPerPage: 9,
                showCreateModal: false,
                showDetailsModal: false,
                selectedListing: null,
                submitting: false,
                myListings: [],
                userId: null,
                newListing: {
                    type: 'Offre',
                    amount: '',
                    currency: '',
                    country: '',
                    city: ''
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
                const pages = [],
                    total = this.totalPages,
                    current = this.currentPage;
                for (let i = 1; i <= total; i++) {
                    if (i === 1 || i === total || (i >= current - 1 && i <= current + 1)) pages.push(i);
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
            this.userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;
            if (this.userId) await this.fetchMyListings();
        },
        methods: {
            async fetchMyListings() {
                try {
                    const response = await api.get('?action=allListings');
                    const allListings = response.data || [];
                    this.myListings = allListings.filter(l => l.user_id == this.userId);
                } catch (error) {
                    console.error('Erreur:', error);
                    this.myListings = [];
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
            openCreateModal() {
                this.newListing = {
                    type: 'Offre',
                    amount: '',
                    currency: '',
                    country: '',
                    city: ''
                };
                this.showCreateModal = true;
            },
            closeCreateModal() {
                this.showCreateModal = false;
            },
            async submitListing() {
                this.submitting = true;
                try {
                    await api.post('?action=createListing', {
                        ...this.newListing,
                        user_id: this.userId
                    });
                    alert('Annonce créée avec succès!');
                    this.closeCreateModal();
                    await this.fetchMyListings();
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la création');
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
            async toggleStatus(listing) {
                const newStatus = listing.status === 'Actif' ? 'Inactif' : 'Actif';
                try {
                    await api.post('?action=updateListingStatus', {
                        id: listing.id,
                        status: newStatus
                    });
                    listing.status = newStatus;
                } catch (error) {
                    console.error('Erreur:', error);
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

    .dark-mode .border-gray-300 {
        border-color: #475569 !important;
    }

    .dark-mode input,
    .dark-mode select {
        background-color: var(--bg-dark-secondary) !important;
        color: #F9FAFB !important;
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

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>