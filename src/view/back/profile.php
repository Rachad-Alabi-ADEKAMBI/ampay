<?php $title = "AmPay - Profil";

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'] ?? '';
$country = $_SESSION['country'];
$city = $_SESSION['city'];
$phone_prefix = $_SESSION['phone_prefix'];
$phone = $_SESSION['phone'];
$account_verified = $_SESSION['account_verified'];
$user_id = $_SESSION['id'] ?? '';

?>

<?php
ob_start(); ?>

<div id="app">
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden overflow-x-hidden">
        <?php include 'sidebar.php'; ?>

        <!-- <CHANGE> Structure identique au dashboard avec md:ml-64 et flex-col -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden md:ml-64">
            <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print flex-shrink-0">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                                Profil
                            </h1>
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
                <div class="mb-8">
                    <p class="text-lg text-gray-600 dark:text-gray-400">Gérez vos informations personnelles et vos préférences</p>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 text-center card-hover">
                            <div class="w-32 h-32 primary-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-user text-white text-6xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ capitalizeFirstLetter(user.first_name) }} {{ capitalizeAll(user.last_name) }}</h2>
                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ user.email }}</p>
                            <div class="flex items-center justify-center space-x-2 mb-4">
                                <i :class="user.account_verified ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-red-500'"></i>
                                <span class="text-sm font-semibold" :class="user.account_verified ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                                    {{ user.account_verified ? 'Compte vérifié' : 'Compte non vérifié' }}
                                </span>
                            </div>
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
                                <!-- <CHANGE> Champs séparés pour prénom et nom -->
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-user mr-1 text-primary"></i>Prénom
                                        </label>
                                        <input v-model="user.first_name" :disabled="!editMode" type="text" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-user mr-1 text-primary"></i>Nom
                                        </label>
                                        <input v-model="user.last_name" :disabled="!editMode" type="text" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-envelope mr-1 text-primary"></i>Email
                                    </label>
                                    <input v-model="user.email" :disabled="!editMode" type="email" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                </div>

                                <!-- <CHANGE> Champs séparés pour préfixe et numéro de téléphone -->
                                <div class="grid sm:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-phone mr-1 text-primary"></i>Préfixe
                                        </label>
                                        <select v-model="user.phone_prefix" :disabled="!editMode"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
               focus:ring-2 focus:ring-primary focus:border-transparent 
               disabled:bg-gray-100 dark:disabled:bg-gray-700 
               bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            <option :value="user.phone_prefix">{{ user.phone_prefix }}</option>
                                        </select>

                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-phone mr-1 text-primary"></i>Numéro de téléphone
                                        </label>
                                        <input v-model="user.phone" :disabled="!editMode" type="tel" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="612345678">
                                    </div>
                                </div>

                                <div class="grid sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-flag mr-1 text-primary"></i>Pays
                                        </label>
                                        <select v-model="user.country" :disabled="!editMode"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                       focus:ring-2 focus:ring-primary focus:border-transparent 
                       disabled:bg-gray-100 dark:disabled:bg-gray-700 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            <option :value="user.country">{{ user.country }}</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>Ville
                                        </label>
                                        <input v-model="user.city" :disabled="!editMode" type="text"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                      focus:ring-2 focus:ring-primary focus:border-transparent 
                      disabled:bg-gray-100 dark:disabled:bg-gray-700 
                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>



                                <div v-if="editMode" class="pt-4">
                                    <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                                        <i class="fas fa-save mr-2"></i>{{ submitting ? 'Enregistrement...' : 'Enregistrer les modifications' }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                                <i class="fas fa-shield-alt text-primary mr-2"></i>Sécurité
                            </h3>
                            <div class="space-y-4">
                                <button @click="showPasswordModal = true" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <span class="flex items-center">
                                        <i class="fas fa-key text-primary mr-3"></i>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">Changer le mot de passe</span>
                                    </span>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </button>
                                <button @click="show2FAModal = true" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <span class="flex items-center">
                                        <i class="fas fa-mobile-alt text-primary mr-3"></i>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">Authentification à deux facteurs</span>
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span :class="user.two_factor_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-400'" class="text-sm font-semibold">
                                            {{ user.two_factor_enabled ? 'Activée' : 'Désactivée' }}
                                        </span>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
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

    <!-- <CHANGE> Modal pour changer le mot de passe -->
    <div v-if="showPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closePasswordModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-key text-primary mr-2"></i>Changer le mot de passe
                </h3>
                <button @click="closePasswordModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form @submit.prevent="changePassword" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-primary"></i>Mot de passe actuel
                    </label>
                    <input v-model="passwordForm.current" type="password" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-primary"></i>Nouveau mot de passe
                    </label>
                    <input v-model="passwordForm.new" type="password" required minlength="8" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum 8 caractères</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-primary"></i>Confirmer le nouveau mot de passe
                    </label>
                    <input v-model="passwordForm.confirm" type="password" required minlength="8" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <div v-if="passwordError" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                    <p class="text-sm text-red-600 dark:text-red-400">{{ passwordError }}</p>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" @click="closePasswordModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Annuler
                    </button>
                    <button type="submit" :disabled="submitting" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-check mr-2"></i>{{ submitting ? 'Modification...' : 'Modifier' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- <CHANGE> Modal pour la double authentification -->
    <div v-if="show2FAModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="close2FAModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-mobile-alt text-primary mr-2"></i>Authentification 2FA
                </h3>
                <button @click="close2FAModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="mb-6">
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">Statut actuel</p>
                        <p :class="user.two_factor_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400'" class="text-sm">
                            {{ user.two_factor_enabled ? 'Activée' : 'Désactivée' }}
                        </p>
                    </div>
                    <i :class="user.two_factor_enabled ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400'" class="text-3xl"></i>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    {{ user.two_factor_enabled 
                        ? 'La double authentification est actuellement activée. Vous pouvez la désactiver ci-dessous.' 
                        : 'Activez la double authentification pour renforcer la sécurité de votre compte.' }}
                </p>
            </div>

            <div v-if="twoFactorError" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 mb-4">
                <p class="text-sm text-red-600 dark:text-red-400">{{ twoFactorError }}</p>
            </div>

            <div class="flex gap-4">
                <button @click="close2FAModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Annuler
                </button>
                <button @click="toggle2FA" :disabled="submitting" :class="user.two_factor_enabled ? 'bg-red-500 hover:bg-red-600' : 'primary-gradient'" class="flex-1 px-6 py-3 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                    <i :class="user.two_factor_enabled ? 'fas fa-times' : 'fas fa-check'" class="mr-2"></i>
                    {{ submitting ? 'Traitement...' : (user.two_factor_enabled ? 'Désactiver' : 'Activer') }}
                </button>
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
                sidebarOpen: false,
                editMode: false,
                submitting: false,
                showPasswordModal: false,
                show2FAModal: false,
                passwordError: '',
                twoFactorError: '',
                countries: ['France', 'Sénégal', 'Côte d\'Ivoire', 'Nigeria', 'Ghana', 'Royaume-Uni', 'Allemagne', 'Bénin', 'Togo', 'Guinée'],
                // <CHANGE> Données initialisées depuis la session PHP
                user: {
                    id: <?= json_encode($user_id); ?>,
                    first_name: <?= json_encode($first_name); ?>,
                    last_name: <?= json_encode($last_name); ?>,
                    email: <?= json_encode($email); ?>,
                    phone_prefix: <?= json_encode($phone_prefix); ?>,
                    phone: <?= json_encode($phone); ?>,
                    country: <?= json_encode($country); ?>,
                    city: <?= json_encode($city); ?>,
                    account_verified: <?= json_encode($account_verified); ?>,
                    two_factor_enabled: false,
                    memberSince: '2025',
                    stats: {
                        transactions: 0,
                        totalAmount: 0
                    }
                },
                passwordForm: {
                    current: '',
                    new: '',
                    confirm: ''
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
            this.fetch2FAStatus();
        },
        methods: {
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            // <CHANGE> Fonction pour sauvegarder le profil avec appel API
            async saveProfile() {
                this.submitting = true;
                try {
                    const response = await api.post('?action=updateProfile', {
                        user_id: this.user.id,
                        first_name: this.user.first_name,
                        last_name: this.user.last_name,
                        email: this.user.email,
                        phone_prefix: this.user.phone_prefix,
                        phone: this.user.phone,
                        country: this.user.country,
                        city: this.user.city
                    });

                    if (response.data?.success) {
                        alert('Profil mis à jour avec succès !');
                        this.editMode = false;
                    } else {
                        alert(response.data?.message || 'Erreur lors de la mise à jour du profil');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la mise à jour du profil');
                } finally {
                    this.submitting = false;
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
            // <CHANGE> Fonction pour changer le mot de passe avec validation
            async changePassword() {
                this.passwordError = '';

                if (this.passwordForm.new !== this.passwordForm.confirm) {
                    this.passwordError = 'Les mots de passe ne correspondent pas';
                    return;
                }

                if (this.passwordForm.new.length < 8) {
                    this.passwordError = 'Le mot de passe doit contenir au moins 8 caractères';
                    return;
                }

                this.submitting = true;
                try {
                    const response = await api.post('?action=changePassword', {
                        user_id: this.user.id,
                        current_password: this.passwordForm.current,
                        new_password: this.passwordForm.new
                    });

                    if (response.data?.success) {
                        alert('Mot de passe modifié avec succès !');
                        this.closePasswordModal();
                    } else {
                        this.passwordError = response.data?.message || 'Erreur lors du changement de mot de passe';
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.passwordError = 'Erreur lors du changement de mot de passe';
                } finally {
                    this.submitting = false;
                }
            },
            closePasswordModal() {
                this.showPasswordModal = false;
                this.passwordForm = {
                    current: '',
                    new: '',
                    confirm: ''
                };
                this.passwordError = '';
            },
            // <CHANGE> Fonction pour récupérer le statut 2FA
            async fetch2FAStatus() {
                try {
                    const response = await api.get(`?action=get2FAStatus&user_id=${this.user.id}`);
                    if (response.data?.success) {
                        this.user.two_factor_enabled = response.data.two_factor_enabled || false;
                    }
                } catch (error) {
                    console.error('Erreur lors de la récupération du statut 2FA:', error);
                }
            },
            // <CHANGE> Fonction pour activer/désactiver la 2FA
            async toggle2FA() {
                this.twoFactorError = '';
                this.submitting = true;

                try {
                    const action = this.user.two_factor_enabled ? 'disable2FA' : 'enable2FA';
                    const response = await api.post(`?action=${action}`, {
                        user_id: this.user.id
                    });

                    if (response.data?.success) {
                        this.user.two_factor_enabled = !this.user.two_factor_enabled;
                        alert(this.user.two_factor_enabled ?
                            'Authentification à deux facteurs activée avec succès !' :
                            'Authentification à deux facteurs désactivée avec succès !');
                        this.close2FAModal();
                    } else {
                        this.twoFactorError = response.data?.message || 'Erreur lors de la modification de la 2FA';
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.twoFactorError = 'Erreur lors de la modification de la 2FA';
                } finally {
                    this.submitting = false;
                }
            },
            close2FAModal() {
                this.show2FAModal = false;
                this.twoFactorError = '';
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

    .dark-mode .border-gray-200 {
        border-color: #334155 !important;
    }

    .dark-mode .border-gray-300 {
        border-color: #475569 !important;
    }

    .dark-mode .shadow-md {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode input,
    .dark-mode select {
        background-color: var(--bg-dark-secondary) !important;
        color: #F9FAFB !important;
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
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>