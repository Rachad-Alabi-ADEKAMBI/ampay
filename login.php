<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - AMPAY</title>
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

        .dark-mode input {
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
            <div class="max-w-md w-full space-y-8">
                <div class="text-center">
                    <div class="flex justify-center mb-4">
                        <div class="w-16 h-16 primary-gradient rounded-xl flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-3xl"></i>
                        </div>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Connexion à AMPAY</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Pas encore de compte?
                        <a href="register.php" class="font-medium text-primary hover:text-primary-dark">
                            Inscrivez-vous
                        </a>
                    </p>
                </div>

                <form @submit.prevent="handleLogin" class="mt-8 space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-1 text-primary"></i>Email
                            </label>
                            <input v-model="loginForm.email" id="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="votre@email.com">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-1 text-primary"></i>Mot de passe
                            </label>
                            <div class="relative">
                                <input v-model="loginForm.password" :type="showPassword ? 'text' : 'password'" id="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="••••••••">
                                <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input v-model="loginForm.remember" id="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                                Se souvenir de moi
                            </label>
                        </div>

                        <div class="text-sm">
                            <a href="#" class="font-medium text-primary hover:text-primary-dark">
                                Mot de passe oublié?
                            </a>
                        </div>
                    </div>

                    <button type="submit" :disabled="loading" class="w-full px-4 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        {{ loading ? 'Connexion...' : 'Se connecter' }}
                    </button>

                    <div v-if="error" class="p-4 bg-red-100 text-red-700 rounded-lg text-sm">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ error }}
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
                    loginForm: {
                        email: '',
                        password: '',
                        remember: false
                    },
                    showPassword: false,
                    loading: false,
                    error: ''
                };
            },
            methods: {
                async handleLogin() {
                    this.loading = true;
                    this.error = '';

                    try {
                        // TODO: Replace with actual API call
                        await new Promise(resolve => setTimeout(resolve, 1000));

                        // Simulate successful login
                        window.location.href = 'dashboard.php';
                    } catch (err) {
                        this.error = 'Email ou mot de passe incorrect';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }).mount('#app');
    </script>
</body>

</html>