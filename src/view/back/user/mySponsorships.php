<?php $title = "AmPay - Mes Parrainages"; ?>

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
                <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center">
                    Bonjour
                    <span class="ml-1 font-semibold text-gray-900 dark:text-white">
                        {{ capitalizeFirstLetter(user_first_name ) }} {{ capitalizeFirstLetter( user_last_name) }}
                    </span>
                </div>
                <div class="mb-8 mt-3 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl shadow-xl p-8 text-white">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-3xl font-bold mb-2">Parrainez vos amis!</h2>
                            <p class="text-purple-100">Gagnez des récompenses en invitant vos proches</p>
                        </div>
                        <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <i class="fas fa-gift text-4xl"></i>
                        </div>
                    </div>

                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-6 mb-6">
                        <label class="block text-sm font-medium mb-3">Votre lien de parrainage</label>
                        <div class="flex gap-3">
                            <input :value="referralLink" readonly class="flex-1 px-4 py-3 bg-white text-gray-900 rounded-lg font-mono text-sm">
                            <button @click="copyLink" class="px-6 py-3 bg-white text-purple-600 rounded-lg font-semibold hover:bg-purple-50 transition-colors">
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


                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
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

                Sponsorships List
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        <i class="fas fa-list mr-2 text-primary"></i>Mes Filleuls
                    </h3>

                    <div v-if="mySponsorships.length === 0" class="text-center py-12">
                        <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Aucun filleul pour le moment</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">Partagez votre lien pour commencer à parrainer</p>
                    </div>

                    <div v-else class="space-y-4">
                        <div v-for="sponsorship in mySponsorships" :key="sponsorship.id" class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
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
                            <span :class="['px-3 py-1 rounded-full text-xs font-semibold', sponsorship.status === 'actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300']">
                                {{ sponsorship.status === 'Actif' ? 'Actif' : 'Inactif' }}
                            </span>
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
            };
        },
        computed: {
            referralLink() {
                return `https://ampay.com/register?ref=${this.userId || 'USER123'}`;
            },
            activeSponsored() {
                return this.mySponsorships.filter(s => s.status === 'Actif').length;
            },
            totalRewards() {
                return this.mySponsorships.length * 100; // 100 points per referral
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
        },
        methods: {
            async fetchMySponsorships() {
                try {
                    const response = await api.get('?action=mySponsorshipsList');

                    // Vérifie que la réponse est bien un objet JSON
                    let backendData = {};
                    if (response && response.data && typeof response.data === 'object') {
                        backendData = response.data;
                    } else {
                        console.error('Erreur backend: réponse invalide', response.data);
                        this.mySponsorships = [];
                        return;
                    }

                    console.log("Raw backend response:", backendData);

                    if (backendData.success === true) {
                        this.mySponsorships = backendData.data || [];
                        console.log("Filtered mySponsorships:", this.mySponsorships);
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

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>