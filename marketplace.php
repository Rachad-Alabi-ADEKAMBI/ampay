<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace - AMPAY</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .dark-mode i {
            color: inherit;
        }

        .dark-mode .text-gray-600 i,
        .dark-mode .text-gray-700 i {
            color: #94A3B8 !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <?php include 'header.php'; ?>

        <div class="pt-24 pb-12 bg-gray-50 min-h-screen">
            <div class="container mx-auto px-4 sm:px-6">
                <div class="mb-8 fade-in">
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Marketplace</h1>
                    <p class="text-lg sm:text-xl text-gray-600">Trouvez des offres et demandes de transfert près de chez vous</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Offres</p>
                                <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ stats.totalOffers }}</p>
                            </div>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-hand-holding-usd text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Demandes</p>
                                <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ stats.totalRequests }}</p>
                            </div>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-hand-holding-heart text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 mb-1">Pays actifs</p>
                                <p class="text-2xl sm:text-3xl font-bold text-primary">{{ stats.activeCountries }}</p>
                            </div>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 text-primary rounded-full flex items-center justify-center">
                                <i class="fas fa-globe-africa text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 card-hover">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600 mb-1">Villes actives</p>
                                <p class="text-2xl sm:text-3xl font-bold text-primary">{{ stats.activeCities }}</p>
                            </div>
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 text-primary rounded-full flex items-center justify-center">
                                <i class="fas fa-city text-xl sm:text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <i class="fas fa-filter mr-2 text-primary"></i>Filtres
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-search mr-1"></i>Rechercher
                            </label>
                            <input v-model="filters.search" @input="applyFilters" type="text" placeholder="Nom, ville..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-filter mr-1"></i>Type
                            </label>
                            <select v-model="filters.type" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Tous</option>
                                <option value="offer">Offres</option>
                                <option value="request">Demandes</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-coins mr-1"></i>Devise
                            </label>
                            <select v-model="filters.currency" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Toutes</option>
                                <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-money-bill-wave mr-1"></i>Montant max
                            </label>
                            <input v-model.number="filters.maxAmount" @input="applyFilters" type="number" placeholder="Illimité" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-globe-africa mr-1"></i>Pays
                            </label>
                            <select v-model="filters.country" @change="onCountryChange" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Tous les pays</option>
                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-1"></i>Ville
                            </label>
                            <select v-model="filters.city" @change="applyFilters" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" :disabled="!filters.country">
                                <option value="">Toutes les villes</option>
                                <option v-for="city in availableCities" :key="city" :value="city">{{ city }}</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            <i class="fas fa-palette mr-1"></i>Filtrer par couleur d'indicateur
                        </label>
                        <div class="flex flex-wrap gap-3">
                            <button @click="toggleColorFilter('all')" :class="['color-filter-btn', filters.color === 'all' ? 'active' : '']" style="background: linear-gradient(135deg, #10B981, #3B82F6, #F59E0B);" title="Tous">
                                <span class="sr-only">Tous</span>
                            </button>
                            <button @click="toggleColorFilter('green')" :class="['color-filter-btn', filters.color === 'green' ? 'active' : '']" style="background-color: #10B981;" title="Offreurs avec disponibilité">
                                <span class="sr-only">Vert</span>
                            </button>
                            <button @click="toggleColorFilter('yellow')" :class="['color-filter-btn', filters.color === 'yellow' ? 'active' : '']" style="background-color: #F59E0B;" title="Offreurs sans disponibilité">
                                <span class="sr-only">Jaune</span>
                            </button>
                            <button @click="toggleColorFilter('blue')" :class="['color-filter-btn', filters.color === 'blue' ? 'active' : '']" style="background-color: #3B82F6;" title="Demandeurs">
                                <span class="sr-only">Bleu</span>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span> Offreur disponible
                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 ml-3 mr-1"></span> Offreur indisponible
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-500 ml-3 mr-1"></span> Demandeur
                        </p>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <div v-for="listing in paginatedListings" :key="listing.id"
                        class="bg-white rounded-xl shadow-sm overflow-hidden card-hover fade-in"
                        :class="getListingBorderClass(listing)">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span :class="getListingBadgeClass(listing)" class="px-3 py-1 rounded-full text-sm font-semibold">
                                    <i :class="getListingIcon(listing)" class="mr-1"></i>
                                    {{ listing.type === 'offer' ? 'Offre' : 'Demande' }}
                                </span>
                                <div :class="getIndicatorClass(listing)" class="w-3 h-3 rounded-full" :title="getIndicatorTitle(listing)"></div>
                            </div>

                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 primary-gradient rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-900 truncate">{{ listing.userName }}</p>
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>{{ listing.rating }} ({{ listing.reviews }})
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

                            <button @click="openContactModal(listing)" class="w-full py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                <i class="fas fa-comment mr-2"></i>Mettre en contact
                            </button>
                        </div>
                    </div>
                </div>

                <div v-if="filteredListings.length === 0" class="text-center py-16">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-bold text-gray-900 mb-2">Aucun résultat trouvé</h3>
                    <p class="text-gray-600 mb-6">Essayez de modifier vos filtres pour voir plus d'offres</p>
                    <button @click="resetFilters" class="px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        <i class="fas fa-redo mr-2"></i>Réinitialiser les filtres
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

        <div v-if="showContactModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay" @click.self="closeContactModal">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 modal-content">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-handshake text-primary mr-2"></i>Mise en contact
                    </h3>
                    <button @click="closeContactModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>

                <div v-if="selectedListing" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 primary-gradient rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ selectedListing.userName }}</p>
                            <p class="text-sm text-gray-600">{{ selectedListing.city }}, {{ selectedListing.country }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span :class="getListingBadgeClass(selectedListing)" class="px-3 py-1 rounded-full text-sm font-semibold">
                            {{ selectedListing.type === 'offer' ? 'Offre' : 'Demande' }}
                        </span>
                        <span class="text-xl font-bold text-gray-900">
                            {{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}
                        </span>
                    </div>
                </div>

                <form @submit.prevent="submitContactRequest" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-primary"></i>Votre nom
                        </label>
                        <input v-model="contactRequest.name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Jean Dupont">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1 text-primary"></i>Email
                        </label>
                        <input v-model="contactRequest.email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="jean@example.com">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1 text-primary"></i>Téléphone
                        </label>
                        <input v-model="contactRequest.phone" type="tel" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="+33 6 12 34 56 78">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment mr-1 text-primary"></i>Message (optionnel)
                        </label>
                        <textarea v-model="contactRequest.message" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Votre message..."></textarea>
                    </div>

                    <button type="submit" :disabled="contactRequestSubmitting" class="w-full py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ contactRequestSubmitting ? 'Envoi en cours...' : 'Envoyer la demande' }}
                    </button>

                    <div v-if="contactRequestSuccess" class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                        <i class="fas fa-check-circle mr-2"></i>Demande envoyée ! Nous vous mettrons en contact sous peu.
                    </div>
                </form>
            </div>
        </div>

        <?php include 'footer.php'; ?>
    </div>

    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    darkMode: false,
                    mobileMenuOpen: false,
                    showContactModal: false,
                    selectedListing: null,
                    contactRequestSubmitting: false,
                    contactRequestSuccess: false,
                    contactRequest: {
                        name: '',
                        email: '',
                        phone: '',
                        message: ''
                    },
                    filters: {
                        search: '',
                        country: '',
                        city: '',
                        currency: '',
                        type: '',
                        maxAmount: null,
                        color: 'all'
                    },
                    currentPage: 1,
                    itemsPerPage: 9,
                    countries: ['France', 'Sénégal', 'Côte d\'Ivoire', 'Nigeria', 'Ghana', 'Royaume-Uni', 'Allemagne', 'Bénin', 'Togo'],
                    citiesByCountry: {
                        'France': ['Paris', 'Lyon', 'Marseille', 'Toulouse'],
                        'Sénégal': ['Dakar', 'Thiès', 'Saint-Louis'],
                        'Côte d\'Ivoire': ['Abidjan', 'Bouaké', 'Yamoussoukro'],
                        'Nigeria': ['Lagos', 'Abuja', 'Port Harcourt'],
                        'Ghana': ['Accra', 'Kumasi', 'Tamale'],
                        'Royaume-Uni': ['Londres', 'Manchester', 'Birmingham'],
                        'Allemagne': ['Berlin', 'Munich', 'Hambourg'],
                        'Bénin': ['Cotonou', 'Porto-Novo', 'Parakou'],
                        'Togo': ['Lomé', 'Sokodé', 'Kara']
                    },
                    currencies: ['EUR', 'XOF', 'NGN', 'GHS', 'GBP'],
                    allListings: [{
                            id: 1,
                            type: 'offer',
                            userName: 'Jean Dupont',
                            rating: 4.8,
                            reviews: 23,
                            amount: 500,
                            currency: 'EUR',
                            country: 'France',
                            city: 'Paris',
                            timeAgo: 'Il y a 2h',
                            hasAvailability: true
                        },
                        {
                            id: 2,
                            type: 'request',
                            userName: 'Aminata Diallo',
                            rating: 4.9,
                            reviews: 45,
                            amount: 250000,
                            currency: 'XOF',
                            country: 'Sénégal',
                            city: 'Dakar',
                            timeAgo: 'Il y a 3h',
                            hasAvailability: false
                        },
                        {
                            id: 3,
                            type: 'offer',
                            userName: 'Kofi Mensah',
                            rating: 4.7,
                            reviews: 18,
                            amount: 2000,
                            currency: 'GHS',
                            country: 'Ghana',
                            city: 'Accra',
                            timeAgo: 'Il y a 5h',
                            hasAvailability: true
                        },
                        {
                            id: 4,
                            type: 'request',
                            userName: 'Marie Laurent',
                            rating: 5.0,
                            reviews: 67,
                            amount: 800,
                            currency: 'EUR',
                            country: 'France',
                            city: 'Paris',
                            timeAgo: 'Il y a 1h',
                            hasAvailability: false
                        },
                        {
                            id: 5,
                            type: 'offer',
                            userName: 'Adeola Okonkwo',
                            rating: 4.6,
                            reviews: 12,
                            amount: 150000,
                            currency: 'NGN',
                            country: 'Nigeria',
                            city: 'Lagos',
                            timeAgo: 'Il y a 4h',
                            hasAvailability: false
                        },
                        {
                            id: 6,
                            type: 'request',
                            userName: 'Pierre Martin',
                            rating: 4.8,
                            reviews: 34,
                            amount: 1200,
                            currency: 'EUR',
                            country: 'Allemagne',
                            city: 'Berlin',
                            timeAgo: 'Il y a 6h',
                            hasAvailability: false
                        },
                        {
                            id: 7,
                            type: 'offer',
                            userName: 'Fatou Sow',
                            rating: 4.9,
                            reviews: 56,
                            amount: 300000,
                            currency: 'XOF',
                            country: 'Côte d\'Ivoire',
                            city: 'Abidjan',
                            timeAgo: 'Il y a 2h',
                            hasAvailability: true
                        },
                        {
                            id: 8,
                            type: 'request',
                            userName: 'Sophie Dubois',
                            rating: 5.0,
                            reviews: 78,
                            amount: 950,
                            currency: 'EUR',
                            country: 'France',
                            city: 'Lyon',
                            timeAgo: 'Il y a 1h',
                            hasAvailability: false
                        },
                        {
                            id: 9,
                            type: 'offer',
                            userName: 'Yao Kouassi',
                            rating: 4.8,
                            reviews: 41,
                            amount: 180000,
                            currency: 'XOF',
                            country: 'Bénin',
                            city: 'Cotonou',
                            timeAgo: 'Il y a 3h',
                            hasAvailability: true
                        },
                        {
                            id: 10,
                            type: 'request',
                            userName: 'Moussa Kone',
                            rating: 4.7,
                            reviews: 21,
                            amount: 200000,
                            currency: 'XOF',
                            country: 'Togo',
                            city: 'Lomé',
                            timeAgo: 'Il y a 6h',
                            hasAvailability: false
                        },
                        {
                            id: 11,
                            type: 'offer',
                            userName: 'Kwame Asante',
                            rating: 4.6,
                            reviews: 15,
                            amount: 3500,
                            currency: 'GHS',
                            country: 'Ghana',
                            city: 'Kumasi',
                            timeAgo: 'Il y a 8h',
                            hasAvailability: false
                        },
                        {
                            id: 12,
                            type: 'request',
                            userName: 'Ibrahim Traoré',
                            rating: 4.9,
                            reviews: 52,
                            amount: 400000,
                            currency: 'XOF',
                            country: 'Sénégal',
                            city: 'Thiès',
                            timeAgo: 'Il y a 4h',
                            hasAvailability: false
                        },
                        {
                            id: 13,
                            type: 'offer',
                            userName: 'Emma Wilson',
                            rating: 4.8,
                            reviews: 38,
                            amount: 750,
                            currency: 'GBP',
                            country: 'Royaume-Uni',
                            city: 'Manchester',
                            timeAgo: 'Il y a 5h',
                            hasAvailability: true
                        },
                        {
                            id: 14,
                            type: 'request',
                            userName: 'Moussa Kone',
                            rating: 4.7,
                            reviews: 21,
                            amount: 200000,
                            currency: 'XOF',
                            country: 'Togo',
                            city: 'Lomé',
                            timeAgo: 'Il y a 6h',
                            hasAvailability: false
                        },
                        {
                            id: 15,
                            type: 'offer',
                            userName: 'Hans Mueller',
                            rating: 4.9,
                            reviews: 44,
                            amount: 1500,
                            currency: 'EUR',
                            country: 'Allemagne',
                            city: 'Munich',
                            timeAgo: 'Il y a 2h',
                            hasAvailability: true
                        }
                    ]
                };
            },
            computed: {
                availableCities() {
                    return this.filters.country ? this.citiesByCountry[this.filters.country] || [] : [];
                },
                filteredListings() {
                    let filtered = this.allListings;

                    if (this.filters.search) {
                        filtered = filtered.filter(l =>
                            l.city.toLowerCase().includes(this.filters.search.toLowerCase()) ||
                            l.userName.toLowerCase().includes(this.filters.search.toLowerCase()) ||
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
                        filtered = filtered.filter(l => l.amount <= this.filters.maxAmount);
                    }

                    if (this.filters.color !== 'all') {
                        filtered = filtered.filter(l => {
                            if (this.filters.color === 'green') {
                                return l.type === 'offer' && l.hasAvailability;
                            } else if (this.filters.color === 'yellow') {
                                return l.type === 'offer' && !l.hasAvailability;
                            } else if (this.filters.color === 'blue') {
                                return l.type === 'request';
                            }
                            return true;
                        });
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
                        totalOffers: this.allListings.filter(l => l.type === 'offer').length,
                        totalRequests: this.allListings.filter(l => l.type === 'request').length,
                        activeCountries: [...new Set(this.allListings.map(l => l.country))].length,
                        activeCities: [...new Set(this.allListings.map(l => l.city))].length
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
                toggleColorFilter(color) {
                    this.filters.color = color;
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
                        color: 'all'
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
                    if (listing.type === 'offer' && listing.hasAvailability) {
                        return 'border-l-4 border-green-500';
                    } else if (listing.type === 'offer' && !listing.hasAvailability) {
                        return 'border-l-4 border-yellow-500';
                    } else {
                        return 'border-l-4 border-blue-500';
                    }
                },
                getListingBadgeClass(listing) {
                    if (listing.type === 'offer') {
                        return 'bg-green-100 text-green-700';
                    } else {
                        return 'bg-blue-100 text-blue-700';
                    }
                },
                getListingIcon(listing) {
                    return listing.type === 'offer' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart';
                },
                getIndicatorClass(listing) {
                    if (listing.type === 'offer' && listing.hasAvailability) {
                        return 'bg-green-500 animate-pulse';
                    } else if (listing.type === 'offer' && !listing.hasAvailability) {
                        return 'bg-yellow-500';
                    } else {
                        return 'bg-blue-500 animate-spin border-2 border-blue-500 border-t-transparent rounded-full';
                    }
                },
                getIndicatorTitle(listing) {
                    if (listing.type === 'offer' && listing.hasAvailability) {
                        return 'Offreur avec disponibilité';
                    } else if (listing.type === 'offer' && !listing.hasAvailability) {
                        return 'Offreur sans disponibilité';
                    } else {
                        return 'Demandeur avec demande en cours';
                    }
                },
                openContactModal(listing) {
                    this.selectedListing = listing;
                    this.showContactModal = true;
                    this.contactRequestSuccess = false;
                },
                closeContactModal() {
                    this.showContactModal = false;
                    this.selectedListing = null;
                    this.contactRequest = {
                        name: '',
                        email: '',
                        phone: '',
                        message: ''
                    };
                    this.contactRequestSuccess = false;
                },
                submitContactRequest() {
                    this.contactRequestSubmitting = true;
                    setTimeout(() => {
                        this.contactRequestSubmitting = false;
                        this.contactRequestSuccess = true;
                        setTimeout(() => {
                            this.closeContactModal();
                        }, 2000);
                    }, 1500);
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
</body>

</html>