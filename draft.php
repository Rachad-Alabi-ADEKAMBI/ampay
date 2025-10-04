<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - AMPAY</title>
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
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <div id="app">
        <!-- Overlay mobile -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

        <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
            <!-- Sidebar -->
            <aside id="sidebar" class="sidebar fixed md:static w-64 bg-white dark:bg-gray-800 shadow-lg h-screen overflow-y-auto z-40">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-8">
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 primary-gradient rounded-lg flex items-center justify-center">
                                <i class="fas fa-bolt text-white text-xl"></i>
                            </div>
                            <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">AMPAY</span>
                        </div>
                        <button id="closeSidebar" class="md:hidden text-gray-600 dark:text-gray-300">
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
                        <a href="profile.html" class="flex items-center space-x-3 px-4 py-3 primary-gradient text-white rounded-lg">
                            <i class="fas fa-user"></i>
                            <span>Profil</span>
                        </a>
                        <a href="transactions.html" class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700 rounded-lg transition-colors">
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
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">Mon Profil</h1>
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
                    <div class="mb-8">
                        <p class="text-lg text-gray-600 dark:text-gray-400">Gérez vos informations personnelles et vos préférences</p>
                    </div>

                    <div class="grid lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-1">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 text-center card-hover">
                                <div class="w-32 h-32 primary-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-user text-white text-6xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ user.name }}</h2>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ user.email }}</p>
                                <div class="flex items-center justify-center space-x-2 mb-4">
                                    <i class="fas fa-star text-yellow-500"></i>
                                    <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ user.rating }}</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">({{ user.reviews }} avis)</span>
                                </div>
                                <span :class="['inline-block px-4 py-2 rounded-full text-sm font-semibold', user.type === 'offerer' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300']">
                                    {{ user.type === 'offerer' ? 'Offreur' : 'Demandeur' }}
                                </span>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mt-6 card-hover">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    <i class="fas fa-chart-line text-primary mr-2"></i>Statistiques
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Transactions</span>
                                        <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ user.stats.transactions }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Montant total</span>
                                        <span class="text-xl font-bold text-primary">{{ formatCurrency(user.stats.totalAmount) }} EUR</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-gray-600 dark:text-gray-400">Membre depuis</span>
                                        <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ user.memberSince }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-2 space-y-6">
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                        <i class="fas fa-user-edit text-primary mr-2"></i>Informations personnelles
                                    </h3>
                                    <button @click="editMode = !editMode" class="px-4 py-2 text-primary hover:bg-primary hover:text-white border border-primary rounded-lg transition-colors">
                                        <i :class="editMode ? 'fas fa-times' : 'fas fa-edit'" class="mr-2"></i>
                                        {{ editMode ? 'Annuler' : 'Modifier' }}
                                    </button>
                                </div>

                                <form @submit.prevent="saveProfile" class="space-y-4">
                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <i class="fas fa-user mr-1 text-primary"></i>Nom complet
                                            </label>
                                            <input v-model="user.name" :disabled="!editMode" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <i class="fas fa-envelope mr-1 text-primary"></i>Email
                                            </label>
                                            <input v-model="user.email" :disabled="!editMode" type="email" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                        </div>
                                    </div>

                                    <div class="grid sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <i class="fas fa-phone mr-1 text-primary"></i>Téléphone
                                            </label>
                                            <input v-model="user.phone" :disabled="!editMode" type="tel" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                                <i class="fas fa-flag mr-1 text-primary"></i>Pays
                                            </label>
                                            <select v-model="user.country" :disabled="!editMode" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>Ville
                                        </label>
                                        <input v-model="user.city" :disabled="!editMode" type="text" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>

                                    <div v-if="editMode" class="pt-4">
                                        <button type="submit" class="w-full sm:w-auto px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                                    <i class="fas fa-shield-alt text-primary mr-2"></i>Sécurité
                                </h3>
                                <div class="space-y-4">
                                    <button @click="changePassword" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <span class="flex items-center">
                                            <i class="fas fa-key text-primary mr-3"></i>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">Changer le mot de passe</span>
                                        </span>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </button>
                                    <button @click="enable2FA" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <span class="flex items-center">
                                            <i class="fas fa-mobile-alt text-primary mr-3"></i>
                                            <span class="font-medium text-gray-900 dark:text-gray-100">Authentification à deux facteurs</span>
                                        </span>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                                    <i class="fas fa-bell text-primary mr-2"></i>Notifications
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">Notifications par email</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Recevez des mises à jour par email</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input v-model="notifications.email" type="checkbox" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-gray-100">Notifications push</p>
                                            <p class="text-sm text-gray-600 dark:text-gray-400">Recevez des notifications sur votre appareil</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input v-model="notifications.push" type="checkbox" class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vue pour la logique utilisateur -->
    <script>
        const {
            createApp
        } = Vue;

        createApp({
            data() {
                return {
                    darkMode: false,
                    sidebarOpen: false,
                    editMode: false,
                    countries: ['France', 'Sénégal', 'Côte d\'Ivoire', 'Nigeria', 'Ghana', 'Royaume-Uni', 'Allemagne', 'Bénin', 'Togo'],
                    user: {
                        name: 'Jean Dupont',
                        email: 'jean.dupont@email.com',
                        phone: '+33 6 12 34 56 78',
                        country: 'France',
                        city: 'Paris',
                        type: 'offerer',
                        rating: 4.8,
                        reviews: 23,
                        memberSince: 'Janvier 2025',
                        stats: {
                            transactions: 45,
                            totalAmount: 12500
                        }
                    },
                    notifications: {
                        email: true,
                        push: false
                    }
                };
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
                saveProfile() {
                    alert('Profil enregistré avec succès !');
                    this.editMode = false;
                },
                changePassword() {
                    alert('Fonctionnalité de changement de mot de passe à venir');
                },
                enable2FA() {
                    alert('Fonctionnalité d\'authentification à deux facteurs à venir');
                },
                formatCurrency(amount) {
                    return new Intl.NumberFormat('fr-FR', {
                        minimumFractionDigits: 0,
                        maximumFractionDigits: 0
                    }).format(amount);
                }
            }
        }).mount('#app');
    </script>
</body>

</html>