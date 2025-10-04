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

                <form @submit.prevent="handleRegister" class="mt-8 space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-1 text-primary"></i>Prénom
                            </label>
                            <input v-model="registerForm.firstName" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Jean">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-1 text-primary"></i>Nom
                            </label>
                            <input v-model="registerForm.lastName" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Dupont">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-1 text-primary"></i>Email
                            </label>
                            <input v-model="registerForm.email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="jean.dupont@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-flag mr-1 text-primary"></i>Pays
                            </label>
                            <select v-model="registerForm.country" @change="loadCities" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Sélectionnez un pays</option>
                                <option v-for="country in countries" :key="country.code" :value="country.name">{{ country.name }}</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-city mr-1 text-primary"></i>Ville
                            </label>
                            <select v-model="registerForm.city" :disabled="!registerForm.country" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:opacity-50">
                                <option value="">Sélectionnez une ville</option>
                                <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-phone mr-1 text-primary"></i>Téléphone
                            </label>
                            <div class="flex gap-2">
                                <select v-model="registerForm.phonePrefix" class="w-32 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option v-for="prefix in phonePrefixes" :key="prefix.code" :value="prefix.dial_code">
                                        {{ prefix.dial_code }} {{ prefix.code }}
                                    </option>
                                </select>
                                <input v-model="registerForm.phone" type="tel" required class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="612345678">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-1 text-primary"></i>Mot de passe
                            </label>
                            <div class="relative">
                                <input v-model="registerForm.password" :type="showPassword ? 'text' : 'password'" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="••••••••">
                                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-1 text-primary"></i>Confirmer le mot de passe
                            </label>
                            <div class="relative">
                                <input v-model="registerForm.confirmPassword" :type="showConfirmPassword ? 'text' : 'password'" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="••••••••">
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    <i :class="showConfirmPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input v-model="registerForm.acceptTerms" id="terms" type="checkbox" required class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            J'accepte les <a href="#" class="text-primary hover:text-primary-dark">conditions d'utilisation</a> et la <a href="#" class="text-primary hover:text-primary-dark">politique de confidentialité</a>
                        </label>
                    </div>

                    <button type="submit" :disabled="loading" class="w-full px-4 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
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
                    registerForm: {
                        firstName: '',
                        lastName: '',
                        email: '',
                        country: '',
                        city: '',
                        phonePrefix: '+33',
                        phone: '',
                        password: '',
                        confirmPassword: '',
                        acceptTerms: false
                    },
                    showPassword: false,
                    showConfirmPassword: false,
                    loading: false,
                    error: '',
                    success: '',
                    countries: [],
                    cities: [],
                    phonePrefixes: []
                };
            },
            async mounted() {
                await this.loadCountries();
                await this.loadPhonePrefixes();
            },
            methods: {
                async loadCountries() {
                    try {
                        const response = await axios.get('https://restcountries.com/v3.1/all');
                        this.countries = response.data
                            .map(country => ({
                                name: country.name.common,
                                code: country.cca2
                            }))
                            .sort((a, b) => a.name.localeCompare(b.name));
                    } catch (error) {
                        console.error('Erreur lors du chargement des pays:', error);
                        // Fallback countries
                        this.countries = [{
                                name: 'France',
                                code: 'FR'
                            },
                            {
                                name: 'Bénin',
                                code: 'BJ'
                            },
                            {
                                name: 'Côte d\'Ivoire',
                                code: 'CI'
                            },
                            {
                                name: 'Sénégal',
                                code: 'SN'
                            },
                            {
                                name: 'Togo',
                                code: 'TG'
                            }
                        ];
                    }
                },
                async loadPhonePrefixes() {
                    try {
                        const response = await axios.get('https://restcountries.com/v3.1/all');
                        this.phonePrefixes = response.data
                            .filter(country => country.idd && country.idd.root)
                            .map(country => ({
                                code: country.cca2,
                                dial_code: country.idd.root + (country.idd.suffixes ? country.idd.suffixes[0] : '')
                            }))
                            .sort((a, b) => a.dial_code.localeCompare(b.dial_code));
                    } catch (error) {
                        console.error('Erreur lors du chargement des préfixes:', error);
                        // Fallback prefixes
                        this.phonePrefixes = [{
                                code: 'FR',
                                dial_code: '+33'
                            },
                            {
                                code: 'BJ',
                                dial_code: '+229'
                            },
                            {
                                code: 'CI',
                                dial_code: '+225'
                            },
                            {
                                code: 'SN',
                                dial_code: '+221'
                            },
                            {
                                code: 'TG',
                                dial_code: '+228'
                            }
                        ];
                    }
                },
                async loadCities() {
                    if (!this.registerForm.country) {
                        this.cities = [];
                        return;
                    }

                    // Simulated cities data - in production, use a real API
                    const citiesData = {
                        'France': ['Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille'],
                        'Bénin': ['Cotonou', 'Porto-Novo', 'Parakou', 'Djougou', 'Bohicon', 'Kandi', 'Lokossa', 'Ouidah', 'Abomey', 'Natitingou'],
                        'Côte d\'Ivoire': ['Abidjan', 'Bouaké', 'Daloa', 'Yamoussoukro', 'San-Pédro', 'Korhogo', 'Man', 'Divo', 'Gagnoa', 'Abengourou'],
                        'Sénégal': ['Dakar', 'Thiès', 'Kaolack', 'Ziguinchor', 'Saint-Louis', 'Louga', 'Mbour', 'Rufisque', 'Kolda', 'Diourbel'],
                        'Togo': ['Lomé', 'Sokodé', 'Kara', 'Kpalimé', 'Atakpamé', 'Bassar', 'Tsévié', 'Aného', 'Sansanné-Mango', 'Dapaong']
                    };

                    this.cities = citiesData[this.registerForm.country] || [];
                    this.registerForm.city = '';
                },
                async handleRegister() {
                    this.error = '';
                    this.success = '';

                    // Validation
                    if (this.registerForm.password !== this.registerForm.confirmPassword) {
                        this.error = 'Les mots de passe ne correspondent pas';
                        return;
                    }

                    if (this.registerForm.password.length < 8) {
                        this.error = 'Le mot de passe doit contenir au moins 8 caractères';
                        return;
                    }

                    if (!this.registerForm.acceptTerms) {
                        this.error = 'Vous devez accepter les conditions d\'utilisation';
                        return;
                    }

                    this.loading = true;

                    try {
                        // TODO: Replace with actual API call
                        await new Promise(resolve => setTimeout(resolve, 1500));

                        this.success = 'Compte créé avec succès! Redirection...';

                        setTimeout(() => {
                            window.location.href = 'login.php';
                        }, 2000);
                    } catch (err) {
                        this.error = 'Une erreur est survenue lors de l\'inscription';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }).mount('#app');
    </script>
</body>

</html>