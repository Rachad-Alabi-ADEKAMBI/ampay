<?php $title = "AmPay - Parrainages"; ?>


<?php


ob_start(); ?>
<div id="app">
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Sidebar code -->
        <?php include __DIR__ . '/../sidebar.php'; ?>

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
                                {{ t.sponsorships_list }}
                            </h1>
                        </div>
                        <!-- Added language switcher button next to theme toggle -->
                        <div class="flex items-center space-x-2">
                            <button @click="toggleLanguage" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">{{ currentLang === 'fr' ? 'EN' : 'FR' }}</span>
                            </button>
                            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto overflow-x-hidden p-4 sm:p-6">
                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <!-- Added translation for welcome message -->
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center">
                        {{ t.welcome }}
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                            Admin
                        </span>
                    </div>
                </div>

                <!-- Added translations for statistics cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-friends text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ allSponsorships.length }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.total_sponsorships }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ uniqueSponsors }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.active_sponsors }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ uniqueSponsored }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.sponsored_users }}</div>
                    </div>
                </div>

                <!-- Added translations for search and filter options -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <input v-model="searchTerm" @input="applyFilters" type="text" :placeholder="t.search_placeholder" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        <select v-model="sortBy" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="date">{{ t.sort_by_date }}</option>
                            <option value="sponsor">{{ t.sort_by_sponsor }}</option>
                            <option value="sponsored">{{ t.sort_by_sponsored }}</option>
                            <option value="most_sponsorships">{{ t.sort_by_most }}</option>
                        </select>
                    </div>
                    <!-- Added translations for filter banner -->
                    <div v-if="selectedUser" class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-filter text-blue-600 dark:text-blue-400"></i>
                                <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
                                    {{ t.filtered_by }}: {{ selectedUser.first_name }} {{ selectedUser.last_name }}
                                </span>
                            </div>
                            <button @click="clearUserFilter" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Added translations for table headers -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-900">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.sponsor }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.sponsored }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ t.date }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Updated hover state to match transactions page -->
                                <tr v-for="sponsorship in paginatedSponsorships" :key="sponsorship.id" class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <td :data-label="t.sponsor" class="px-6 py-4">
                                        <!-- Made sponsor name clickable to filter -->
                                        <div class="flex items-center gap-3 cursor-pointer" @click="filterByUser(sponsorship.sponsor_id, sponsorship.sponsor_first_name, sponsorship.sponsor_last_name)">
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate hover:text-primary transition-colors">
                                                    {{ capitalizeFirstLetter(sponsorship.sponsor_first_name )}}
                                                    {{ capitalizeAll(sponsorship.sponsor_last_name) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td :data-label="t.sponsored" class="px-6 py-4">
                                        <!-- Made sponsored name clickable to filter -->
                                        <div class="flex items-center gap-3 cursor-pointer" @click="filterByUser(sponsorship.sponsored_id, sponsorship.sponsored_first_name, sponsorship.sponsored_last_name)">
                                            <div class="min-w-0">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate hover:text-primary transition-colors">
                                                    {{ capitalizeFirstLetter(sponsorship.sponsored_first_name) }}
                                                    {{ capitalizeAll(sponsorship.sponsored_last_name) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td :data-label="t.date" class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ formatDate(sponsorship.created_at) }}
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Added translations for pagination -->
                    <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6 no-print">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <button @click="previousPage" :disabled="currentPage === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                {{ t.previous }}
                            </button>
                            <button @click="nextPage" :disabled="currentPage === totalPages" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                {{ t.next }}
                            </button>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 dark:text-gray-300">
                                    {{ t.showing }} <span class="font-medium">{{ startItem }}</span> {{ t.to }} <span class="font-medium">{{ endItem }}</span> {{ t.of }} <span class="font-medium">{{ totalItems }}</span> {{ t.results }}
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
                searchTerm: '',
                sortBy: 'date',
                sidebarOpen: false,
                currentPage: 1,
                itemsPerPage: 10,
                allSponsorships: [],
                selectedUser: null,
                currentLang: 'fr',
                translations: {
                    fr: {
                        sponsorships_list: 'Liste des parrainages',
                        welcome: 'Bonjour',
                        total_sponsorships: 'Total Parrainages',
                        active_sponsors: 'Parrains Actifs',
                        sponsored_users: 'Filleuls',
                        search_placeholder: 'Rechercher par nom...',
                        sort_by_date: 'Trier par date',
                        sort_by_sponsor: 'Trier par parrain',
                        sort_by_sponsored: 'Trier par filleul',
                        sort_by_most: 'Trier par plus de parrainages',
                        filtered_by: 'Filtré par',
                        sponsor: 'Parrain',
                        sponsored: 'Filleul',
                        date: 'Date',
                        previous: 'Précédent',
                        next: 'Suivant',
                        showing: 'Affichage de',
                        to: 'à',
                        of: 'sur',
                        results: 'résultats',
                        // Sidebar translations
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
                        sponsorships_list: 'Sponsorships List',
                        welcome: 'Hello',
                        total_sponsorships: 'Total Sponsorships',
                        active_sponsors: 'Active Sponsors',
                        sponsored_users: 'Sponsored Users',
                        search_placeholder: 'Search by name...',
                        sort_by_date: 'Sort by date',
                        sort_by_sponsor: 'Sort by sponsor',
                        sort_by_sponsored: 'Sort by sponsored',
                        sort_by_most: 'Sort by most sponsorships',
                        filtered_by: 'Filtered by',
                        sponsor: 'Sponsor',
                        sponsored: 'Sponsored',
                        date: 'Date',
                        previous: 'Previous',
                        next: 'Next',
                        showing: 'Showing',
                        to: 'to',
                        of: 'of',
                        results: 'results',
                        // Sidebar translations
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
            uniqueSponsors() {
                return [...new Set(this.allSponsorships.map(s => s.sponsor_id))].length;
            },
            uniqueSponsored() {
                return [...new Set(this.allSponsorships.map(s => s.sponsored_id))].length;
            },
            filteredSponsorships() {
                let filtered = this.allSponsorships;

                if (this.selectedUser) {
                    filtered = filtered.filter(s =>
                        s.sponsor_id === this.selectedUser.id ||
                        s.sponsored_id === this.selectedUser.id
                    );
                }

                if (this.searchTerm) {
                    filtered = filtered.filter(s =>
                        s.sponsor_first_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        s.sponsor_last_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        s.sponsored_first_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        s.sponsored_last_name?.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }

                if (this.sortBy === 'date') {
                    filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                } else if (this.sortBy === 'sponsor') {
                    filtered.sort((a, b) => a.sponsor_first_name.localeCompare(b.sponsor_first_name));
                } else if (this.sortBy === 'sponsored') {
                    filtered.sort((a, b) => a.sponsored_first_name.localeCompare(b.sponsored_first_name));
                } else if (this.sortBy === 'most_sponsorships') {
                    // Count sponsorships per sponsor and sort by count
                    const sponsorCounts = {};
                    this.allSponsorships.forEach(s => {
                        sponsorCounts[s.sponsor_id] = (sponsorCounts[s.sponsor_id] || 0) + 1;
                    });
                    filtered.sort((a, b) => {
                        const countA = sponsorCounts[a.sponsor_id] || 0;
                        const countB = sponsorCounts[b.sponsor_id] || 0;
                        return countB - countA;
                    });
                }

                return filtered;
            },
            paginatedSponsorships() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                return this.filteredSponsorships.slice(start, start + this.itemsPerPage);
            },
            totalPages() {
                return Math.ceil(this.filteredSponsorships.length / this.itemsPerPage);
            },
            totalItems() {
                return this.filteredSponsorships.length;
            },
            startItem() {
                return (this.currentPage - 1) * this.itemsPerPage + 1;
            },
            endItem() {
                return Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
            },
            visiblePages() {
                const pages = [],
                    total = this.totalPages,
                    current = this.currentPage;
                for (let i = 1; i <= total; i++)
                    if (i === 1 || i === total || (i >= current - 1 && i <= current + 1)) pages.push(i);
                return pages;
            },
            t() {
                return this.translations[this.currentLang];
            }
        },
        async mounted() {
            if (localStorage.getItem('darkMode') === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            const savedLang = localStorage.getItem('language');
            if (savedLang && (savedLang === 'fr' || savedLang === 'en')) {
                this.currentLang = savedLang;
            }

            await this.fetchSponsorships();
        },
        methods: {
            async fetchSponsorships() {
                try {
                    const response = await api.get('?action=allSponsorships');
                    this.allSponsorships = response.data || [];
                } catch (error) {
                    console.error('Erreur lors du chargement des parrainages:', error);
                    this.allSponsorships = [];
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
            toggleLanguage() {
                this.currentLang = this.currentLang === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLang);
                // Dispatch event to notify sidebar
                window.dispatchEvent(new CustomEvent('languageChanged', {
                    detail: this.currentLang
                }));
            },
            applyFilters() {
                this.currentPage = 1;
            },
            formatDate(dateString) {
                const locale = this.currentLang === 'fr' ? 'fr-FR' : 'en-US';
                return new Date(dateString).toLocaleDateString(locale, {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },
            printList() {
                window.print();
            },
            filterByUser(userId, firstName, lastName) {
                this.selectedUser = {
                    id: userId,
                    first_name: firstName,
                    last_name: lastName
                };
                this.currentPage = 1;
            },
            clearUserFilter() {
                this.selectedUser = null;
                this.currentPage = 1;
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

    /* Added input/select/textarea dark mode styles like transactions page */
    .dark-mode input,
    .dark-mode select,
    .dark-mode textarea {
        background-color: var(--bg-dark-secondary) !important;
        color: #F9FAFB !important;
    }

    .dark-mode tr:hover {
        background-color: var(--bg-gray-750) !important;
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