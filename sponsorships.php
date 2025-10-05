<?php
$pageTitle = 'Parrainages';
$currentPage = 'parrainages';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - AMPAY</title>
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

        .dark-mode .bg-gray-50 {
            background-color: var(--bg-dark) !important;
        }

        .dark-mode .text-gray-900 {
            color: #F9FAFB !important;
        }

        .dark-mode .text-gray-700 {
            color: #94A3B8 !important;
        }

        .dark-mode .border-gray-200 {
            border-color: #334155 !important;
        }

        .dark-mode tr:hover {
            background-color: #334155 !important;
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

            table thead {
                display: none;
            }

            table,
            tbody,
            tr,
            td {
                display: block;
                width: 100%;
            }

            tr {
                margin-bottom: 1rem;
                border-bottom: 1px solid #ccc;
            }

            td {
                padding: 0.5rem;
                text-align: right;
                position: relative;
            }

            td::before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 0.5rem;
                font-weight: bold;
                text-align: left;
            }
        }

        @media print {
            .no-print {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .bg-white,
            .bg-gray-50 {
                background: white !important;
            }

            .shadow-sm,
            .shadow-md {
                box-shadow: none !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .print-title {
                display: block !important;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }
        }

        .print-title {
            display: none;
        }
    </style>
</head>

<body>
    <div id="app">
        <div v-if="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-50 z-30 md:hidden"></div>

        <div class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
            <?php include 'sidebar.php'; ?>

            <div class="flex-1 md:ml-0">

                <header class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-20 no-print">
                    <div class="px-4 sm:px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <button @click="sidebarOpen = true" class="md:hidden text-gray-600 dark:text-gray-300">
                                    <i class="fas fa-bars text-xl"></i>
                                </button>
                                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-gray-100">
                                    Liste des parrainages
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

                <div class="p-4 sm:p-6">
                    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Parrainages</h1>
                            <p class="text-gray-600 dark:text-gray-400">Liste de tous les parrainages effectués</p>
                        </div>
                        <button
                            @click="printList"
                            class="w-[200px] sm:w-auto px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-purple-600 to-indigo-600 
           hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-medium 
           transition-all shadow-lg flex items-center justify-center gap-2 no-print">
                            <i class="fas fa-print"></i>
                            <span class="hidden sm:inline">Imprimer la liste</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-friends text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ allSponsorships.length }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Parrainages</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-plus text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ uniqueSponsors }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Parrains Actifs</div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6">
                            <div class="flex items-center justify-between mb-2">
                                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                            </div>
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-1">{{ uniqueSponsored }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Filleuls</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-6 mb-6 no-print">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input v-model="searchTerm" @input="applyFilters" type="text" placeholder="Rechercher par nom..." class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <select v-model="sortBy" @change="applyFilters" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="date">Trier par date</option>
                                <option value="sponsor">Trier par parrain</option>
                                <option value="sponsored">Trier par filleul</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Parrain</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Filleul</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="sponsorship in paginatedSponsorships" :key="sponsorship.id" class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                        <td data-label="Parrain" class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 primary-gradient rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ sponsorship.sponsor_first_name }} {{ sponsorship.sponsor_last_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Filleul" class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ sponsorship.sponsored_first_name }} {{ sponsorship.sponsored_last_name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="Date" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ formatDate(sponsorship.created_at) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-white dark:bg-gray-800 px-4 py-3 flex items-center justify-between border-t border-gray-200 dark:border-gray-700 sm:px-6 no-print">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <button @click="previousPage" :disabled="currentPage === 1" class="relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                    Précédent
                                </button>
                                <button @click="nextPage" :disabled="currentPage === totalPages" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                    Suivant
                                </button>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">
                                        Affichage de <span class="font-medium">{{ startItem }}</span> à <span class="font-medium">{{ endItem }}</span> sur <span class="font-medium">{{ totalItems }}</span> résultats
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                                        <button @click="previousPage" :disabled="currentPage === 1" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                        <button v-for="page in visiblePages" :key="page" @click="goToPage(page)" :class="['relative inline-flex items-center px-4 py-2 border text-sm font-medium', currentPage === page ? 'z-10 primary-gradient border-primary text-white' : 'bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700']">
                                            {{ page }}
                                        </button>
                                        <button @click="nextPage" :disabled="currentPage === totalPages" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-sm font-medium text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50">
                                            <i class="fas fa-chevron-right"></i>
                                        </button>
                                    </nav>
                                </div>
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
            baseURL: 'http://127.0.0.1/ampay/api/index.php'
        });

        createApp({
            data() {
                return {
                    darkMode: false,
                    searchTerm: '',
                    sortBy: 'date',
                    sidebarOpen: false,
                    currentPage: 1,
                    itemsPerPage: 10,
                    allSponsorships: []
                };
            },
            computed: {
                uniqueSponsors() {
                    return [...new Set(this.allSponsorships.map(s => s.sponsor_id))].length;
                },
                uniqueSponsored() {
                    return [...new Set(this.allSponsorships.map(s => s.sponsored_id))].length;
                },
                filteredSponsorships() {
                    let filtered = this.allSponsorships;
                    if (this.searchTerm) {
                        filtered = filtered.filter(s =>
                            s.sponsor_first_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                            s.sponsor_last_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                            s.sponsored_first_name?.toLowerCase().includes(this.searchTerm.toLowerCase()) ||
                            s.sponsored_last_name?.toLowerCase().includes(this.searchTerm.toLowerCase())
                        );
                    }
                    if (this.sortBy === 'date') filtered.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
                    else if (this.sortBy === 'sponsor') filtered.sort((a, b) => a.sponsor_first_name.localeCompare(b.sponsor_first_name));
                    else if (this.sortBy === 'sponsored') filtered.sort((a, b) => a.sponsored_first_name.localeCompare(b.sponsored_first_name));
                    return filtered;
                },
                paginatedSponsorships() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredSponsorships.slice(start, start + this.itemsPerPage);
                },
                totalPages() {
                    return Math.ceil(this.filteredSponsorships.length / this.itemsPerPage);
                },
                totalItems() {
                    return this.filteredSponsorships.length;
                },
                startItem() {
                    return (this.currentPage - 1) * this.itemsPerPage + 1;
                },
                endItem() {
                    return Math.min(this.currentPage * this.itemsPerPage, this.totalItems);
                },
                visiblePages() {
                    const pages = [],
                        total = this.totalPages,
                        current = this.currentPage;
                    for (let i = 1; i <= total; i++)
                        if (i === 1 || i === total || (i >= current - 1 && i <= current + 1)) pages.push(i);
                    return pages;
                }
            },
            async mounted() {
                if (localStorage.getItem('darkMode') === 'true') {
                    this.darkMode = true;
                    document.body.classList.add('dark-mode');
                }
                await this.fetchSponsorships();
            },
            methods: {
                async fetchSponsorships() {
                    try {
                        const response = await api.get('?action=allSponsorships');
                        this.allSponsorships = response.data || [];
                    } catch (error) {
                        console.error('Erreur lors du chargement des parrainages:', error);
                        this.allSponsorships = [];
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
                formatDate(dateString) {
                    return new Date(dateString).toLocaleDateString('fr-FR', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                },
                printList() {
                    window.print();
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
</body>

</html>