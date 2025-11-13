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

        <!-- Structure identique au dashboard avec md:ml-64 et flex-col -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden md:ml-64">
            <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print flex-shrink-0">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <!-- Added translation for page title -->
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ t.profile }}
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
                <!-- Added translation for description -->
                <div class="mb-8">
                    <p class="text-lg text-gray-600 dark:text-gray-400">{{ t.profile_description }}</p>
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
                                <!-- Added translation for account status -->
                                <span class="text-sm font-semibold" :class="user.account_verified ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'">
                                    {{ user.account_verified ? t.account_verified : t.account_not_verified }}
                                </span>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mt-6 card-hover">
                            <!-- Added translation for statistics title -->
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                <i class="fas fa-chart-line text-primary mr-2"></i>{{ t.statistics }}
                            </h3>
                            <div class="space-y-4">
                                <!-- Added translation for transactions -->
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ t.transactions }}</span>
                                    <span class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ user.stats.transactions }}</span>
                                </div>
                                <!-- Added translation for member since -->
                                <div class="flex items-center justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">{{ t.member_since }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ user.memberSince }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <div class="flex items-center justify-between mb-6">
                                <!-- Added translation for personal info title -->
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                    <i class="fas fa-user-edit text-primary mr-2"></i>{{ t.personal_info }}
                                </h3>
                                <!-- Added translation for edit/cancel buttons -->
                                <button @click="editMode = !editMode" class="px-4 py-2 text-primary hover:bg-primary hover:text-white border border-primary rounded-lg transition-colors">
                                    <i :class="editMode ? 'fas fa-times' : 'fas fa-edit'" class="mr-2"></i>
                                    {{ editMode ? t.cancel : t.edit }}
                                </button>
                            </div>

                            <form @submit.prevent="saveProfile" class="space-y-4">
                                <!-- Champs séparés pour prénom et nom -->
                                <div class="grid sm:grid-cols-2 gap-4">
                                    <!-- Added translation for first name label -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-user mr-1 text-primary"></i>{{ t.first_name }}
                                        </label>
                                        <input v-model="user.first_name" :disabled="!editMode" type="text" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                    <!-- Added translation for last name label -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-user mr-1 text-primary"></i>{{ t.last_name }}
                                        </label>
                                        <input v-model="user.last_name" :disabled="!editMode" type="text" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>

                                <!-- Added translation for email label -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <i class="fas fa-envelope mr-1 text-primary"></i>{{ t.email }}
                                    </label>
                                    <input v-model="user.email" :disabled="!editMode" type="email" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                </div>

                                <!-- Champs séparés pour préfixe et numéro de téléphone -->
                                <div class="grid sm:grid-cols-3 gap-4">
                                    <!-- Added translation for phone prefix label -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-phone mr-1 text-primary"></i>{{ t.phone_prefix }}
                                        </label>
                                        <select v-model="user.phone_prefix" :disabled="!editMode"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
               focus:ring-2 focus:ring-primary focus:border-transparent 
               disabled:bg-gray-100 dark:disabled:bg-gray-700 
               bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            <option :value="user.phone_prefix">{{ user.phone_prefix }}</option>
                                        </select>

                                    </div>
                                    <!-- Added translation for phone number label -->
                                    <div class="sm:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-phone mr-1 text-primary"></i>{{ t.phone_number }}
                                        </label>
                                        <input v-model="user.phone" :disabled="!editMode" type="tel" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent disabled:bg-gray-100 dark:disabled:bg-gray-700 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" placeholder="612345678">
                                    </div>
                                </div>

                                <div class="grid sm:grid-cols-2 gap-4">
                                    <!-- Added translation for country label -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-flag mr-1 text-primary"></i>{{ t.country }}
                                        </label>
                                        <select v-model="user.country" :disabled="!editMode"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                       focus:ring-2 focus:ring-primary focus:border-transparent 
                       disabled:bg-gray-100 dark:disabled:bg-gray-700 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            <option :value="user.country">{{ user.country }}</option>
                                        </select>
                                    </div>

                                    <!-- Added translation for city label -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-map-marker-alt mr-1 text-primary"></i>{{ t.city }}
                                        </label>
                                        <input v-model="user.city" :disabled="!editMode" type="text"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg 
                      focus:ring-2 focus:ring-primary focus:border-transparent 
                      disabled:bg-gray-100 dark:disabled:bg-gray-700 
                      bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    </div>
                                </div>



                                <!-- Added translation for save button -->
                                <div v-if="editMode" class="pt-4">
                                    <button type="submit" :disabled="submitting" class="w-full sm:w-auto px-8 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                                        <i class="fas fa-save mr-2"></i>{{ submitting ? t.saving : t.save_changes }}
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <!-- Added translation for security title -->
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                                <i class="fas fa-shield-alt text-primary mr-2"></i>{{ t.security }}
                            </h3>
                            <div class="space-y-4">
                                <!-- Added translation for change password button -->
                                <button @click="showPasswordModal = true" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <span class="flex items-center">
                                        <i class="fas fa-key text-primary mr-3"></i>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ t.change_password }}</span>
                                    </span>
                                    <i class="fas fa-chevron-right text-gray-400"></i>
                                </button>
                                <!-- Added translation for 2FA button and status -->
                                <button @click="show2FAModal = true" class="w-full flex items-center justify-between px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <span class="flex items-center">
                                        <i class="fas fa-mobile-alt text-primary mr-3"></i>
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ t.two_factor_auth }}</span>
                                    </span>
                                    <div class="flex items-center gap-2">
                                        <span :class="user.two_factor_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-400'" class="text-sm font-semibold">
                                            {{ user.two_factor_enabled ? t.enabled : t.disabled }}
                                        </span>
                                        <i class="fas fa-chevron-right text-gray-400"></i>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 card-hover">
                            <!-- Added translation for notifications title -->
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                                <i class="fas fa-bell text-primary mr-2"></i>{{ t.notifications }}
                            </h3>
                            <div class="space-y-4">
                                <!-- Added translation for email notifications -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ t.email_notifications }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ t.email_notifications_desc }}</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input v-model="notifications.email" type="checkbox" class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                    </label>
                                </div>
                                <!-- Added translation for push notifications -->
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ t.push_notifications }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ t.push_notifications_desc }}</p>
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

    <!-- Modal pour changer le mot de passe -->
    <div v-if="showPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closePasswordModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <!-- Added translation for modal title -->
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-key text-primary mr-2"></i>{{ t.change_password }}
                </h3>
                <button @click="closePasswordModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form @submit.prevent="changePassword" class="space-y-4">
                <!-- Added translation for current password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-primary"></i>{{ t.current_password }}
                    </label>
                    <input v-model="passwordForm.current" type="password" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <!-- Added translation for new password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-primary"></i>{{ t.new_password }}
                    </label>
                    <input v-model="passwordForm.new" type="password" required minlength="8" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                    <!-- Added translation for password hint -->
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ t.password_hint }}</p>
                </div>

                <!-- Added translation for confirm password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-primary"></i>{{ t.confirm_password }}
                    </label>
                    <input v-model="passwordForm.confirm" type="password" required minlength="8" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                </div>

                <div v-if="passwordError" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                    <p class="text-sm text-red-600 dark:text-red-400">{{ passwordError }}</p>
                </div>

                <!-- Added translation for modal buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="button" @click="closePasswordModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ t.cancel }}
                    </button>
                    <button type="submit" :disabled="submitting" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-check mr-2"></i>{{ submitting ? t.modifying : t.modify }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour la double authentification -->
    <div v-if="show2FAModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="close2FAModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <!-- Added translation for 2FA modal title -->
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-mobile-alt text-primary mr-2"></i>{{ t.two_factor_auth }}
                </h3>
                <button @click="close2FAModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="mb-6">
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <!-- Added translation for current status -->
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ t.current_status }}</p>
                        <p :class="user.two_factor_enabled ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400'" class="text-sm">
                            {{ user.two_factor_enabled ? t.enabled : t.disabled }}
                        </p>
                    </div>
                    <i :class="user.two_factor_enabled ? 'fas fa-check-circle text-green-500' : 'fas fa-times-circle text-gray-400'" class="text-3xl"></i>
                </div>
            </div>

            <!-- Added translation for 2FA description -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    {{ user.two_factor_enabled ? t.twofa_enabled_desc : t.twofa_disabled_desc }}
                </p>
            </div>

            <div v-if="twoFactorError" class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 mb-4">
                <p class="text-sm text-red-600 dark:text-red-400">{{ twoFactorError }}</p>
            </div>

            <!-- Added translation for 2FA modal buttons -->
            <div class="flex gap-4">
                <button @click="close2FAModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    {{ t.cancel }}
                </button>
                <button @click="toggle2FA" :disabled="submitting" :class="user.two_factor_enabled ? 'bg-red-500 hover:bg-red-600' : 'primary-gradient'" class="flex-1 px-6 py-3 text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                    <i :class="user.two_factor_enabled ? 'fas fa-times' : 'fas fa-check'" class="mr-2"></i>
                    {{ submitting ? t.processing : (user.two_factor_enabled ? t.disable : t.enable) }}
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
                currentLang: 'fr',
                translations: {
                    fr: {
                        profile: 'Profil',
                        profile_description: 'Gérez vos informations personnelles et vos préférences',
                        account_verified: 'Compte vérifié',
                        account_not_verified: 'Compte non vérifié',
                        statistics: 'Statistiques',
                        transactions: 'Transactions',
                        member_since: 'Membre depuis',
                        personal_info: 'Informations personnelles',
                        edit: 'Modifier',
                        cancel: 'Annuler',
                        first_name: 'Prénom',
                        last_name: 'Nom',
                        email: 'Email',
                        phone_prefix: 'Préfixe',
                        phone_number: 'Numéro de téléphone',
                        country: 'Pays',
                        city: 'Ville',
                        save_changes: 'Enregistrer les modifications',
                        saving: 'Enregistrement...',
                        security: 'Sécurité',
                        change_password: 'Changer le mot de passe',
                        two_factor_auth: 'Authentification à deux facteurs',
                        enabled: 'Activée',
                        disabled: 'Désactivée',
                        notifications: 'Notifications',
                        email_notifications: 'Notifications par email',
                        email_notifications_desc: 'Recevez des mises à jour par email',
                        push_notifications: 'Notifications push',
                        push_notifications_desc: 'Recevez des notifications sur votre appareil',
                        current_password: 'Mot de passe actuel',
                        new_password: 'Nouveau mot de passe',
                        confirm_password: 'Confirmer le nouveau mot de passe',
                        password_hint: 'Minimum 8 caractères',
                        modify: 'Modifier',
                        modifying: 'Modification...',
                        current_status: 'Statut actuel',
                        twofa_enabled_desc: 'La double authentification est actuellement activée. Vous pouvez la désactiver ci-dessous.',
                        twofa_disabled_desc: 'Activez la double authentification pour renforcer la sécurité de votre compte.',
                        processing: 'Traitement...',
                        enable: 'Activer',
                        disable: 'Désactiver',
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
                        profile: 'Profile',
                        profile_description: 'Manage your personal information and preferences',
                        account_verified: 'Account verified',
                        account_not_verified: 'Account not verified',
                        statistics: 'Statistics',
                        transactions: 'Transactions',
                        member_since: 'Member since',
                        personal_info: 'Personal Information',
                        edit: 'Edit',
                        cancel: 'Cancel',
                        first_name: 'First Name',
                        last_name: 'Last Name',
                        email: 'Email',
                        phone_prefix: 'Prefix',
                        phone_number: 'Phone Number',
                        country: 'Country',
                        city: 'City',
                        save_changes: 'Save changes',
                        saving: 'Saving...',
                        security: 'Security',
                        change_password: 'Change password',
                        two_factor_auth: 'Two-factor authentication',
                        enabled: 'Enabled',
                        disabled: 'Disabled',
                        notifications: 'Notifications',
                        email_notifications: 'Email notifications',
                        email_notifications_desc: 'Receive updates by email',
                        push_notifications: 'Push notifications',
                        push_notifications_desc: 'Receive notifications on your device',
                        current_password: 'Current password',
                        new_password: 'New password',
                        confirm_password: 'Confirm new password',
                        password_hint: 'Minimum 8 characters',
                        modify: 'Modify',
                        modifying: 'Modifying...',
                        current_status: 'Current status',
                        twofa_enabled_desc: 'Two-factor authentication is currently enabled. You can disable it below.',
                        twofa_disabled_desc: 'Enable two-factor authentication to strengthen your account security.',
                        processing: 'Processing...',
                        enable: 'Enable',
                        disable: 'Disable',
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
                },
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

            this.fetch2FAStatus();
        },
        methods: {
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
            // Fonction pour sauvegarder le profil avec appel API
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
            // Fonction pour changer le mot de passe avec validation
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
            // Fonction pour récupérer le statut 2FA
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
            // Fonction pour activer/désactiver la 2FA
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