<?php $title = "AmPay - Mes Parrainages"; ?>

<?php
ob_start(); ?>

<div id="app">
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 no-print">
        <?php include __DIR__ . '/../sidebar.php'; ?>

        <div class="flex-1 md:ml-64 flex flex-col h-screen overflow-hidden">
            <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print flex-shrink-0">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Mes Parrainages</h1>
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
                <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center no-print">
                    Bonjour
                    <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                        {{ capitalizeFirstLetter(user_first_name ) }} {{ capitalizeFirstLetter( user_last_name) }}
                    </span>
                </div>
                <!-- Updated gradient from purple-indigo to green tones to match main style -->
                <div class="mb-8 mt-3 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl shadow-xl p-8 text-white no-print">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Parrainez vos amis!</h2>
                            <p class="text-emerald-100">Gagnez des récompenses en invitant vos proches</p>
                        </div>
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-gift text-4xl"></i>
                        </div>
                    </div>

                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 mb-6">
                        <label class="block text-sm font-medium mb-3">Votre lien de parrainage</label>
                        <div class="flex gap-3">
                            <input :value="referralLink" readonly class="flex-1 px-4 py-3 bg-white text-gray-900 rounded-lg font-mono text-sm">
                            <!-- Updated button color from purple to green -->
                            <button @click="copyLink" class="px-6 py-3 bg-white text-green-600 rounded-lg font-semibold hover:bg-green-50 transition-colors">
                                <i class="fas fa-copy mr-2"></i>{{ copied ? 'Copié!' : 'Copier' }}
                            </button>
                        </div>
                    </div>

                    <div>
                        <p class="text-sm font-medium mb-3">Partager sur</p>
                        <div class="flex flex-wrap gap-3">
                            <button @click="shareOnWhatsApp" class="flex items-center gap-2 px-6 py-3 bg-green-500 hover:bg-green-600 rounded-lg font-semibold transition-colors">
                                <i class="fab fa-whatsapp text-xl"></i>
                                WhatsApp
                            </button>
                            <button @click="shareOnFacebook" class="flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition-colors">
                                <i class="fab fa-facebook text-xl"></i>
                                Facebook
                            </button>
                            <button @click="shareOnTwitter" class="flex items-center gap-2 px-6 py-3 bg-sky-500 hover:bg-sky-600 rounded-lg font-semibold transition-colors">
                                <i class="fab fa-twitter text-xl"></i>
                                Twitter
                            </button>
                            <button @click="shareByEmail" class="flex items-center gap-2 px-6 py-3 bg-gray-700 hover:bg-gray-800 rounded-lg font-semibold transition-colors">
                                <i class="fas fa-envelope text-xl"></i>
                                Email
                            </button>
                            <button @click="shareOnLinkedIn" class="flex items-center gap-2 px-6 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg font-semibold transition-colors">
                                <i class="fab fa-linkedin text-xl"></i>
                                LinkedIn
                            </button>
                        </div>
                    </div>
                </div>


                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8 no-print">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-friends text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ mySponsorships.length }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Mes Parrainages</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ activeSponsored }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Filleuls Actifs</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-2">
                            <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-trophy text-xl"></i>
                            </div>
                        </div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ totalRewards }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Points de Récompense</div>
                    </div>
                </div>

                <!-- Sponsorships List -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <!-- Added print-only title -->
                    <div class="hidden print-only mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 text-center">Liste des Filleuls</h1>
                        <p class="text-sm text-gray-600 text-center mt-2">{{ new Date().toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' }) }}</p>
                    </div>

                    <div class="flex items-center justify-between mb-6 no-print">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            <i class="fas fa-list mr-2 text-primary"></i>Mes Filleuls
                        </h3>
                        <!-- Added print button -->
                        <button @click="printList" class="no-print px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors flex items-center gap-2">
                            <i class="fas fa-print"></i>
                            Imprimer
                        </button>
                    </div>

                    <!-- Added search and filter section -->
                    <div class="no-print mb-6 space-y-4">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <input
                                        v-model="searchQuery"
                                        type="text"
                                        placeholder="Rechercher par nom ou email..."
                                        class="w-full px-4 py-2 pl-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                </div>
                            </div>
                            <div class="sm:w-48">
                                <select
                                    v-model="statusFilter"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="all">Tous les statuts</option>
                                    <option value="Actif">Actif</option>
                                    <option value="Inactif">Inactif</option>
                                </select>
                            </div>
                            <div class="sm:w-48">
                                <select
                                    v-model="sortBy"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="date-desc">Plus récent</option>
                                    <option value="date-asc">Plus ancien</option>
                                    <option value="name-asc">Nom (A-Z)</option>
                                    <option value="name-desc">Nom (Z-A)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div v-if="filteredSponsorships.length === 0" class="text-center py-12">
                        <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                            {{ mySponsorships.length === 0 ? 'Aucun filleul pour le moment' : 'Aucun résultat trouvé' }}
                        </h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            {{ mySponsorships.length === 0 ? 'Partagez votre lien pour commencer à parrainer' : 'Essayez de modifier vos critères de recherche' }}
                        </p>
                    </div>

                    <div v-else class="space-y-4">
                        <!-- Updated to use paginatedSponsorships instead of mySponsorships -->
                        <div v-for="sponsorship in paginatedSponsorships" :key="sponsorship.id" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-white text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                        {{ sponsorship.sponsored_first_name }} {{ sponsorship.sponsored_last_name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ sponsorship.sponsored_email }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-calendar mr-1"></i>{{ formatDate(sponsorship.created_at) }}
                                    </div>
                                </div>
                            </div>
                            <span :class="['px-3 py-1 rounded-full text-xs font-semibold', sponsorship.status === 'Actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300']">
                                {{ sponsorship.status === 'Actif' ? 'Actif' : 'Inactif' }}
                            </span>
                        </div>
                    </div>

                    <!-- Added pagination controls -->
                    <div v-if="totalPages > 1" class="no-print mt-6 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 pt-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Affichage {{ startIndex + 1 }}-{{ endIndex }} sur {{ filteredSponsorships.length }} filleuls
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                @click="currentPage--"
                                :disabled="currentPage === 1"
                                :class="['px-3 py-1 rounded-lg font-medium transition-colors', currentPage === 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-700' : 'bg-green-600 text-white hover:bg-green-700']">
                                <i class="fas fa-chevron-left"></i>
                            </button>

                            <div class="flex items-center gap-1">
                                <button
                                    v-for="page in visiblePages"
                                    :key="page"
                                    @click="currentPage = page"
                                    :class="['px-3 py-1 rounded-lg font-medium transition-colors', currentPage === page ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600']">
                                    {{ page }}
                                </button>
                            </div>

                            <button
                                @click="currentPage++"
                                :disabled="currentPage === totalPages"
                                :class="['px-3 py-1 rounded-lg font-medium transition-colors', currentPage === totalPages ? 'bg-gray-100 text-gray-400 cursor-not-allowed dark:bg-gray-700' : 'bg-green-600 text-white hover:bg-green-700']">
                                <i class="fas fa-chevron-right"></i>
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
        baseURL: 'http://127.0.0.1/ampay/index.php'
    });

    createApp({
        data() {
            return {
                darkMode: false,
                sidebarOpen: false,
                mySponsorships: [],
                userId: null,
                copied: false,
                userId: <?= json_encode($_SESSION['id'] ?? ''); ?>,
                user_first_name: <?= json_encode($_SESSION['first_name'] ?? ''); ?>,
                user_last_name: <?= json_encode($_SESSION['last_name'] ?? ''); ?>,
                user_referral_link: <?= json_encode($_SESSION['referral_link'] ?? ''); ?>,
                searchQuery: '',
                statusFilter: 'all',
                sortBy: 'date-desc',
                currentPage: 1,
                itemsPerPage: 10
            };
        },
        computed: {
            referralLink() {
                return (this.user_referral_link);
            },

            activeSponsored() {
                return this.mySponsorships.filter(s => s.status === 'Actif').length;
            },
            totalRewards() {
                return this.mySponsorships.length * 100; // 100 points per referral
            },
            filteredSponsorships() {
                let filtered = [...this.mySponsorships];
                // Apply search filter
                if (this.searchQuery) {
                    const query = this.searchQuery.toLowerCase();
                    filtered = filtered.filter(s =>
                        s.sponsored_first_name.toLowerCase().includes(query) ||
                        s.sponsored_last_name.toLowerCase().includes(query) ||
                        s.sponsored_email.toLowerCase().includes(query)
                    );
                }

                // Apply status filter
                if (this.statusFilter !== 'all') {
                    filtered = filtered.filter(s => s.status === this.statusFilter);
                }

                // Apply sorting
                filtered.sort((a, b) => {
                    switch (this.sortBy) {
                        case 'date-desc':
                            return new Date(b.created_at) - new Date(a.created_at);
                        case 'date-asc':
                            return new Date(a.created_at) - new Date(b.created_at);
                        case 'name-asc':
                            return (a.sponsored_first_name + a.sponsored_last_name).localeCompare(
                                b.sponsored_first_name + b.sponsored_last_name
                            );
                        case 'name-desc':
                            return (b.sponsored_first_name + b.sponsored_last_name).localeCompare(
                                a.sponsored_first_name + a.sponsored_last_name
                            );
                        default:
                            return 0;
                    }
                });

                return filtered;
            },
            totalPages() {
                const pages = Math.ceil(this.filteredSponsorships.length / this.itemsPerPage);
                console.log('[v0] Total pages:', pages);
                console.log('[v0] Filtered sponsorships:', this.filteredSponsorships.length);
                console.log('[v0] Items per page:', this.itemsPerPage);
                return pages;
            },
            paginatedSponsorships() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                const end = start + this.itemsPerPage;
                const paginated = this.filteredSponsorships.slice(start, end);
                console.log('[v0] Current page:', this.currentPage);
                console.log('[v0] Paginated items:', paginated.length);
                return paginated;
            },
            startIndex() {
                return (this.currentPage - 1) * this.itemsPerPage;
            },
            endIndex() {
                return Math.min(this.startIndex + this.itemsPerPage, this.filteredSponsorships.length);
            },
            visiblePages() {
                const pages = [];
                const maxVisible = 5;
                let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
                let end = Math.min(this.totalPages, start + maxVisible - 1);

                if (end - start < maxVisible - 1) {
                    start = Math.max(1, end - maxVisible + 1);
                }

                for (let i = start; i <= end; i++) {
                    pages.push(i);
                }
                return pages;
            }
        },
        watch: {
            searchQuery() {
                console.log('[v0] Search query changed, resetting to page 1');
                this.currentPage = 1;
            },
            statusFilter() {
                console.log('[v0] Status filter changed, resetting to page 1');
                this.currentPage = 1;
            },
            sortBy() {
                console.log('[v0] Sort changed, resetting to page 1');
                this.currentPage = 1;
            }
        },
        async mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }
            this.userId = <?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'null'; ?>;
            if (this.userId) await this.fetchMySponsorships();
            console.log(this.referralLink);
        },
        methods: {
            async fetchMySponsorships() {
                try {
                    const response = await api.get('?action=mySponsorshipsList');

                    let backendData = {};
                    if (response && response.data && typeof response.data === 'object') {
                        backendData = response.data;
                    } else {
                        console.error('Erreur backend: réponse invalide', response.data);
                        this.mySponsorships = [];
                        return;
                    }

                    console.log("[v0] Raw backend response:", backendData);

                    if (backendData.success === true) {
                        this.mySponsorships = backendData.data || [];
                    } else {
                        console.error('Erreur backend:', backendData.message || 'Message backend non défini');
                        this.mySponsorships = [];
                    }

                } catch (error) {
                    console.error('Erreur réseau ou backend:', error);
                    this.mySponsorships = [];
                }
            },

            capitalizeFirstLetter(word) {
                if (!word) return '';
                return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
            },

            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            copyLink() {
                navigator.clipboard.writeText(this.referralLink);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            },
            shareOnWhatsApp() {
                const text = `Rejoignez AmPay et profitez de transferts d'argent sans frais! Utilisez mon lien: ${this.referralLink}`;
                window.open(`https://wa.me/?text=${encodeURIComponent(text)}`, '_blank');
            },
            shareOnFacebook() {
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(this.referralLink)}`, '_blank');
            },
            shareOnTwitter() {
                const text = `Rejoignez AmPay avec mon lien de parrainage!`;
                window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(this.referralLink)}`, '_blank');
            },
            shareByEmail() {
                const subject = 'Rejoignez AmPay!';
                const body = `Bonjour,\n\nJe vous invite à rejoindre AmPay pour des transferts d'argent sans frais.\n\nUtilisez mon lien de parrainage: ${this.referralLink}\n\nÀ bientôt!`;
                window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            },
            shareOnLinkedIn() {
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(this.referralLink)}`, '_blank');
            },
            formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
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

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    /* Enhanced print styles to show only the filleuls list */
    @media print {

        /* Hide everything by default */
        body * {
            visibility: hidden;
        }

        /* Show only the sponsorships list container and its children */
        .bg-white.dark\\:bg-gray-800.rounded-xl.shadow-sm.p-6,
        .bg-white.dark\\:bg-gray-800.rounded-xl.shadow-sm.p-6 * {
            visibility: visible;
        }

        /* Hide elements with no-print class */
        .no-print,
        .no-print * {
            display: none !important;
            visibility: hidden !important;
        }

        /* Show print-only elements */
        .print-only {
            display: block !important;
        }

        /* Position the list container at the top */
        .bg-white.dark\\:bg-gray-800.rounded-xl.shadow-sm.p-6 {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        /* Reset backgrounds and colors for print */
        body {
            background: white !important;
        }

        .bg-gray-50,
        .bg-gray-700,
        .dark\\:bg-gray-700 {
            background: white !important;
            border: 1px solid #e5e7eb !important;
        }

        .shadow-sm,
        .shadow-md,
        .shadow-xl {
            box-shadow: none !important;
        }

        .rounded-xl,
        .rounded-lg {
            border-radius: 8px !important;
        }

        /* Ensure text is readable when printed */
        .text-gray-900,
        .text-gray-100,
        .dark\\:text-gray-100 {
            color: #000 !important;
        }

        .text-gray-600,
        .text-gray-500,
        .text-gray-400,
        .dark\\:text-gray-400 {
            color: #666 !important;
        }

        /* Status badges */
        .bg-green-100 {
            background: #d1fae5 !important;
            border: 1px solid #10b981 !important;
        }

        .text-green-800 {
            color: #065f46 !important;
        }

        /* Print page breaks */
        .space-y-4>div {
            page-break-inside: avoid;
        }

        /* Remove hover effects */
        .hover\\:shadow-md {
            box-shadow: none !important;
        }
    }

    /* Hide print-only elements on screen */
    .print-only {
        display: none;
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>