<?php $title = "AmPay - Accueil"; ?>


<?php

ob_start(); ?>


<div class="app" id="app">
    <?php include 'header.php'; ?>


    <section class="parallax hero-gradient pt-32 pb-20 min-h-screen flex items-center" style="background-image: url('https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=1920&h=1080&fit=crop');">
        <div class="parallax-content container mx-auto px-4 sm:px-6">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-6 slide-in-left">
                    <div class="inline-block px-4 py-2 bg-primary/20 backdrop-blur-sm rounded-full text-primary-light border border-primary/30">
                        <i class="fas fa-star mr-2"></i>
                        <span class="font-semibold">Transferts d'argent instantané </span>
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                        Transfert d'argent <span class="text-primary">sans intermédiaire</span>
                    </h1>
                    <p class="text-xl text-gray-300 leading-relaxed">
                        Connectez-vous directement avec des personnes qui ont des besoins complémentaires. Rapide, sécurisé et international.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="index.php?action=marketplace" class="px-8 py-4 primary-gradient text-white rounded-lg text-lg font-semibold hover:opacity-90 transition-opacity text-center shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>Commencer maintenant
                        </a>
                        <a href="#how-it-works" class="px-8 py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 rounded-lg text-lg font-semibold hover:bg-white/20 transition-colors text-center">
                            <i class="fas fa-play-circle mr-2"></i>Découvrir
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-4 pt-8">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">2.5K+</div>
                            <div class="text-sm text-gray-400">Utilisateurs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">15+</div>
                            <div class="text-sm text-gray-400">Pays</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">€2M+</div>
                            <div class="text-sm text-gray-400">Transférés</div>
                        </div>
                    </div>
                </div>

                <div class="hidden lg:flex justify-center slide-in-right">
                    <div class="relative float-animation">
                        <img src="/placeholder.svg?height=600&width=300" alt="AMPAY App" class="mobile-mockup">
                        <div class="absolute -left-8 top-20 bg-white rounded-xl p-4 shadow-2xl" style="animation: float 3s ease-in-out infinite; animation-delay: 0.5s;">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Transfert réussi</div>
                                    <div class="text-lg font-bold text-gray-900">500 EUR</div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute -right-8 bottom-32 bg-white rounded-xl p-4 shadow-2xl" style="animation: float 3s ease-in-out infinite; animation-delay: 1s;">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-bolt text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-600">Instantané</div>
                                    <div class="text-lg font-bold text-gray-900">2 min</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 items-center">
                <div class="text-center fade-in-up">
                    <i class="fas fa-shield-alt text-4xl text-primary mb-2"></i>
                    <div class="font-semibold text-gray-900">100% Sécurisé</div>
                </div>
                <div class="text-center fade-in-up" style="animation-delay: 0.1s;">
                    <i class="fas fa-bolt text-4xl text-primary mb-2"></i>
                    <div class="font-semibold text-gray-900">Instantané</div>
                </div>
                <div class="text-center fade-in-up" style="animation-delay: 0.2s;">
                    <i class="fas fa-coins text-4xl text-primary mb-2"></i>
                    <div class="font-semibold text-gray-900">Frais réduits</div>
                </div>
                <div class="text-center fade-in-up" style="animation-delay: 0.3s;">
                    <i class="fas fa-headset text-4xl text-primary mb-2"></i>
                    <div class="font-semibold text-gray-900">Support 24/7</div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Nos Services</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Deux profils, une solution innovante pour vos transferts d'argent</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto mb-16">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1633158829585-23ba8f7c8caf?w=800&h=400&fit=crop" alt="Offreur" class="absolute inset-0 w-full h-full object-cover opacity-30">
                        <i class="fas fa-hand-holding-usd text-white text-6xl relative z-10"></i>
                    </div>
                    <div class="p-8">
                        <div class="inline-block px-4 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold mb-4">
                            Pour Offreurs
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Proposez vos espèces</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Vous avez de l'argent en espèces ? Proposez-le et gagnez une commission sur chaque transaction.
                        </p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Définissez votre montant disponible</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Choisissez votre devise et localisation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Recevez des demandes instantanément</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Gagnez des commissions attractives</span>
                            </li>
                        </ul>
                        <a href="marketplace.html" class="block w-full px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold text-center transition-colors">
                            Devenir offreur
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover-lift">
                    <div class="h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center relative overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&h=400&fit=crop" alt="Demandeur" class="absolute inset-0 w-full h-full object-cover opacity-30">
                        <i class="fas fa-hand-holding-heart text-white text-6xl relative z-10"></i>
                    </div>
                    <div class="p-8">
                        <div class="inline-block px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-4">
                            Pour Demandeurs
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-4">Recevez des espèces</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Besoin d'argent en espèces rapidement ? Trouvez un offreur près de chez vous en quelques clics.
                        </p>
                        <ul class="space-y-3 mb-6">
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Indiquez le montant souhaité</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Précisez votre localisation</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Connectez-vous avec un offreur vérifié</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check-circle text-blue-600 mt-1 mr-3"></i>
                                <span class="text-gray-700">Recevez votre argent rapidement</span>
                            </li>
                        </ul>
                        <a href="marketplace.html" class="block w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold text-center transition-colors">
                            Faire une demande
                        </a>
                    </div>
                </div>
            </div>

            <div class="text-center mb-12 fade-in-up">
                <h3 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Offres et Demandes Récentes</h3>
                <p class="text-lg text-gray-600">Découvrez les dernières opportunités disponibles</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <div>
                    <h4 class="text-2xl font-bold text-green-600 mb-6 flex items-center">
                        <i class="fas fa-hand-holding-usd mr-3"></i>Offres Disponibles
                    </h4>
                    <div class="space-y-4">
                        <div v-for="offer in recentOffers" :key="offer.id" class="bg-white rounded-xl shadow-sm overflow-hidden hover-lift border-l-4 border-green-500">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-hand-holding-usd mr-1"></i>
                                        Offre
                                    </span>
                                </div>

                                <div class="flex items-center mb-4">
                                    <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <i class="fas fa-hashtag text-white"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">Nouvelle offre</p>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>{{ offer.ratings }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="country-badge mb-2">
                                        <i class="fas fa-flag" style="color: var(--primary);"></i>
                                        <span class="font-semibold text-gray-900">{{ offer.country }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-map-marker-alt w-5" style="color: var(--primary);"></i>
                                        <span class="font-medium">{{ offer.city }}</span>
                                    </div>
                                </div>

                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Montant</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-coins text-primary mr-2"></i>
                                            <span class="text-sm text-gray-600">{{ offer.currency }}</span>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ formatCurrency(offer.amount) }}
                                    </div>
                                </div>

                                <div class="text-sm text-gray-500 mb-4">
                                    <i class="fas fa-clock mr-1"></i>{{ offer.timeAgo }}
                                </div>

                                <button @click="openContactModal(offer)" class="w-full py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-comment mr-2"></i>Mettre en relation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-2xl font-bold text-yellow-600 mb-6 flex items-center">
                        <i class="fas fa-hand-holding-heart mr-3"></i>Demandes Actives
                    </h4>
                    <div class="space-y-4">
                        <div v-for="request in recentRequests" :key="request.id" class="bg-white rounded-xl shadow-sm overflow-hidden hover-lift border-l-4 border-yellow-500">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                        <i class="fas fa-hand-holding-heart mr-1"></i>
                                        Demande
                                    </span>
                                </div>

                                <div class="flex items-center mb-4">
                                    <div class="bg-yellow-500 w-12 h-12 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                        <i class="fas fa-hashtag text-white"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-gray-900 truncate">Nouvelle demande</p>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-star text-yellow-500 mr-1"></i>{{ request.ratings }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="country-badge mb-2">
                                        <i class="fas fa-flag" style="color: var(--primary);"></i>
                                        <span class="font-semibold text-gray-900">{{ request.country }}</span>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <i class="fas fa-map-marker-alt w-5" style="color: var(--primary);"></i>
                                        <span class="font-medium">{{ request.city }}</span>
                                    </div>
                                </div>

                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Montant</span>
                                        <div class="flex items-center">
                                            <i class="fas fa-coins text-primary mr-2"></i>
                                            <span class="text-sm text-gray-600">{{ request.currency }}</span>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-bold text-gray-900 mt-1">
                                        {{ formatCurrency(request.amount) }}
                                    </div>
                                </div>

                                <div class="text-sm text-gray-500 mb-4">
                                    <i class="fas fa-clock mr-1"></i>{{ request.timeAgo }}
                                </div>

                                <button @click="openContactModal(request)" class="w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-comment mr-2"></i>Mettre en relation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <a href="index.php?action=marketplace" class="inline-block px-8 py-4 primary-gradient text-white rounded-lg text-lg font-semibold hover:opacity-90 transition-opacity shadow-lg">
                    <i class="fas fa-store mr-2"></i>Voir toutes les offres
                </a>
            </div>
        </div>
    </section>

    <section id="how-it-works" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Comment ça marche ?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Un processus simple en 3 étapes</p>
            </div>

            <div class="grid sm:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div v-for="(step, index) in steps" :key="index" class="text-center fade-in-up" :style="`animation-delay: ${index * 0.1}s`">
                    <div class="relative mb-6">
                        <div class="w-20 h-20 primary-gradient rounded-full flex items-center justify-center text-3xl font-bold text-white mx-auto shadow-lg">
                            {{ index + 1 }}
                        </div>
                        <div v-if="index < 2" class="hidden sm:block absolute top-10 left-full w-full h-0.5 bg-gradient-to-r from-primary to-transparent"></div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 h-full hover-lift">
                        <i :class="step.icon + ' text-primary text-5xl mb-4'"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ step.title }}</h3>
                        <p class="text-gray-600 leading-relaxed">{{ step.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="parallax py-20" style="background-image: url('https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920&h=800&fit=crop');">
        <div class="parallax-content container mx-auto px-4 sm:px-6">
            <div class="text-center mb-16 text-white fade-in-up">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4">Pourquoi choisir AMPAY ?</h2>
                <p class="text-xl text-gray-300 max-w-2xl mx-auto">Des fonctionnalités pensées pour votre sécurité et votre confort</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div v-for="(feature, index) in features" :key="index" class="bg-white/10 backdrop-blur-md rounded-xl p-6 hover-lift border border-white/20" :style="`animation-delay: ${index * 0.1}s`">
                    <div class="w-16 h-16 primary-gradient rounded-lg flex items-center justify-center mb-4">
                        <i :class="feature.icon + ' text-white text-2xl'"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ feature.title }}</h3>
                    <p class="text-gray-300 leading-relaxed">{{ feature.description }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gradient-to-br from-amber-50 to-orange-50">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-12 text-center max-w-4xl mx-auto fade-in-up">
                <div class="w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-gift text-white text-4xl"></i>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Programme de Parrainage</h2>
                <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto leading-relaxed">
                    Invitez vos amis et bénéficiez de <span class="text-amber-600 font-bold text-2xl">-10%</span> de commission sur leur première opération !
                </p>
                <div class="grid sm:grid-cols-2 gap-6 mb-8">
                    <div class="stat-card rounded-xl p-6">
                        <div class="text-3xl font-bold text-primary mb-2">-10%</div>
                        <div class="text-sm text-gray-600">Commission réduite</div>
                    </div>
                    <div class="stat-card rounded-xl p-6">
                        <div class="text-3xl font-bold text-primary mb-2">∞</div>
                        <div class="text-sm text-gray-600">Parrainages illimités</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Questions Fréquentes</h2>
                <p class="text-xl text-gray-600">Tout ce que vous devez savoir sur AMPAY</p>
            </div>

            <div class="space-y-4">
                <div v-for="(faq, index) in faqs" :key="index" class="bg-gray-50 rounded-xl overflow-hidden hover-lift">
                    <button @click="toggleFaq(index)" class="w-full px-6 py-5 text-left flex items-center justify-between hover:bg-gray-100 transition-colors">
                        <span class="text-lg font-semibold text-gray-900 pr-4">{{ faq.question }}</span>
                        <i :class="faq.open ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-primary text-xl flex-shrink-0"></i>
                    </button>
                    <div v-if="faq.open" class="px-6 pb-5">
                        <p class="text-gray-600 leading-relaxed">{{ faq.answer }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 max-w-4xl">
            <div class="text-center mb-16 fade-in-up">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">Contactez-nous</h2>
                <p class="text-xl text-gray-600">Une question ? Notre équipe est là pour vous aider</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8">
                <form @submit.prevent="submitContactForm" class="space-y-6">
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1 text-primary"></i>Nom complet
                            </label>
                            <input v-model="contactForm.name" type="text" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Jean Dupont">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-1 text-primary"></i>Email
                            </label>
                            <input v-model="contactForm.email" type="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="jean@example.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1 text-primary"></i>Téléphone
                        </label>
                        <input v-model="contactForm.phone" type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="+33 6 12 34 56 78">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-1 text-primary"></i>Sujet
                        </label>
                        <select v-model="contactForm.subject" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">Sélectionnez un sujet</option>
                            <option value="general">Question générale</option>
                            <option value="support">Support technique</option>
                            <option value="partnership">Partenariat</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-comment mr-1 text-primary"></i>Message
                        </label>
                        <textarea v-model="contactForm.message" required rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Votre message..."></textarea>
                    </div>

                    <button type="submit" :disabled="contactFormSubmitting" class="w-full px-8 py-4 primary-gradient text-white rounded-lg text-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ contactFormSubmitting ? 'Envoi en cours...' : 'Envoyer le message' }}
                    </button>

                    <div v-if="contactFormSuccess" class="p-4 bg-green-100 text-green-700 rounded-lg">
                        <i class="fas fa-check-circle mr-2"></i>Message envoyé avec succès ! Nous vous répondrons bientôt.
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="py-20 hero-gradient">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <div class="max-w-3xl mx-auto text-white fade-in-up">
                <h2 class="text-4xl sm:text-5xl font-bold mb-6">Prêt à commencer ?</h2>
                <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                    Rejoignez des milliers d'utilisateurs qui font confiance à AMPAY pour leurs transferts d'argent
                </p>
                <a href="index.php?action=marketplace" class="inline-block px-8 py-4 primary-gradient text-white rounded-lg text-lg font-semibold hover:opacity-90 transition-opacity shadow-lg">
                    <i class="fas fa-rocket mr-2"></i>Accéder à la Marketplace
                </a>
            </div>
        </div>
    </section>

    <div v-if="showContactModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay" @click.self="closeContactModal">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 modal-content">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-handshake text-primary mr-2"></i>Mise en relation
                </h3>
                <button @click="closeContactModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div v-if="selectedListing" class="mb-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center mb-3">
                    <div :class="selectedListing.type === 'Offre' ? 'bg-green-500' : 'bg-yellow-500'" class="w-12 h-12 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-hashtag text-white"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900">Annonce #{{ selectedListing.id }}</p>
                        <p class="text-sm text-gray-600">{{ selectedListing.city }}, {{ selectedListing.country }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span :class="selectedListing.type === 'Offre' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'" class="px-3 py-1 rounded-full text-sm font-semibold">
                        {{ selectedListing.type }}
                    </span>
                    <span class="text-xl font-bold text-gray-900">
                        {{ formatCurrency(selectedListing.amount) }} {{ selectedListing.currency }}
                    </span>
                </div>
            </div>

            <form @submit.prevent="submitContactRequest" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-comment mr-1 text-primary"></i>Message
                    </label>
                    <textarea v-model="contactRequest.message" rows="4" required style="color: black;"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary
                      focus:border-transparent" placeholder="Votre message..."></textarea>
                </div>

                <button type="submit" :disabled="contactRequestSubmitting" class="w-full py-3 primary-gradient text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50">
                    <i class="fas fa-paper-plane mr-2"></i>
                    {{ contactRequestSubmitting ? 'Envoi en cours...' : 'Envoyer la demande' }}
                </button>

                <div v-if="contactRequestSuccess" class="p-4 bg-green-100 text-green-700 rounded-lg text-sm">
                    <i class="fas fa-check-circle mr-2"></i>Demande envoyée ! Nous vous mettrons en contact sous peu.
                </div>
            </form>
        </div>
    </div>

    <?php include 'footer.php'; ?>
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
                mobileMenuOpen: false,
                contactFormSubmitting: false,
                contactFormSuccess: false,
                showContactModal: false,
                selectedListing: null,
                contactRequestSubmitting: false,
                contactRequestSuccess: false,
                contactRequest: {
                    message: ''
                },
                isAuthenticated: <?php echo json_encode(isset($_SESSION['id'])); ?>,
                contactForm: {
                    name: '',
                    email: '',
                    phone: '',
                    subject: '',
                    message: ''
                },
                steps: [{
                        icon: 'fas fa-user-plus',
                        title: 'Inscription',
                        description: 'Créez votre compte gratuitement en moins de 2 minutes'
                    },
                    {
                        icon: 'fas fa-handshake',
                        title: 'Connexion',
                        description: 'Trouvez et échangez avec l\'autre partie en toute sécurité'
                    },
                    {
                        icon: 'fas fa-check-double',
                        title: 'Transaction',
                        description: 'Finalisez le transfert et recevez votre argent instantanément'
                    }
                ],
                recentOffers: [],
                recentRequests: [],
                features: [{
                        icon: 'fas fa-shield-alt',
                        title: 'Sécurité maximale',
                        description: 'Vérification d\'identité, cryptage des données et protection contre la fraude'
                    },
                    {
                        icon: 'fas fa-percentage',
                        title: 'Frais transparents',
                        description: 'Commissions réduites et affichées clairement avant chaque transaction'
                    },
                    {
                        icon: 'fas fa-globe-africa',
                        title: 'Multi-pays',
                        description: 'Disponible dans 15+ pays en Afrique et en Europe'
                    },
                    {
                        icon: 'fas fa-headset',
                        title: 'Support 24/7',
                        description: 'Équipe disponible à tout moment pour vous assister'
                    }
                ],
                faqs: [{
                        question: 'Comment fonctionne AMPAY ?',
                        answer: 'AMPAY met en relation des personnes qui ont de l\'argent en espèces dans une ville avec celles qui en ont besoin. La plateforme facilite la mise en relation et prend une petite commission sur chaque transaction. C\'est simple, rapide et sécurisé.',
                        open: false
                    },
                    {
                        question: 'Quelles devises sont supportées ?',
                        answer: 'Nous supportons les principales devises africaines (XOF, NGN, GHS, MAD, TND) et européennes (EUR, GBP, CHF). D\'autres devises seront ajoutées prochainement selon la demande.',
                        open: false
                    },
                    {
                        question: 'Comment sont calculées les commissions ?',
                        answer: 'Les commissions varient entre 2% et 5% selon le montant et la devise. Elles sont toujours affichées clairement avant la transaction. Les parrainages offrent -10% sur la première opération.',
                        open: false
                    },
                    {
                        question: 'La plateforme est-elle sécurisée ?',
                        answer: 'Oui, nous utilisons des protocoles de sécurité avancés (SSL, cryptage des données, authentification à deux facteurs). Tous les utilisateurs sont vérifiés avant de pouvoir effectuer des transactions.',
                        open: false
                    },
                    {
                        question: 'Combien de temps prend un transfert ?',
                        answer: 'La plupart des transferts sont effectués en moins de 30 minutes. Le temps peut varier selon la disponibilité des offreurs dans votre zone et la rapidité de la mise en relation.',
                        open: false
                    },
                    {
                        question: 'Comment fonctionne le programme de parrainage ?',
                        answer: 'Invitez un ami avec votre code de parrainage unique. Lorsqu\'il effectue sa première transaction, vous bénéficiez tous les deux d\'une réduction de 10% sur les commissions. Aucune limite de parrainages !',
                        open: false
                    }
                ]
            };
        },
        mounted() {
            // Check for saved dark mode preference
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                this.darkMode = true;
                document.body.classList.add('dark-mode');
            }

            this.fetchListings();

            // Intersection Observer for fade-in animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-up, .slide-in-left, .slide-in-right').forEach(el => {
                el.style.opacity = '0';
                observer.observe(el);
            });
        },
        methods: {
            async fetchListings() {
                try {
                    const response = await api.get('', {
                        params: {
                            action: 'allListings'
                        }
                    });
                    const data = response.data || [];

                    // Trier par created_at décroissant
                    const sortedData = data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

                    // Ajouter timeAgo
                    const processedListings = sortedData.map(listing => {
                        const createdDate = new Date(listing.created_at);
                        const now = new Date();
                        const diffHours = Math.floor((now - createdDate) / (1000 * 60 * 60));
                        const diffDays = Math.floor(diffHours / 24);

                        return {
                            ...listing,
                            timeAgo: diffHours < 1 ?
                                "Il y a moins d'1h" : diffHours < 24 ?
                                `Il y a ${diffHours}h` : `Il y a ${diffDays} jour${diffDays > 1 ? 's' : ''}`
                        };
                    });

                    // Séparer les derniers 2 offres et derniers 2 demandes
                    this.recentOffers = processedListings.filter(l => l.type === 'Offre').slice(0, 2);
                    this.recentRequests = processedListings.filter(l => l.type === 'Demande').slice(0, 2);

                    // Optionnel : extraire les pays, villes, devises
                    this.countries = [...new Set(data.map(l => l.country))].sort();
                    this.citiesByCountry = {};
                    data.forEach(listing => {
                        if (!this.citiesByCountry[listing.country]) this.citiesByCountry[listing.country] = [];
                        if (!this.citiesByCountry[listing.country].includes(listing.city)) {
                            this.citiesByCountry[listing.country].push(listing.city);
                        }
                    });
                    Object.keys(this.citiesByCountry).forEach(country => {
                        this.citiesByCountry[country].sort();
                    });
                    this.currencies = [...new Set(data.map(l => l.currency))].sort();

                } catch (error) {
                    console.error('Erreur lors du chargement des listings:', error);
                    this.listings = [];
                    this.recentOffers = [];
                    this.recentRequests = [];
                }
            },

            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', this.darkMode);
            },
            toggleMobileMenu() {
                this.mobileMenuOpen = !this.mobileMenuOpen;
            },
            toggleFaq(index) {
                this.faqs[index].open = !this.faqs[index].open;
            },
            formatCurrency(amount) {
                return new Intl.NumberFormat('fr-FR', {
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(amount);
            },
            openContactModal(listing) {
                if (!this.isAuthenticated) {
                    alert('Vous devez être connecté pour être mis en relation');
                    return;
                }
                this.selectedListing = listing;
                this.showContactModal = true;
                this.contactRequestSuccess = false;
            },
            closeContactModal() {
                this.showContactModal = false;
                this.selectedListing = null;
                this.contactRequest = {
                    message: ''
                };
                this.contactRequestSuccess = false;
            },
            async submitContactRequest() {
                if (!this.contactRequest.message.trim() || !this.selectedListing) return;

                this.contactRequestSubmitting = true;
                this.contactRequestSuccess = false;



                try {
                    const response = await api.post(
                        '', // URL relative
                        {
                            message: this.contactRequest.message,
                            listing_id: this.selectedListing.listing_id
                        }, {
                            params: {
                                action: 'contactRequest'
                            },
                            headers: {
                                'Content-Type': 'application/json'
                            } // important
                        }
                    );

                    this.contactRequestSuccess = true;
                    this.contactRequest.message = ''; // Réinitialise le message après succès
                } catch (error) {
                    console.error('Erreur lors de l’envoi de la demande de contact :', error);
                    alert('Une erreur est survenue. Veuillez réessayer.');
                } finally {
                    this.contactRequestSubmitting = false;
                }
            },
            submitContactForm() {
                this.contactFormSubmitting = true;
                setTimeout(() => {
                    this.contactFormSubmitting = false;
                    this.contactFormSuccess = true;
                    this.contactForm = {
                        name: '',
                        email: '',
                        phone: '',
                        subject: '',
                        message: ''
                    };
                    setTimeout(() => {
                        this.contactFormSuccess = false;
                    }, 5000);
                }, 1500);
            }
        }
    }).mount('#app');
</script>

<style>
    :root {
        --primary: #10B981;
        --primary-dark: #059669;
        --accent: #F59E0B;
        --accent-dark: #D97706;
        --bg-light: #FFFFFF;
        --bg-light-secondary: #F9FAFB;
        --bg-dark: #0F172A;
        --bg-dark-secondary: #1E293B;
        --text-light: #111827;
        --text-light-secondary: #6B7280;
        --text-dark: #F9FAFB;
        --text-dark-secondary: #94A3B8;
    }

    body.dark-mode {
        background-color: var(--bg-dark);
        color: var(--text-dark);
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
        color: var(--text-dark) !important;
    }

    .dark-mode .text-gray-700 {
        color: var(--text-dark-secondary) !important;
    }

    .dark-mode .text-gray-600 {
        color: var(--text-dark-secondary) !important;
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

    .dark-mode .shadow-lg {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode .shadow-2xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    }

    /* Icons in colored backgrounds should be white */
    .bg-green-100 i,
    .bg-yellow-100 i,
    .bg-blue-100 i,
    .bg-green-500 i,
    .bg-yellow-500 i,
    .bg-blue-500 i,
    .bg-green-600 i,
    .bg-blue-600 i,
    .bg-gradient-to-br i,
    .primary-gradient i {
        color: white !important;
    }

    /* Sun icon should be yellow */
    .text-yellow-400 {
        color: #FBBF24 !important;
    }

    /* Primary colored icons */
    .text-primary i {
        color: var(--primary) !important;
    }

    .primary-gradient {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
    }

    .hero-gradient {
        background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
    }

    .dark-mode .hero-gradient {
        background: linear-gradient(135deg, #000000 0%, #0F172A 50%, #1E293B 100%);
    }

    .parallax {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        position: relative;
    }

    .parallax::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(15, 23, 42, 0.85);
    }

    .parallax-content {
        position: relative;
        z-index: 1;
    }

    .country-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        border-radius: 9999px;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-20px);
        }
    }

    @keyframes pulse-glow {

        0%,
        100% {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
        }

        50% {
            box-shadow: 0 0 40px rgba(16, 185, 129, 0.8);
        }
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal-content {
        animation: modalSlideIn 0.3s ease-out;
    }

    .fade-in-up {
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .slide-in-left {
        animation: slideInLeft 0.8s ease-out forwards;
    }

    .slide-in-right {
        animation: slideInRight 0.8s ease-out forwards;
    }

    .float-animation {
        animation: float 3s ease-in-out infinite;
    }

    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .mobile-mockup {
        max-width: 300px;
        border-radius: 40px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
        border-left: 4px solid var(--primary);
    }

    .dark-mode .stat-card {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(5, 150, 105, 0.08) 100%);
    }

    /* Mobile menu animation */
    .mobile-menu-enter {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Smooth scroll */
    html {
        scroll-behavior: smooth;
    }

    /* Enhanced scrollbar for dark mode */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .dark-mode ::-webkit-scrollbar-track {
        background: #1E293B;
    }

    ::-webkit-scrollbar-thumb {
        background: #10B981;
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #059669;
    }
</style>

<?php $content = ob_get_clean(); ?>

<?php require './src/view/layout.php'; ?>