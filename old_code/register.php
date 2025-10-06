<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - AMPAY</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

        .dark-mode .text-gray-900 {
            color: #F9FAFB !important;
        }

        .dark-mode input,
        .dark-mode select {
            background-color: var(--bg-dark-secondary) !important;
            color: #F9FAFB !important;
            border-color: #475569 !important;
        }

        .primary-gradient {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div id="app">
        <!-- Added theme toggle button in top-right corner -->
        <button @click="toggleDarkMode"
            class="fixed top-4 right-4 z-50 w-12 h-12 rounded-full bg-white dark:bg-gray-800 shadow-lg flex items-center justify-center hover:scale-110 transition-transform">
            <i :class="isDarkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-700'" class="text-xl"></i>
        </button>

        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl w-full space-y-8">
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 primary-gradient rounded-xl flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Créer un compte AMPAY</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Déjà inscrit?
                        <a href="login.php" class="font-medium text-primary hover:text-primary-dark">
                            Connectez-vous
                        </a>
                    </p>
                </div>

                <form @submit.prevent="handleRegister"
                    class="mt-8 space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-1 text-primary"></i>Prénom
                            </label>
                            <input v-model="registerForm.firstName" type="text" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Jean">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-1 text-primary"></i>Nom
                            </label>
                            <input v-model="registerForm.lastName" type="text" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="Dupont">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-1 text-primary"></i>Email
                            </label>
                            <input v-model="registerForm.email" type="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                placeholder="jean.dupont@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-flag mr-1 text-primary"></i>Pays
                            </label>
                            <select v-model="registerForm.country" @change="onCountryChange" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Sélectionnez un pays</option>
                                <option v-for="country in countries" :key="country.cca2" :value="country.cca2">
                                    {{ country.name.common }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-city mr-1 text-primary"></i>Ville
                            </label>
                            <input v-model="registerForm.city" type="text" list="cities-list"
                                :disabled="!registerForm.country || loadingCities"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:opacity-50"
                                placeholder="Tapez pour rechercher une ville" @input="searchCities">
                            <datalist id="cities-list">
                                <option v-for="city in cities" :key="city.id" :value="city.name">{{ city.name }}</option>
                            </datalist>
                            <p v-if="loadingCities" class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-spinner fa-spin mr-1"></i>Chargement des villes...
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-phone mr-1 text-primary"></i>Téléphone
                            </label>
                            <div class="flex gap-2">
                                <input type="text" v-model="registerForm.phonePrefix" readonly
                                    class="w-24 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-gray-100"
                                    placeholder="+33">
                                <input v-model="registerForm.phone" type="tel" required
                                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="612345678">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-1 text-primary"></i>Mot de passe
                            </label>
                            <div class="relative">
                                <input v-model="registerForm.password" :type="showPassword ? 'text' : 'password'"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="••••••••">
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                            <p v-if="registerForm.password && registerForm.password.length < 8" class="text-red-600 text-sm mt-1">
                                Le mot de passe doit contenir au moins 8 caractères
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-1 text-primary"></i>Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <input v-model="registerForm.confirmPassword" :type="showConfirmPassword ? 'text' : 'password'"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="••••••••">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input v-model="registerForm.acceptTerms" id="terms" type="checkbox" required
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            J'accepte les <a href="#" class="text-primary hover:text-primary-dark">conditions d'utilisation</a>
                            et la <a href="#" class="text-primary hover:text-primary-dark">politique de confidentialité</a>
                        </label>
                    </div>

                    <button type="submit" :disabled="loading"
                        class="w-full px-4 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-user-plus mr-2"></i>
                        {{ loading ? 'Inscription...' : 'Créer mon compte' }}
                    </button>

                    <div v-if="error" class="p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ error }}
                    </div>

                    <div v-if="success" class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                        <i class="fas fa-check-circle mr-2"></i>{{ success }}
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
                    isDarkMode: false,
                    registerForm: {
                        firstName: '',
                        lastName: '',
                        email: '',
                        country: '',
                        city: '',
                        phonePrefix: '',
                        phone: '',
                        password: '',
                        confirmPassword: '',
                        role: 'user',
                        account_verified: 'no',
                        acceptTerms: true
                    },
                    showPassword: false,
                    showConfirmPassword: false,
                    loading: false,
                    loadingCities: false,
                    error: '',
                    success: '',
                    countries: [],
                    cities: [],
                    searchTimeout: null
                };
            },
            async mounted() {
                const savedDarkMode = localStorage.getItem('darkMode');
                if (savedDarkMode === 'true') {
                    this.isDarkMode = true;
                    document.body.classList.add('dark-mode');
                }
                await this.loadCountries();
            },
            methods: {
                toggleDarkMode() {
                    this.isDarkMode = !this.isDarkMode;
                    if (this.isDarkMode) {
                        document.body.classList.add('dark-mode');
                        localStorage.setItem('darkMode', 'true');
                    } else {
                        document.body.classList.remove('dark-mode');
                        localStorage.setItem('darkMode', 'false');
                    }
                },
                async loadCountries() {
                    try {
                        const response = await axios.get('https://restcountries.com/v3.1/independent?status=true');
                        this.countries = response.data.sort((a, b) => a.name.common.localeCompare(b.name.common));
                    } catch (err) {
                        console.error('Erreur lors du chargement des pays:', err);
                        this.error = 'Impossible de charger la liste des pays';
                    }
                },
                onCountryChange() {
                    this.registerForm.city = '';
                    this.cities = [];

                    const selectedCountry = this.countries.find(c => c.cca2 === this.registerForm.country);
                    if (selectedCountry) {
                        const idd = selectedCountry.idd;
                        this.registerForm.phonePrefix = idd && idd.root ? idd.root + (idd.suffixes?.[0] || '') : '';
                    }

                    this.loadCities(''); // Charge les villes principales du pays
                },
                searchCities() {
                    clearTimeout(this.searchTimeout);
                    if (!this.registerForm.country || this.registerForm.city.length < 2) {
                        this.cities = [];
                        return;
                    }
                    this.searchTimeout = setTimeout(() => {
                        this.loadCities(this.registerForm.city);
                    }, 500);
                },
                async loadCities(namePrefix = '') {
                    if (!this.registerForm.country) return;

                    this.loadingCities = true;
                    try {
                        const response = await axios.get('https://wft-geo-db.p.rapidapi.com/v1/geo/cities', {
                            params: {
                                countryIds: this.registerForm.country,
                                namePrefix: namePrefix,
                                limit: 20,
                                sort: '-population'
                            },
                            headers: {
                                'X-RapidAPI-Key': 'VOTRE_CLE_RAPIDAPI',
                                'X-RapidAPI-Host': 'wft-geo-db.p.rapidapi.com'
                            }
                        });
                        this.cities = response.data.data || [];
                    } catch (err) {
                        console.error(err);
                        this.cities = [];
                    } finally {
                        this.loadingCities = false;
                    }
                },
                async handleRegister() {
                    this.loading = true;
                    this.error = '';
                    this.success = '';

                    try {
                        const response = await axios.post(
                            'http://127.0.0.1/ampay/api/index.php?action=register',
                            this.registerForm
                        );

                        if (response.data?.success) {
                            // Affiche uniquement le message de succès
                            alert(response.data.success);
                            console.log(response.data.success);
                        } else if (response.data?.error) {
                            // Affiche uniquement le message d'erreur si le backend renvoie error
                            console.log(response.data.error);
                            alert(response.data.error);
                        } else {
                            // Cas inattendu
                            console.log('Réponse inattendue du serveur:', response.data);
                            alert('Une erreur est survenue');
                        }

                    } catch (err) {
                        // Erreur réseau ou serveur
                        const errorMessage = err.response?.data?.error || 'Erreur inconnue lors de l\'inscription';
                        console.log(errorMessage);
                        alert(errorMessage);
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }).mount('#app');
    </script>
</body>

</html>