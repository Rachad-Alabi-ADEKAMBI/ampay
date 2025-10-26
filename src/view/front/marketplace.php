<?php $title = "AmPay - Marketplace";

ob_start();

$isAuthenticated = isset($_SESSION['id']); // true ou false
echo $isAuthenticated;

?>
<script>
    // Injecte une vraie valeur booléenne JS (pas une chaîne)
    window.isAuthenticated = <?php echo json_encode($isAuthenticated); ?>;
    console.log("Auth depuis PHP:", window.isAuthenticated);
</script>

<div id="app" v-cloak>

    <?php include 'header.php'; ?>

    <div class="pt-24 pb-12 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="mb-8 fade-in">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">{{ t.marketplace_title }}</h1>
                <p class="text-lg sm:text-xl text-gray-600">{{ t.marketplace_subtitle }}</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Offers -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 mb-1">{{ t.total_offers }}</p>
                            <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ stats.totalOffers }}</p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-green-200">
                            <i class="fas fa-hand-holding-usd text-green-700 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Requests -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 mb-1">{{ t.total_requests }}</p>
                            <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ stats.totalRequests }}</p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-yellow-200">
                            <i class="fas fa-hand-holding-heart text-yellow-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Countries -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 mb-1">{{ t.active_countries }}</p>
                            <p class="text-2xl sm:text-3xl font-bold text-primary">{{ stats.activeCountries }}</p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-200">
                            <i class="fas fa-globe-africa text-blue-700 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Active Cities -->
                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-600 mb-1">{{ t.active_cities }}</p>
                            <p class="text-2xl sm:text-3xl font-bold text-primary">{{ stats.activeCities }}</p>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-200">
                            <i class="fas fa-city text-purple-700 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>



            <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-filter mr-2 text-primary"></i>{{ t.filters_title }}
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i>{{ t.search_placeholder }}
                        </label>
                        <input v-model="filters.search" @input="applyFilters" type="text" placeholder="Ville..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-filter mr-1"></i>{{ t.type_all }}
                        </label>
                        <select v-model="filters.type" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">{{ t.type_all }}</option>
                            <option value="Offre">{{ t.type_offers }}</option>
                            <option value="Demande">{{ t.type_requests }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-coins mr-1"></i>{{ t.currency_all }}
                        </label>
                        <select v-model="filters.currency" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">{{ t.currency_all }}</option>
                            <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-money-bill-wave mr-1"></i>{{ t.max_amount }}
                        </label>
                        <input v-model.number="filters.maxAmount" @input="applyFilters" type="number" placeholder="Illimité" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-globe-africa mr-1"></i>{{ t.country_all }}
                        </label>
                        <select v-model="filters.country" @change="onCountryChange" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">{{ t.country_all }}</option>
                            <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>{{ t.city_all }}
                        </label>
                        <select v-model="filters.city" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" :disabled="!filters.country">
                            <option value="">{{ t.city_all }}</option>
                            <option v-for="city in availableCities" :key="city" :value="city">{{ city }}</option>
                        </select>
                    </div>
                </div>

                <!-- Updated color filter to use green for offers and yellow for demands -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        <i class="fas fa-clock mr-1"></i>{{ t.filter_delay }}
                    </label>
                    <div class="flex flex-wrap gap-3">
                        <button @click="toggledelayFilter('all')" :class="['color-filter-btn', filters.delay === 'all' ? 'active' : '']" style="background: linear-gradient(135deg, #10B981, #F59E0B, #EF4444);" title="Tous">
                            <span class="sr-only">Tous</span>
                        </button>
                        <button @click="toggledelayFilter('Urgent')" :class="['color-filter-btn', filters.delay === 'Urgent' ? 'active' : '']" style="background-color: #10B981;" title="Urgent">
                            <span class="sr-only">Urgent</span>
                        </button>
                        <button @click="toggledelayFilter('Deux semaines')" :class="['color-filter-btn', filters.delay === 'Deux semaines' ? 'active' : '']" style="background-color: #F59E0B;" title="Deux semaines">
                            <span class="sr-only">Deux semaines</span>
                        </button>
                        <button @click="toggledelayFilter('Nulle')" :class="['color-filter-btn', filters.delay === 'Nulle' ? 'active' : '']" style="background-color: #EF4444;" title="Nulle">
                            <span class="sr-only">Nulle</span>
                        </button>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span> Urgent
                        <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 ml-3 mr-1"></span> Deux semaines
                        <span class="inline-block w-3 h-3 rounded-full bg-red-500 ml-3 mr-1"></span> Nulle
                    </p>
                </div>
            </div>

            <!-- Updated listing cards to show ID instead of user name and use green/yellow colors -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div v-for="listing in paginatedListings" :key="listing.id"
                    class="bg-white rounded-xl shadow-sm overflow-hidden card-hover fade-in"
                    :class="getListingBorderClass(listing)">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span :class="getListingBadgeClass(listing)" class="px-3 py-1 rounded-full text-sm font-semibold">
                                <i :class="getListingIcon(listing)" class="mr-1"></i>
                                {{ listing.type }}
                            </span>
                        </div>

                        <div class="flex items-center mb-4">
                            <div :class="listing.type === 'Offre' ? 'bg-green-500' : 'bg-yellow-500'" class="w-12 h-12 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-hashtag text-white"></i>
                            </div>
                            <div class="min-w-0">
                                <!-- Changed from "Annonce #{{ listing.id }}" to just listing.id -->
                                <p class="font-semibold text-gray-900 truncate">Nouvelle annonce</p>
                                <p class="text-sm text-gray-500">
                                    <i class="fas fa-star text-yellow-500 mr-1"></i>{{ listing.ratings }}
                                </p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="country-badge mb-2">
                                <i class="fas fa-flag" style="color: var(--primary);"></i>
                                <span class="font-semibold text-gray-900">{{ listing.country }}</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-map-marker-alt w-5" style="color: var(--primary);"></i>
                                <span class="font-medium">{{ listing.city }}</span>
                            </div>
                        </div>

                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Montant</span>
                                <div class="flex items-center">
                                    <i class="fas fa-coins text-primary mr-2"></i>
                                    <span class="text-sm text-gray-600">{{ listing.currency }}</span>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 mt-1">
                                {{ formatCurrency(listing.amount) }}
                            </div>
                        </div>

                        <div class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-clock mr-1"></i>{{ listing.timeAgo }}
                        </div>

                        <button @click="openContactModal(listing)" :class="listing.type === 'Offre' ? 'bg-green-500 hover:bg-green-600' : 'bg-yellow-500 hover:bg-yellow-600'" class="w-full py-3 text-white rounded-lg font-semibold transition-colors">
                            <i class="fas fa-comment mr-2"></i>{{ t.contact_button }}
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="filteredListings.length === 0" class="text-center py-16">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ t.no_results }}</h3>
                <p class="text-gray-600 mb-6">{{ t.reset_filters }}</p>
                <button @click="resetFilters" class="px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    <i class="fas fa-redo mr-2"></i>{{ t.reset_filters }}
                </button>
            </div>

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

    <!-- Simplified contact modal with only message field and close button -->
    <div v-if="showContactModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay" @click.self="closeContactModal">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-handshake text-primary mr-2"></i>{{ t.contact_modal_title }}
                </h3>
                <button @click="closeContactModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="selectedListing" class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-3">
                    <div :class="selectedListing.type === 'Offre' ? 'bg-green-500' : 'bg-yellow-500'" class="w-12 h-12 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-hashtag text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Nouvelle annonce</p>
                        <p class="text-sm text-gray-600">{{ selectedListing.city }}, {{ selectedListing.country }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span :class="getListingBadgeClass(selectedListing)" class="px-3 py-1 rounded-full text-sm font-semibold">
                        {{ selectedListing.type }}
                    </span>
                    <span class="text-xl font-bold text-gray-900">
                        {{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}
                    </span>
                </div>
            </div>

            <form @submit.prevent="submitContactRequest" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment mr-1 text-primary"></i>{{ t.message_label }}
                    </label>
                    <textarea v-model="contactRequest.message" rows="4" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Votre message..."></textarea>
                </div>

                <button type="submit" :disabled="contactRequestSubmitting" class="w-full py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ contactRequestSubmitting ? t.sending : t.send_request }}
                </button>

                <div v-if="contactRequestSuccess" class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    <i class="fas fa-check-circle mr-2"></i>{{ t.success_message }}
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 primary-gradient rounded-lg flex items-center justify-center">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                        <span class="text-2xl font-bold">AMPAY</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">Transferts d'argent sans intermédiaire entre l'Afrique et l'Europe.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-primary transition-colors">Accueil</a></li>
                        <li><a href="marketplace.php" class="text-gray-400 hover:text-primary transition-colors">Marketplace</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Support</h4>
                    <ul class="space-y-2">
                        <li><a href="#faq" class="text-gray-400 hover:text-primary transition-colors">FAQ</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-primary transition-colors">Contact</a></li>
                        <li><a href="dashboard.php" class="text-gray-400 hover:text-primary transition-colors">tableau de bord</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Suivez-nous</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 AMPAY. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</div>

<script>
    const {
        createApp
    } = Vue;

    const api = axios.create({
        baseURL: 'index.php?'
    });

    createApp({
        data() {
            return {
                darkMode: false,
                currentLang: 'fr',
                mobileMenuOpen: false,
                showContactModal: false,
                selectedListing: null,
                contactRequestSubmitting: false,
                contactRequestSuccess: false,
                contactRequest: {
                    message: ''
                },
                filters: {
                    search: '',
                    country: '',
                    city: '',
                    currency: '',
                    type: '',
                    maxAmount: null,
                    delay: 'all'
                },
                currentPage: 1,
                itemsPerPage: 9,
                countries: [],
                citiesByCountry: {},
                currencies: [],
                listings: [],
                isAuthenticated: !!window.isAuthenticated,
                translations: {
                    fr: {
                        marketplace_title: 'Marketplace',
                        marketplace_subtitle: 'Trouvez des offres et demandes de transfert près de chez vous',
                        total_offers: 'Total Offres',
                        total_requests: 'Total Demandes',
                        active_countries: 'Pays actifs',
                        active_cities: 'Villes actives',
                        filters_title: 'Filtres',
                        search_placeholder: 'Ville...',
                        type_all: 'Tous',
                        type_offers: 'Offres',
                        type_requests: 'Demandes',
                        currency_all: 'Toutes',
                        max_amount: 'Montant max',
                        country_all: 'Tous les pays',
                        city_all: 'Toutes les villes',
                        filter_delay: 'Filtrer par délai',
                        no_results: 'Aucun résultat trouvé',
                        reset_filters: 'Réinitialiser les filtres',
                        contact_button: 'Mettre en contact',
                        contact_modal_title: 'Mise en contact',
                        message_label: 'Message',
                        send_request: 'Envoyer la demande',
                        sending: 'Envoi en cours...',
                        success_message: 'Demande envoyée ! Nous vous mettrons en contact sous peu.'
                    },
                    en: {
                        marketplace_title: 'Marketplace',
                        marketplace_subtitle: 'Find transfer offers and requests near you',
                        total_offers: 'Total Offers',
                        total_requests: 'Total Requests',
                        active_countries: 'Active Countries',
                        active_cities: 'Active Cities',
                        filters_title: 'Filters',
                        search_placeholder: 'City...',
                        type_all: 'All',
                        type_offers: 'Offers',
                        type_requests: 'Requests',
                        currency_all: 'All',
                        max_amount: 'Max amount',
                        country_all: 'All countries',
                        city_all: 'All cities',
                        filter_delay: 'Filter by delay',
                        no_results: 'No results found',
                        reset_filters: 'Reset filters',
                        contact_button: 'Contact',
                        contact_modal_title: 'Contact',
                        message_label: 'Message',
                        send_request: 'Send request',
                        sending: 'Sending...',
                        success_message: 'Request sent! We will contact you soon.'
                    }
                }
            };
        },
        computed: {
            t() {
                return this.translations[this.currentLang];
            },
            availableCities() {
                return this.filters.country ? this.citiesByCountry[this.filters.country] || [] : [];
            },
            filteredListings() {
                let filtered = this.listings;

                if (this.filters.search) {
                    filtered = filtered.filter(l =>
                        l.city.toLowerCase().includes(this.filters.search.toLowerCase()) ||
                        l.country.toLowerCase().includes(this.filters.search.toLowerCase())
                    );
                }

                if (this.filters.country) {
                    filtered = filtered.filter(l => l.country === this.filters.country);
                }

                if (this.filters.city) {
                    filtered = filtered.filter(l => l.city === this.filters.city);
                }

                if (this.filters.currency) {
                    filtered = filtered.filter(l => l.currency === this.filters.currency);
                }

                if (this.filters.type) {
                    filtered = filtered.filter(l => l.type === this.filters.type);
                }

                if (this.filters.maxAmount) {
                    filtered = filtered.filter(l => parseFloat(l.amount) <= this.filters.maxAmount);
                }

                if (this.filters.delay !== 'all') {
                    filtered = filtered.filter(l => l.delay === this.filters.delay);
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
                    totalOffers: this.listings.filter(l => l.type === 'Offre').length,
                    totalRequests: this.listings.filter(l => l.type === 'Demande').length,
                    activeCountries: [...new Set(this.listings.map(l => l.country))].length,
                    activeCities: [...new Set(this.listings.map(l => l.city))].length
                };
            }
        },
        mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            console.log(this.isAuthenticated);
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }
            const savedLang = localStorage.getItem('language');
            if (savedLang) {
                this.currentLang = savedLang;
            }
            console.log('isAuthenticated (vue):', this.isAuthenticated);

            this.fetchListings();
        },
        methods: {
            async fetchListings() {
                try {
                    const response = await api.get('', {
                        params: {
                            action: 'allListings'
                        }
                    });
                    const data = response.data || [];

                    // Process listings and add timeAgo
                    this.listings = data.map(listing => {
                        const createdDate = new Date(listing.created_at);
                        const now = new Date();
                        const diffHours = Math.floor((now - createdDate) / (1000 * 60 * 60));
                        return {
                            ...listing,
                            timeAgo: diffHours < 1 ?
                                "Il y a moins d'1h" : diffHours < 24 ?
                                `Il y a ${diffHours}h` : `Il y a ${Math.floor(diffHours / 24)} jour${Math.floor(diffHours / 24) > 1 ? 's' : ''}`
                        };
                    });

                    // Extract unique countries
                    this.countries = [...new Set(data.map(l => l.country))].sort();

                    // Extract unique cities by country
                    this.citiesByCountry = {};
                    data.forEach(listing => {
                        if (!this.citiesByCountry[listing.country]) {
                            this.citiesByCountry[listing.country] = [];
                        }
                        if (!this.citiesByCountry[listing.country].includes(listing.city)) {
                            this.citiesByCountry[listing.country].push(listing.city);
                        }
                    });

                    // Sort cities for each country
                    Object.keys(this.citiesByCountry).forEach(country => {
                        this.citiesByCountry[country].sort();
                    });

                    // Extract unique currencies
                    this.currencies = [...new Set(data.map(l => l.currency))].sort();

                } catch (error) {
                    console.error('Erreur lors du chargement des listings:', error);
                    this.listings = [];
                }
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            toggleLanguage() {
                this.currentLang = this.currentLang === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLang);
            },
            toggleMobileMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
            },
            onCountryChange() {
                this.filters.city = '';
                this.applyFilters();
            },
            applyFilters() {
                this.currentPage = 1;
            },
            toggledelayFilter(delay) {
                this.filters.delay = delay;
                this.applyFilters();
            },
            resetFilters() {
                this.filters = {
                    search: '',
                    country: '',
                    city: '',
                    currency: '',
                    type: '',
                    maxAmount: null,
                    delay: 'all'
                };
                this.applyFilters();
            },
            formatCurrency(amount) {
                return new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            },
            getListingBorderClass(listing) {
                return listing.type === 'Offre' ? 'border-l-4 border-green-500' : 'border-l-4 border-yellow-500';
            },
            getListingBadgeClass(listing) {
                return listing.type === 'Offre' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700';
            },
            getListingIcon(listing) {
                return listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart';
            },
            openContactModal(listing) {
                if (!this.isAuthenticated) {
                    alert('Veuillez vous connecter pour contacter un annonceur.');
                    return;
                }
                this.selectedListing = listing;
                this.showContactModal = true;
                this.contactRequestSuccess = false;
            },
            closeContactModal() {
                this.showContactModal = false;
                this.selectedListing = null;
                this.contactRequest = {
                    message: ''
                };
                this.contactRequestSuccess = false;
            },
            async submitContactRequest() {
                if (!this.contactRequest.message.trim() || !this.selectedListing) return;

                this.contactRequestSubmitting = true;
                this.contactRequestSuccess = false;



                try {
                    const response = await api.post(
                        '', // URL relative
                        {
                            message: this.contactRequest.message,
                            listing_id: this.selectedListing.listing_id
                        }, {
                            params: {
                                action: 'contactRequest'
                            },
                            headers: {
                                'Content-Type': 'application/json'
                            } // important
                        }
                    );

                    this.contactRequestSuccess = true;
                    this.contactRequest.message = ''; // Réinitialise le message après succès
                } catch (error) {
                    console.error('Erreur lors de l’envoi de la demande de contact :', error);
                    alert('Une erreur est survenue. Veuillez réessayer.');
                } finally {
                    this.contactRequestSubmitting = false;
                }
            },

            previousPage() {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },
            nextPage() {
                if (this.currentPage < this.totalPages) {
                    this.currentPage++;
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
            },
            goToPage(page) {
                this.currentPage = page;
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }
        }
    }).mount('#app');
</script>

<style>
    :root {
        --primary: #10B981;
        --primary-dark: #059669;
        --accent: #F59E0B;
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

    .dark-mode .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3) !important;
    }

    /* Fix dark mode input visibility */
    .dark-mode input,
    .dark-mode select,
    .dark-mode textarea {
        background-color: #1E293B !important;
        color: #F9FAFB !important;
        border-color: #475569 !important;
    }

    .dark-mode input::placeholder,
    .dark-mode textarea::placeholder {
        color: #64748B !important;
    }

    /* Fixed icon colors - white icons stay white, sun icon stays yellow */
    .bg-green-100 i,
    .bg-yellow-100 i,
    .bg-green-500 i,
    .bg-yellow-500 i,
    .primary-gradient i {
        color: white !important;
    }

    .text-yellow-400 {
        color: #FBBF24 !important;
    }

    .text-primary i {
        color: var(--primary) !important;
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

    .dark-mode .card-hover:hover {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }

    .country-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        border-radius: 9999px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .color-filter-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 3px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .color-filter-btn:hover {
        transform: scale(1.1);
    }

    .color-filter-btn.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }

    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out forwards;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-content {
        animation: modalSlideIn 0.3s ease-out;
    }
</style>

<style>
    [v-cloak] {
        display: none;
    }
</style>

<?php $content = ob_get_clean(); ?>

<?php require './src/view/layout.php'; ?>