<?php $title = "AmPay - Connexion";

ob_start(); ?>

<div id="app">
    <!-- Added language toggle button next to theme toggle -->
    <button @click="toggleLang" class="lang-toggle" :title="currentLang === 'fr' ? 'Switch to English' : 'Passer au français'">
        <span class="text-2xl">{{ currentLang === 'fr' ? '🇺🇸' : '🇫🇷' }}</span>
    </button>

    <!-- Made sun icon yellow with text-yellow-400 -->
    <button @click="toggleDarkMode" class="theme-toggle" :title="t.changeTheme">
        <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-900 dark:text-white'"></i>
    </button>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <div class="w-16 h-16 primary-gradient rounded-xl flex items-center justify-center">
                        <a href="index.php">
                            <i class="fas fa-bolt text-white text-3xl"></i>
                        </a>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ t.title }}</h2>
                <!-- Made signup link white in dark mode -->
                <p class="mt-2 text-sm text-white-600 dark:text-gray-400">
                    {{ t.noAccount }}
                    <a href="index.php?action=registerPage" class="font-medium text-primary hover:text-primary-dark dark:text-white dark:hover:text-gray-200">
                        {{ t.signUp }}
                    </a>
                </p>
            </div>

            <form @submit.prevent="handleLogin" class="mt-8 space-y-6 bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                            <i class="fas fa-envelope mr-1 text-gray-900 dark:text-white"></i>{{ t.email }}
                        </label>
                        <input v-model="loginForm.email" id="email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" :placeholder="t.emailPlaceholder">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white mb-2">
                            <i class="fas fa-lock mr-1 text-gray-900 dark:text-white"></i>{{ t.password }}
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
                            {{ t.rememberMe }}
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="index.php?action=resetPasswordPage" class="font-medium text-primary hover:text-primary-dark">
                            {{ t.forgotPassword }}
                        </a>
                    </div>
                </div>

                <button type="submit" :disabled="loading" class="w-full px-4 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    {{ loading ? t.loggingIn : t.login }}
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
                darkMode: false,
                currentLang: 'fr',
                loginForm: {
                    email: '',
                    password: '',
                    remember: false
                },
                showPassword: false,
                loading: false,
                error: '',
                translations: {
                    fr: {
                        changeTheme: 'Changer de thème',
                        title: 'Connexion à AMPAY',
                        noAccount: 'Pas encore de compte?',
                        signUp: 'Inscrivez-vous',
                        email: 'Email',
                        emailPlaceholder: 'votre@email.com',
                        password: 'Mot de passe',
                        rememberMe: 'Se souvenir de moi',
                        forgotPassword: 'Mot de passe oublié?',
                        login: 'Se connecter',
                        loggingIn: 'Connexion...'
                    },
                    en: {
                        changeTheme: 'Change theme',
                        title: 'Login to AMPAY',
                        noAccount: 'No account yet?',
                        signUp: 'Sign up',
                        email: 'Email',
                        emailPlaceholder: 'your@email.com',
                        password: 'Password',
                        rememberMe: 'Remember me',
                        forgotPassword: 'Forgot password?',
                        login: 'Login',
                        loggingIn: 'Logging in...'
                    }
                }
            };
        },
        computed: {
            t() {
                return this.translations[this.currentLang];
            }
        },
        mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            const savedLang = localStorage.getItem('language');
            if (savedLang && (savedLang === 'fr' || savedLang === 'en')) {
                this.currentLang = savedLang;
            }
        },
        methods: {
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },

            toggleLang() {
                this.currentLang = this.currentLang === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLang);
            },

            async handleLogin() {
                this.loading = true;
                this.error = '';

                try {
                    const response = await fetch('index.php?action=login', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(this.loginForm)
                    });

                    const result = await response.json();

                    if (result.success) {
                        window.location.href = result.redirect;
                    } else {
                        alert(result.message || 'Une erreur est survenue.');
                    }

                } catch (err) {
                    alert('Erreur de connexion au serveur.');
                    console.error(err);
                } finally {
                    this.loading = false;
                }
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

    /* Added lang-toggle button styles */
    .lang-toggle {
        position: fixed;
        top: 1.5rem;
        right: 5.5rem;
        z-index: 50;
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }

    .lang-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }

    .dark-mode .lang-toggle {
        background-color: var(--bg-dark-secondary);
    }

    .theme-toggle {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 50;
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .theme-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
    }

    .dark-mode .theme-toggle {
        background-color: var(--bg-dark-secondary);
    }

    .theme-toggle i {
        font-size: 1.25rem;
    }
</style>

<?php $content = ob_get_clean(); ?>

<?php require './src/view/layout.php'; ?>