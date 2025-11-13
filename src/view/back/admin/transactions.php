<?php $title = "AmPay - Transactions"; ?>

<?php
ob_start(); ?>

<div id="app">
    <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 overflow-hidden overflow-x-hidden">
        <?php include __DIR__ . '/../sidebar.php'; ?>

        <div class="flex-1 flex flex-col h-screen overflow-hidden md:ml-64">
            <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print flex-shrink-0">
                <div class="px-4 sm:px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                            <!-- Added translation for title -->
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">{{ t.page_title }}</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <!-- Added language toggle button showing opposite language -->
                            <button @click="toggleLanguage" class="px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors font-semibold text-gray-600 dark:text-gray-300">
                                {{ currentLang === 'fr' ? 'EN' : 'FR' }}
                            </button>
                            <button @click="toggleDarkMode" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-600 dark:text-gray-300'" class="text-xl"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                <div class="px-4 sm:px-6 pb-2 pt-4">
                    <!-- Added translation for greeting -->
                    <div class="text-gray-700 dark:text-gray-200 text-sm sm:text-base font-medium flex items-center mb-6">
                        {{ t.greeting }}
                        <span class="ml-1 font-semibold text-gray-900 dark:text-white">Admin</span>
                    </div>
                </div>

                <div class="px-4 sm:px-6 pt-2">
                    <!-- Added translations for statistics cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-list text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ allListings.length }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.stat_total_listings }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-usd text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ offerCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.stat_offers }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-yellow-100 text-yellow-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-hand-holding-heart text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ requestCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.stat_requests }}</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ activeCount }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ t.stat_active }}</div>
                        </div>
                    </div>

                    <!-- Added translations for filters -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                        <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                            <input v-model="searchTerm" @input="applyFilters" type="text" :placeholder="t.filter_search" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

                            <select v-model="filterType" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">{{ t.filter_all_types }}</option>
                                <option value="Offre">{{ t.filter_offers }}</option>
                                <option value="Demande">{{ t.filter_requests }}</option>
                            </select>

                            <select v-model="filterCountry" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">{{ t.filter_all_countries }}</option>
                                <option v-for="country in countries" :key="country" :value="country">{{ country }}</option>
                            </select>

                            <select v-model="filterStatus" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">{{ t.filter_all_status }}</option>
                                <option value="Actif">{{ t.status_active }}</option>
                                <option value="Inactif">{{ t.status_inactive }}</option>
                            </select>

                            <select v-model="filterDelay" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">{{ t.filter_all_delays }}</option>
                                <option value="Urgent">{{ t.delay_urgent }}</option>
                                <option value="Deux semaines">{{ t.delay_two_weeks }}</option>
                                <option value="Nulle">{{ t.delay_none }}</option>
                            </select>

                            <input v-model.number="filterMinAmount" @input="applyFilters" type="number" :placeholder="t.filter_min_amount" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">

                            <input v-model.number="filterMaxAmount" @input="applyFilters" type="number" :placeholder="t.filter_max_amount" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>

                    <!-- Added translations for table headers -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full responsive-table">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_advertiser }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_type }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_amount }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_location }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_date }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_status }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">{{ t.table_actions }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="listing in paginatedListings" :key="listing.listing_id" class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                        <td :data-label="t.table_advertiser" class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ capitalizeFirstLetter(listing.first_name) }}
                                                    {{ capitalizeAll(listing.last_name) }}
                                                </div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ listing.email }}</div>
                                            </div>
                                        </td>
                                        <td :data-label="t.table_type" class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <span :class="getDelayDotColor(listing.delay)" class="w-3 h-3 rounded-full flex-shrink-0"></span>
                                                <span :class="listing.type === 'Offre' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                    <i :class="listing.type === 'Offre' ? 'fas fa-hand-holding-usd' : 'fas fa-hand-holding-heart'" class="mr-1"></i>
                                                    {{ listing.type }}
                                                </span>
                                            </div>
                                        </td>
                                        <td :data-label="t.table_amount" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ formatCurrency(listing.amount) }} {{ listing.currency }}</div>
                                        </td>
                                        <td :data-label="t.table_location" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                <i class="fas fa-map-marker-alt text-primary mr-1"></i>
                                                {{ listing.city }}, {{ listing.country }}
                                            </div>
                                        </td>
                                        <td :data-label="t.table_date" class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ formatDate(listing.created_at) }}</div>
                                        </td>
                                        <td :data-label="t.table_status" class="px-6 py-4 whitespace-nowrap">
                                            <span :class="listing.status === 'Actif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'" class="px-3 py-1 rounded-full text-xs font-semibold">
                                                {{ listing.status === 'Actif' ? t.status_active : t.status_inactive }}
                                            </span>
                                        </td>
                                        <td :data-label="t.table_actions" class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex gap-2">
                                                <button @click="viewListingDetails(listing)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" :title="t.action_view">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button @click="openMessageModal(listing)" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" :title="t.action_message">
                                                    <i class="fas fa-envelope"></i>
                                                </button>
                                                <button @click="toggleStatus(listing)" :class="listing.status === 'Actif' ? 'text-red-600 hover:text-red-900 dark:text-red-400' : 'text-green-600 hover:text-green-900 dark:text-green-400'" :title="listing.status === 'Actif' ? t.action_deactivate : t.action_activate">
                                                    <i :class="listing.status === 'Actif' ? 'fas fa-pause' : 'fas fa-play'"></i>
                                                </button>
                                                <!-- Added conversation count in parentheses next to messages icon -->
                                                <button @click="openMessagesModal(listing.listing_id)" class="text-purple-600 hover:text-purple-900 dark:text-purple-400 dark:hover:text-purple-300 relative" :title="t.action_messages">
                                                    <i class="fas fa-comments"></i>
                                                    <span v-if="getConversationCount(listing.listing_id) > 0" class="ml-1 text-xs font-semibold">({{ getConversationCount(listing.listing_id) }})</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-if="filteredListings.length === 0" class="text-center py-16">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <!-- Added translation for empty state -->
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ t.empty_title }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ t.empty_message }}</p>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div v-if="totalPages > 1" class="flex justify-center mb-8">
                        <nav class="inline-flex rounded-lg shadow-sm">
                            <button @click="previousPage" :disabled="currentPage === 1"
                                class="relative inline-flex items-center px-4 py-2 rounded-l-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button v-for="page in visiblePages" :key="page" @click="goToPage(page)"
                                :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium',
                                         currentPage === page ? 'z-10 primary-gradient border-primary text-white' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700']">
                                {{ page }}
                            </button>
                            <button @click="nextPage" :disabled="currentPage === totalPages"
                                class="relative inline-flex items-center px-4 py-2 rounded-r-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Added translations for details modal -->
    <div v-if="showDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeDetailsModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-primary to-green-600 p-6 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1">
                            <i class="fas fa-file-invoice-dollar mr-2"></i>{{ t.modal_details_title }}
                        </h3>
                        <p class="text-green-100 text-sm">{{ t.modal_listing }} #{{ selectedListing?.listing_id }}</p>
                    </div>
                    <button @click="closeDetailsModal" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
            </div>

            <div v-if="selectedListing" class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 p-4 rounded-xl border border-blue-200 dark:border-blue-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">{{ t.modal_advertiser }}</p>
                                <p class="text-lg font-bold text-blue-900 dark:text-blue-100">{{ capitalizeFirstLetter(selectedListing.first_name) }}
                                    {{ capitalizeFirstLetter(selectedListing.last_name) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-4 rounded-xl border border-green-200 dark:border-green-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-money-bill-wave text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-green-600 dark:text-green-400 font-medium">{{ t.modal_amount }}</p>
                                <p class="text-lg font-bold text-green-900 dark:text-green-100">{{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 p-4 rounded-xl border border-purple-200 dark:border-purple-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-purple-600 dark:text-purple-400 font-medium">{{ t.modal_location }}</p>
                                <p class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ selectedListing.city }}, {{ selectedListing.country }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 p-4 rounded-xl border border-orange-200 dark:border-orange-700">
                        <div class="flex items-center mb-2">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-orange-600 dark:text-orange-400 font-medium">{{ t.modal_phone }}</p>
                                <p class="text-lg font-bold text-orange-900 dark:text-orange-100">{{ selectedListing.phone || 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div :class="getDelayCardColor(selectedListing.delay)" class="p-4 rounded-xl border">
                        <div class="flex items-center mb-2">
                            <div :class="getDelayIconBgColor(selectedListing.delay)" class="w-10 h-10 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-clock text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs font-medium" :class="getDelayTextColor(selectedListing.delay)">{{ t.modal_delay }}</p>
                                <div class="flex items-center">
                                    <span :class="getDelayDotColor(selectedListing.delay)" class="w-3 h-3 rounded-full mr-2"></span>
                                    <p class="text-lg font-bold" :class="getDelayTextDarkColor(selectedListing.delay)">{{ getTranslatedDelay(selectedListing.delay) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Added translations for message modal -->
    <div v-if="showMessageModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeMessageModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-envelope text-primary mr-2"></i>{{ t.modal_send_message }}
                </h3>
                <button @click="closeMessageModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="selectedListing" class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ t.modal_recipient }}</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ capitalizeFirstLetter(selectedListing.first_name) }}
                        {{ capitalizeAll(selectedListing.last_name) }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ selectedListing.email }}</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ t.modal_your_message }}</label>
                    <textarea v-model="messageContent" rows="6" :placeholder="t.modal_message_placeholder" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>

                <div class="flex gap-3">
                    <button @click="closeMessageModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ t.button_cancel }}
                    </button>
                    <button @click="sendMessage" :disabled="!messageContent.trim()" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>{{ t.button_send }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Added translations for conversations modal -->
    <div v-if="showMessagesModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" @click.self="closeMessagesModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-3xl w-full p-6 sm:p-8 max-h-[80vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-comments text-primary mr-2"></i>{{ t.modal_conversations }} - {{ t.modal_listing }} #{{ selectedListing?.listing_id }}
                </h3>
                <button @click="closeMessagesModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="loadingMessages" class="text-center py-8">
                <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                <p class="text-gray-600 dark:text-gray-400">{{ t.loading_conversations }}</p>
            </div>

            <div v-else-if="conversationsList.length === 0" class="text-center py-8">
                <i class="fas fa-inbox text-4xl sm:text-6xl text-gray-300 mb-4"></i>
                <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ t.no_conversation }}</h4>
                <p class="text-gray-600 dark:text-gray-400">{{ t.no_conversation_message }}</p>
            </div>

            <div v-else class="space-y-4">
                <div v-for="conversation in conversationsList" :key="conversation.user_id" v-if="1>0"
                    class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 
                dark:border-gray-700 hover:border-primary dark:hover:border-primary transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center flex-1">
                            <div class="w-12 h-12 primary-gradient rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <i class="fas fa-user text-white text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900 dark:text-gray-100">{{ capitalizeFirstLetter(conversation.first_name) }}
                                    {{ capitalizeAll(conversation.last_name) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ conversation.email }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 truncate">{{ conversation.last_message }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-2 ml-4">
                            <span class="px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-semibold whitespace-nowrap">
                                {{ conversation.message_count }} {{ t.message_count }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ formatDate(conversation.last_message_date) }}</span>
                        </div>
                    </div>
                    <button @click="openChatModal(conversation)" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors text-sm font-medium">
                        <i class="fas fa-comments mr-2"></i>{{ t.button_access_messages }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Added translations for chat modal -->
    <div v-if="showChatModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] flex items-center justify-center p-4" @click.self="closeChatModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl flex flex-col h-[90vh] md:max-h-[85vh]">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                        <i class="fas fa-comments text-primary mr-2"></i>
                        <span class="hidden sm:inline">{{ t.modal_conversation_with }} {{ capitalizeFirstLetter(selectedConversation?.sender_first_name) ||
                            capitalizeFirstLetter( selectedConversation?.first_name) }} {{ capitalizeAll(selectedConversation?.sender_last_name) ||
                                 capitalizeAll(selectedConversation?.last_name) }}</span>
                        <span class="sm:hidden">{{ capitalizeFirstLetter(selectedConversation?.sender_first_name) || 
                            capitalizeFirstLetter(selectedConversation?.first_name) }} {{ capitalizeAll(selectedConversation?.sender_last_name) ||
                                capitalizeAll(selectedConversation?.last_name) }}</span>
                    </h3>
                    <button @click="closeChatModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl sm:text-2xl"></i>
                    </button>
                </div>
            </div>

            <div v-if="selectedListing" class="px-4 sm:px-6 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <div>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ t.modal_listing }} #{{ selectedListing.listing_id }} - </span>
                        <span class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}
                        </span>
                    </div>
                    <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        {{ selectedListing.city }}, {{ selectedListing.country }}
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto px-4 sm:px-6 py-4 space-y-3" ref="chatContainer">
                <div v-if="loadingChat" class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-4xl text-primary mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">{{ t.loading_conversation }}</p>
                </div>

                <div v-else-if="chatMessages.length === 0" class="text-center py-8">
                    <i class="fas fa-inbox text-4xl sm:text-6xl text-gray-300 mb-4"></i>
                    <h4 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ t.no_messages }}</h4>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">{{ t.start_conversation }}</p>
                </div>

                <div v-else v-for="msg in chatMessages" :key="msg.id" :class="['flex', msg.sender_id === 1 ? 'justify-end' : 'justify-start']">
                    <div :class="['max-w-[85%] sm:max-w-[70%] rounded-lg p-3 sm:p-4', msg.sender_id === 1 ? 'bg-green-600 text-white' : 'bg-blue-500 text-white']">
                        <div class="flex items-center mb-2">
                            <div :class="['w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center mr-2', msg.sender_id === 1 ? 'bg-green-700' : 'bg-blue-600']">
                                <i :class="msg.sender_id === 1 ? 'fas fa-user-shield' : 'fas fa-user'" class="text-white text-xs sm:text-sm"></i>
                            </div>
                            <div>
                                <p :class="['text-xs font-semibold', msg.sender_id === 1 ? 'text-green-100' : 'text-blue-100']">
                                    {{ msg.sender_id === 1 ? t.you_admin : (capitalizeFirstLetter(msg.sender_first_name) || capitalizeFirstLetter(msg.first_name)) + ' ' + 
                                        (capitalizeAll(msg.sender_last_name) || capitalizeAll(msg.last_name)) }}
                                </p>
                                <p :class="['text-xs', msg.sender_id === 1 ? 'text-green-200' : 'text-blue-200']">
                                    {{ formatDate(msg.created_at) }}
                                </p>
                            </div>
                        </div>
                        <p class="text-sm break-words">{{ msg.message }}</p>
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200 dark:border-gray-700 flex-shrink-0 bg-white dark:bg-gray-800">
                <form @submit.prevent="sendChatMessage" class="flex gap-2">
                    <textarea
                        v-model="newChatMessage"
                        rows="2"
                        :placeholder="t.modal_type_message"
                        class="flex-1 px-3 sm:px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 resize-none text-sm"></textarea>
                    <button
                        type="submit"
                        :disabled="!newChatMessage.trim() || sendingChatMessage"
                        class="px-4 sm:px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center min-w-[60px] sm:min-w-[80px]">
                        <i class="fas fa-paper-plane text-base sm:text-lg"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Added translations for reply modal -->
    <div v-if="showReplyModal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] flex items-center justify-center p-4" @click.self="closeReplyModal">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    <i class="fas fa-reply text-primary mr-2"></i>{{ t.modal_reply_message }}
                </h3>
                <button @click="closeReplyModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="selectedMessage" class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border-l-4 border-primary">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ t.modal_original_message }}</p>
                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ selectedMessage.first_name }} {{ selectedMessage.last_name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ selectedMessage.email }}</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 italic mt-2">"{{ selectedMessage.message }}"</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ t.modal_your_reply }}</label>
                    <textarea v-model="replyContent" rows="6" :placeholder="t.modal_reply_placeholder" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"></textarea>
                </div>

                <div class="flex gap-3">
                    <button @click="closeReplyModal" class="flex-1 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        {{ t.button_cancel }}
                    </button>
                    <button @click="sendReply" :disabled="!replyContent.trim()" class="flex-1 px-6 py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>{{ t.button_send }}
                    </button>
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
                currentLang: localStorage.getItem('language') || 'fr',
                translations: {
                    fr: {
                        page_title: 'Transactions',
                        greeting: 'Bonjour',
                        stat_total_listings: 'Total Annonces',
                        stat_offers: 'Offres',
                        stat_requests: 'Demandes',
                        stat_active: 'Actives',
                        filter_search: 'Rechercher...',
                        filter_all_types: 'Tous les types',
                        filter_offers: 'Offres',
                        filter_requests: 'Demandes',
                        filter_all_countries: 'Tous les pays',
                        filter_all_status: 'Tous les statuts',
                        filter_all_delays: 'Tous les délais',
                        filter_min_amount: 'Montant min',
                        filter_max_amount: 'Montant max',
                        status_active: 'Actif',
                        status_inactive: 'Inactif',
                        delay_urgent: 'Urgent',
                        delay_two_weeks: 'Deux semaines',
                        delay_none: 'Nulle',
                        table_advertiser: 'Annonceur',
                        table_type: 'Type',
                        table_amount: 'Montant',
                        table_location: 'Localisation',
                        table_date: 'Date',
                        table_status: 'Statut',
                        table_actions: 'Actions',
                        action_view: 'Voir',
                        action_message: 'Message',
                        action_deactivate: 'Désactiver',
                        action_activate: 'Activer',
                        action_messages: 'Messages',
                        empty_title: 'Aucune transaction trouvée',
                        empty_message: 'Essayez de modifier vos filtres',
                        modal_details_title: 'Détails de l\'annonce',
                        modal_listing: 'Annonce',
                        modal_advertiser: 'Annonceur',
                        modal_amount: 'Montant',
                        modal_location: 'Localisation',
                        modal_phone: 'Téléphone',
                        modal_delay: 'Délai',
                        modal_send_message: 'Envoyer un message',
                        modal_recipient: 'Destinataire',
                        modal_your_message: 'Votre message',
                        modal_message_placeholder: 'Écrivez votre message ici...',
                        modal_conversations: 'Conversations',
                        modal_conversation_with: 'Conversation avec',
                        modal_reply_message: 'Répondre au message',
                        modal_original_message: 'Message original de:',
                        modal_your_reply: 'Votre réponse',
                        modal_reply_placeholder: 'Écrivez votre réponse ici...',
                        modal_type_message: 'Écrivez votre message...',
                        loading_conversations: 'Chargement des conversations...',
                        loading_conversation: 'Chargement de la conversation...',
                        no_conversation: 'Aucune conversation',
                        no_conversation_message: 'Aucun message pour cette annonce',
                        no_messages: 'Aucun message',
                        start_conversation: 'Commencez la conversation',
                        message_count: 'message(s)',
                        button_access_messages: 'Accéder aux messages',
                        button_cancel: 'Annuler',
                        button_send: 'Envoyer',
                        you_admin: 'Vous (Admin)',
                        // Navigation translations
                        nav_dashboard: 'Tableau de bord',
                        nav_transactions: 'Transactions',
                        nav_sponsorships: 'Parrainages',
                        nav_users: 'Utilisateurs',
                        nav_profile: 'Profil',
                        nav_home: 'Accueil',
                        nav_marketplace: 'Marketplace',
                        nav_my_transactions: 'Mes Transactions',
                        nav_my_sponsorships: 'Mes Parrainages',
                        nav_logout: 'Déconnexion'
                    },
                    en: {
                        page_title: 'Transactions',
                        greeting: 'Hello',
                        stat_total_listings: 'Total Listings',
                        stat_offers: 'Offers',
                        stat_requests: 'Requests',
                        stat_active: 'Active',
                        filter_search: 'Search...',
                        filter_all_types: 'All types',
                        filter_offers: 'Offers',
                        filter_requests: 'Requests',
                        filter_all_countries: 'All countries',
                        filter_all_status: 'All statuses',
                        filter_all_delays: 'All delays',
                        filter_min_amount: 'Min amount',
                        filter_max_amount: 'Max amount',
                        status_active: 'Active',
                        status_inactive: 'Inactive',
                        delay_urgent: 'Urgent',
                        delay_two_weeks: 'Two weeks',
                        delay_none: 'None',
                        table_advertiser: 'Advertiser',
                        table_type: 'Type',
                        table_amount: 'Amount',
                        table_location: 'Location',
                        table_date: 'Date',
                        table_status: 'Status',
                        table_actions: 'Actions',
                        action_view: 'View',
                        action_message: 'Message',
                        action_deactivate: 'Deactivate',
                        action_activate: 'Activate',
                        action_messages: 'Messages',
                        empty_title: 'No transaction found',
                        empty_message: 'Try modifying your filters',
                        modal_details_title: 'Listing Details',
                        modal_listing: 'Listing',
                        modal_advertiser: 'Advertiser',
                        modal_amount: 'Amount',
                        modal_location: 'Location',
                        modal_phone: 'Phone',
                        modal_delay: 'Delay',
                        modal_send_message: 'Send a message',
                        modal_recipient: 'Recipient',
                        modal_your_message: 'Your message',
                        modal_message_placeholder: 'Write your message here...',
                        modal_conversations: 'Conversations',
                        modal_conversation_with: 'Conversation with',
                        modal_reply_message: 'Reply to message',
                        modal_original_message: 'Original message from:',
                        modal_your_reply: 'Your reply',
                        modal_reply_placeholder: 'Write your reply here...',
                        modal_type_message: 'Write your message...',
                        loading_conversations: 'Loading conversations...',
                        loading_conversation: 'Loading conversation...',
                        no_conversation: 'No conversation',
                        no_conversation_message: 'No messages for this listing',
                        no_messages: 'No messages',
                        start_conversation: 'Start the conversation',
                        message_count: 'message(s)',
                        button_access_messages: 'Access messages',
                        button_cancel: 'Cancel',
                        button_send: 'Send',
                        you_admin: 'You (Admin)',
                        // Navigation translations
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
                darkMode: false,
                sidebarOpen: false,
                searchTerm: '',
                filterType: '',
                filterCountry: '',
                filterStatus: '',
                filterDelay: '',
                filterMinAmount: null,
                filterMaxAmount: null,
                currentPage: 1,
                itemsPerPage: 10,
                showDetailsModal: false,
                showMessageModal: false,
                showMessagesModal: false,
                showReplyModal: false,
                showChatModal: false,
                selectedListing: null,
                selectedMessage: null,
                selectedConversation: null,
                conversationsList: [],
                chatMessages: [],
                loadingChat: false,
                newChatMessage: '',
                sendingChatMessage: false,
                messageContent: '',
                replyContent: '',
                allListings: [],
                transactionMessages: [],
                loadingMessages: false,
                countries: [],
                messageCounts: {},
                conversationCounts: {},
            };
        },
        computed: {
            t() {
                return this.translations[this.currentLang];
            },
            offerCount() {
                return this.allListings.filter(l => l.type === 'Offre').length;
            },
            requestCount() {
                return this.allListings.filter(l => l.type === 'Demande').length;
            },
            activeCount() {
                return this.allListings.filter(l => l.status === 'Actif').length;
            },
            filteredListings() {
                let filtered = this.allListings;
                if (this.searchTerm) {
                    filtered = filtered.filter(l =>
                        l.first_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.last_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.city?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                        l.email?.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                }
                if (this.filterType) filtered = filtered.filter(l => l.type === this.filterType);
                if (this.filterCountry) filtered = filtered.filter(l => l.country === this.filterCountry);
                if (this.filterStatus) filtered = filtered.filter(l => l.status === this.filterStatus);
                if (this.filterDelay) filtered = filtered.filter(l => l.delay === this.filterDelay);
                if (this.filterMinAmount !== null && this.filterMinAmount !== '') {
                    filtered = filtered.filter(l => parseFloat(l.amount) >= this.filterMinAmount);
                }
                if (this.filterMaxAmount !== null && this.filterMaxAmount !== '') {
                    filtered = filtered.filter(l => parseFloat(l.amount) <= this.filterMaxAmount);
                }

                return filtered;
            },
            paginatedListings() {
                const start = (this.currentPage - 1) * this.itemsPerPage;
                return this.filteredListings.slice(start, start + this.itemsPerPage);
            },
            totalPages() {
                return Math.ceil(this.filteredListings.length / this.itemsPerPage);
            },
            visiblePages() {
                const pages = [];
                for (let i = 1; i <= this.totalPages; i++) {
                    if (i === 1 || i === this.totalPages || (i >= this.currentPage - 1 && i <= this.currentPage + 1)) {
                        pages.push(i);
                    }
                }
                return pages;
            }
        },
        async mounted() {
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }
            await this.fetchListings();
            await this.fetchAllMessageCounts();
        },
        methods: {
            toggleLanguage() {
                this.currentLang = this.currentLang === 'fr' ? 'en' : 'fr';
                localStorage.setItem('language', this.currentLang);
            },
            getTranslatedDelay(delay) {
                if (delay === 'Urgent') return this.t.delay_urgent;
                if (delay === 'Deux semaines') return this.t.delay_two_weeks;
                if (delay === 'Nulle') return this.t.delay_none;
                return delay;
            },
            async fetchListings() {
                try {
                    const response = await api.get('?action=allListings');
                    this.allListings = response.data || [];
                    this.countries = [...new Set(this.allListings.map(l => l.country).filter(Boolean))];
                } catch (error) {
                    console.error('Erreur:', error);
                    this.allListings = [];
                }
            },
            async fetchAllMessageCounts() {
                const promises = this.allListings.map(async (listing) => {
                    const messages = await this.fetchAllMessagesByListingId(listing.listing_id);
                    const unreadCount = messages.filter(m => m.status === 'Envoyé').length;
                    this.messageCounts[listing.listing_id] = unreadCount;

                    // Calculate conversation count (unique users excluding admin-to-admin)
                    const uniqueUsers = new Set();
                    messages.forEach(msg => {
                        const userId = msg.sender_id === 1 ? msg.receiver_id : msg.sender_id;
                        // Only count if it's not admin talking to admin
                        if (userId !== 1) {
                            uniqueUsers.add(userId);
                        }
                    });
                    this.conversationCounts[listing.listing_id] = uniqueUsers.size;
                });
                await Promise.all(promises);
            },
            getUnreadCount(listingId) {
                return this.messageCounts[listingId] || 0;
            },
            getConversationCount(listingId) {
                return this.conversationCounts[listingId] || 0;
            },
            async fetchAllMessagesByListingId(listingId) {
                try {
                    const response = await api.get(`?action=allMessagesByListingId&id=${listingId}`);
                    if (response.data && response.data.success) {
                        return response.data.data;
                    } else {
                        return [];
                    }
                } catch (error) {
                    console.error('Erreur lors de la récupération des messages :', error);
                    return [];
                }
            },
            getDelayDotColor(delay) {
                if (delay === 'Urgent') return 'bg-green-500';
                if (delay === 'Deux semaines') return 'bg-yellow-500';
                if (delay === 'Nulle') return 'bg-red-500';
                return 'bg-gray-500';
            },
            getDelayCardColor(delay) {
                if (delay === 'Urgent') return 'bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-green-200 dark:border-green-700';
                if (delay === 'Deux semaines') return 'bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border-yellow-200 dark:border-yellow-700';
                if (delay === 'Nulle') return 'bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-red-200 dark:border-red-700';
                return 'bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900/20 dark:to-gray-800/20 border-gray-200 dark:border-gray-700';
            },
            getDelayIconBgColor(delay) {
                if (delay === 'Urgent') return 'bg-green-500';
                if (delay === 'Deux semaines') return 'bg-yellow-500';
                if (delay === 'Nulle') return 'bg-red-500';
                return 'bg-gray-500';
            },
            getDelayTextColor(delay) {
                if (delay === 'Urgent') return 'text-green-600 dark:text-green-400';
                if (delay === 'Deux semaines') return 'text-yellow-600 dark:text-yellow-400';
                if (delay === 'Nulle') return 'text-red-600 dark:text-red-400';
                return 'text-gray-600 dark:text-gray-400';
            },
            getDelayTextDarkColor(delay) {
                if (delay === 'Urgent') return 'text-green-900 dark:text-green-100';
                if (delay === 'Deux semaines') return 'text-yellow-900 dark:text-yellow-100';
                if (delay === 'Nulle') return 'text-red-900 dark:text-red-100';
                return 'text-gray-900 dark:text-gray-100';
            },
            async markAsRead(message) {
                try {
                    await api.post('?action=markMessageAsRead', {
                        id: message.id
                    });
                    message.status = 'Lu';
                    if (this.selectedListing) {
                        const messages = await this.fetchAllMessagesByListingId(this.selectedListing.listing_id);
                        const unreadCount = messages.filter(m => m.status === 'Envoyé').length;
                        this.messageCounts[this.selectedListing.listing_id] = unreadCount;
                    }
                    alert('Message marqué comme lu!');
                } catch (error) {
                    console.error('Erreur:', error);
                    alert('Erreur lors du marquage du message');
                }
            },
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            applyFilters() {
                this.currentPage = 1;
            },
            formatCurrency(amount) {
                return new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 0
                }).format(amount);
            },
            formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('fr-FR', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },
            viewListingDetails(listing) {
                this.selectedListing = listing;
                this.showDetailsModal = true;
            },
            closeDetailsModal() {
                this.showDetailsModal = false;
                this.selectedListing = null;
            },
            openMessageModal(listing) {
                this.selectedListing = listing;
                this.messageContent = '';
                this.showMessageModal = true;
            },
            closeMessageModal() {
                this.showMessageModal = false;
                this.selectedListing = null;
                this.messageContent = '';
            },
            async sendMessage() {
                console.log('sendMessage appelée');
                const content = this.messageContent.trim();
                if (!content) return;

                const payload = {
                    listing_id: this.selectedListing.listing_id,
                    message: content,
                    receiver_id: this.selectedListing.user_id,
                };
                console.log('Requête envoyée à sendMessage:', payload);

                try {
                    const {
                        data
                    } = await api.post('?action=sendMessage', payload);

                    console.log('Réponse du serveur:', data);

                    if (data.success) {
                        alert(data.message || 'Message envoyé avec succès !');
                        this.closeMessageModal();
                    } else {
                        alert(data.error || 'Une erreur est survenue.');
                    }
                } catch (error) {
                    console.error('Erreur réseau :', error);
                    alert('Erreur de communication avec le serveur.');
                }
            },

            async toggleStatus(listing) {
                const newStatus = listing.status === 'Actif' ? 'Inactif' : 'Actif';
                try {
                    await api.post('?action=updateListingStatus', {
                        id: listing.listing_id,
                        status: newStatus
                    });
                    listing.status = newStatus;
                } catch (error) {
                    console.error('Erreur:', error);
                }
            },
            async openMessagesModal(listingId) {
                const listing = this.allListings.find(l => l.listing_id === listingId);
                if (!listing) {
                    console.error('Listing not found for ID:', listingId);
                    return;
                }

                this.selectedListing = listing;
                this.showMessagesModal = true;
                this.loadingMessages = true;

                const messages = await this.fetchAllMessagesByListingId(listingId);

                // Group messages by user (sender), excluding admin-to-admin conversations
                const conversationsMap = new Map();
                messages.forEach(msg => {
                    const userId = msg.sender_id === 1 ? msg.receiver_id : msg.sender_id;

                    // Skip if this is admin talking to admin
                    if (userId === 1) {
                        return;
                    }

                    if (!conversationsMap.has(userId)) {
                        conversationsMap.set(userId, {
                            user_id: userId,
                            first_name: msg.sender_id === 1 ? (msg.receiver_first_name || msg.first_name) : (msg.sender_first_name || msg.first_name),
                            last_name: msg.sender_id === 1 ? (msg.receiver_last_name || msg.last_name) : (msg.sender_last_name || msg.last_name),
                            sender_first_name: msg.sender_id === 1 ? (msg.receiver_first_name || msg.first_name) : (msg.sender_first_name || msg.first_name),
                            sender_last_name: msg.sender_id === 1 ? (msg.receiver_last_name || msg.last_name) : (msg.sender_last_name || msg.last_name),
                            email: msg.email,
                            messages: [],
                            last_message: '',
                            last_message_date: '',
                            message_count: 0
                        });
                    }

                    const conversation = conversationsMap.get(userId);
                    conversation.messages.push(msg);
                    conversation.message_count++;

                    if (!conversation.last_message_date || new Date(msg.created_at) > new Date(conversation.last_message_date)) {
                        conversation.last_message = msg.message;
                        conversation.last_message_date = msg.created_at;
                    }
                });

                this.conversationsList = Array.from(conversationsMap.values()).sort((a, b) =>
                    new Date(b.last_message_date) - new Date(a.last_message_date)
                );

                this.loadingMessages = false;
            },
            closeMessagesModal() {
                this.showMessagesModal = false;
                this.selectedListing = null;
                this.conversationsList = [];
            },

            async openChatModal(conversation) {
                this.selectedConversation = conversation;
                this.showChatModal = true;
                this.loadingChat = true;
                this.chatMessages = [];

                try {
                    const res = await api.get(`?action=getConversation&listing_id=${this.selectedListing.listing_id}&user_id=${conversation.user_id}`);

                    if (res.data && res.data.success && Array.isArray(res.data.messages)) {
                        this.chatMessages = res.data.messages.sort((a, b) =>
                            new Date(a.created_at) - new Date(b.created_at)
                        );
                    }
                } catch (error) {
                    console.error("Erreur lors du chargement de la conversation:", error);
                } finally {
                    this.loadingChat = false;
                    this.$nextTick(() => {
                        setTimeout(() => {
                            this.scrollToBottom();
                        }, 100);
                    });
                }
            },

            closeChatModal() {
                this.showChatModal = false;
                this.selectedConversation = null;
                this.chatMessages = [];
                this.newChatMessage = '';
            },

            async sendChatMessage() {
                console.log('nouveau chat !!')
                if (!this.newChatMessage.trim() || this.sendingChatMessage) return;

                this.sendingChatMessage = true;
                try {
                    const response = await api.post('?action=sendMessage', {
                        listing_id: this.selectedListing.listing_id,
                        message: this.newChatMessage.trim(),
                        receiver_id: this.selectedConversation.user_id
                    });

                    if (response.data && response.data.success) {
                        this.chatMessages.push({
                            id: Date.now(),
                            listing_id: this.selectedListing.listing_id,
                            sender_id: 1,
                            receiver_id: this.selectedConversation.user_id,
                            message: this.newChatMessage.trim(),
                            created_at: new Date().toISOString(),
                            first_name: 'Admin',
                            last_name: ''
                        });

                        this.newChatMessage = '';
                        this.$nextTick(() => {
                            setTimeout(() => {
                                this.scrollToBottom();
                            }, 50);
                        });
                    } else {
                        alert(response.data?.error || 'Erreur lors de l\'envoi du message.');
                    }
                } catch (error) {
                    console.error('Erreur lors de l\'envoi du message :', error);
                    alert('Erreur de communication avec le serveur.');
                } finally {
                    this.sendingChatMessage = false;
                }
            },

            scrollToBottom() {
                const container = this.$refs.chatContainer;
                if (container) {
                    container.scrollTo({
                        top: container.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            },

            openReplyModal(message) {
                this.selectedMessage = message;
                this.replyContent = '';
                this.showReplyModal = true;
            },
            closeReplyModal() {
                this.showReplyModal = false;
                this.selectedMessage = null;
                this.replyContent = '';
            },
            async sendReply() {
                if (!this.replyContent.trim()) {
                    alert("Le message ne peut pas être vide.");
                    return;
                }

                try {
                    const response = await api.post('?action=sendMessage', {
                        transaction_id: this.selectedListing.listing_id,
                        message: this.replyContent,
                        receiver_id: this.selectedMessage.sender_id
                    });

                    if (response.data && response.data.success) {
                        alert(response.data.message || 'Réponse envoyée avec succès !');
                        this.closeReplyModal();
                        const messages = await this.fetchAllMessagesByListingId(this.selectedListing.listing_id);
                        this.transactionMessages = messages;
                    } else {
                        const errorMessage = response.data?.error || "Erreur inconnue lors de l'envoi du message. |";
                        alert('Échec : ' + errorMessage);
                    }
                } catch (error) {
                    console.error("Erreur lors de l' envoi de la réponse: ," + error);
                    alert("Une erreur est survenue. Vérifie ta connexion ou réessaie plus tard.");
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

    .dark-mode input,
    .dark-mode select,
    .dark-mode textarea {
        background-color: var(--bg-dark-secondary) !important;
        color: #F9FAFB !important;
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

        .responsive-table thead {
            display: none;
        }

        .responsive-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .dark-mode .responsive-table tbody tr {
            border-color: #334155;
        }

        .responsive-table tbody tr:hover {
            background-color: transparent !important;
        }

        .responsive-table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #f3f4f6;
            position: relative;
            padding-left: 50%;
        }

        .dark-mode .responsive-table tbody td {
            border-bottom-color: #1e293b;
        }

        .responsive-table tbody td:last-child {
            border-bottom: none;
        }

        .responsive-table tbody td::before {
            content: attr(data-label);
            position: absolute;
            left: 1rem;
            width: 45%;
            text-align: left;
            font-weight: 600;
            color: #374151;
        }

        .dark-mode .responsive-table tbody td::before {
            color: #94A3B8;
        }

        .responsive-table tbody td[data-label="Annonceur"] {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .responsive-table tbody td[data-label="Actions"] .flex {
            justify-content: flex-end;
            gap: 1rem;
        }

        .responsive-table tbody td[data-label="Actions"] .flex button {
            font-size: 1.125rem;
        }
    }

    .dark-mode tr:hover {
        background-color: var(--bg-gray-750) !important;
    }
</style>

<?php $content = ob_get_clean(); ?>
<?php require './src/view/layout.php'; ?>