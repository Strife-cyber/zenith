<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AboutUs from '@/pages/About.vue';
import Services from '@/pages/Services.vue';
import { ref } from 'vue';

// Smooth scroll functionality
const scrollToSection = (id: string) => {
    const section = document.getElementById(id.toLowerCase());
    if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
    }
    setActiveSection(id)
};

// Active section tracking
const activeSection = ref('home');
const setActiveSection = (section: string) => {
    activeSection.value = section;
};
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen min-w-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
        <!-- Header Section -->
        <header class="px-6 py-6 flex items-center justify-between sticky top-0 z-50 bg-slate-900/80 backdrop-blur-md border-b border-slate-700/50">
            <!-- Logo -->
            <h1 class="text-xl lg:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-amber-600 cursor-pointer hover:opacity-90 transition-opacity duration-300">
                ZENITH ESTATE
            </h1>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-4 lg:space-x-10">
                <a
                    v-for="link in ['Home', 'About', 'Services', 'Contact']"
                    :key="link"
                    @click.prevent="scrollToSection(link.toLowerCase())"
                    :class="[
                        'text-base cursor-pointer font-medium transition-colors duration-200 relative group',
                        activeSection === link.toLowerCase()
                            ? 'text-amber-400'
                            : 'text-slate-300 hover:text-amber-400'
                    ]"
                >
                    <span class="relative text-sm lg:text-md">
                        {{ link.toUpperCase() }}
                        <span
                            :class="[
                                'absolute left-0 -bottom-1 h-px transition-all duration-300',
                                activeSection === link.toLowerCase()
                                    ? 'w-full bg-amber-400'
                                    : 'w-0 bg-amber-400 group-hover:w-full'
                            ]"
                        ></span>
                    </span>
                </a>
            </nav>

            <!-- Login Button -->
            <a href="/login" class="px-6 py-2.5 bg-amber-500/90 text-slate-900 font-medium rounded-lg hover:bg-amber-400 transition-colors duration-300 border border-amber-400/20 hover:border-amber-400/30 shadow-xl shadow-amber-500/10 hover:shadow-amber-500/20">
                Login
            </a>
        </header>

        <!-- Mobile Navigation -->
        <nav class="md:hidden bg-slate-800/95 backdrop-blur-sm px-6 py-4 space-y-4">
            <a
                v-for="link in ['Home', 'About', 'Services', 'Contact']"
                :key="link"
                @click.prevent="scrollToSection(link.toLowerCase())"
                class="block text-lg font-semibold py-3 px-6 rounded-md transition-colors duration-300"
                :class="[
                    activeSection === link.toLowerCase()
                        ? 'text-amber-400 bg-slate-700/50'
                        : 'text-slate-300 hover:text-amber-400 hover:bg-slate-700/50'
                ]"
            >
                {{ link.toUpperCase() }}
            </a>
        </nav>

        <!-- Main Content -->
        <section id="home">
            <main class="relative min-h-[90vh] w-full flex items-center justify-center overflow-hidden
             bg-gradient-to-tr from-slate-900 via-slate-800/95 to-amber-900/30">

                <!-- Background SVG (Real Estate Icon) -->
                <div class="absolute inset-0 z-0 opacity-10 pointer-events-none">
                    <svg class="w-full h-full" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 20L180 80V180H20V80L100 20Z" stroke="#f97316" stroke-width="2"
                              class="animate-pulse"/>
                        <path d="M80 120H120V180H80V120Z" fill="#f97316" fill-opacity="0.2"/>
                    </svg>
                </div>

                <!-- Geometric Overlay -->
                <div class="absolute inset-0 z-0 opacity-15 mix-blend-soft-light">
                    <div class="w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))]
                    from-amber-400/20 via-transparent to-transparent"></div>
                </div>

                <!-- Content Container -->
                <div class="relative z-10 text-center px-6 py-12 max-w-4xl mx-auto animate-fadeIn">
                    <!-- Welcome Text -->
                    <div class="space-y-6 mb-16">
                        <h2 class="text-xl md:text-2xl text-gray-300 font-light tracking-wider
                             drop-shadow-md">
                            Experience Luxury Living With
                        </h2>
                        <h1 class="text-5xl md:text-7xl font-extrabold bg-clip-text text-transparent
                       bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 tracking-tight
                       [text-shadow:_0_4px_12px_rgba(251,191,36,0.3)]">
                            ZENITH ESTATE
                        </h1>
                        <div class="relative inline-block">
                            <p class="text-lg md:text-2xl text-gray-200 font-medium leading-relaxed
                              max-w-2xl mx-auto bg-slate-800/50 backdrop-blur-sm px-8 py-6 rounded-2xl
                              border border-amber-400/20 shadow-xl shadow-amber-900/20">
                                Where <span class="text-amber-400 font-semibold">innovation</span> meets
                                <span class="text-amber-400 font-semibold">excellence</span>. Our
                                cutting-edge technology and seasoned expertise create unparalleled
                                real estate experiences.
                            </p>
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-8 h-8
                                  bg-amber-400 rounded-full blur-xl opacity-40"></div>
                        </div>
                    </div>

                    <!-- Enhanced Join Us Button with Arrow -->
                    <a href="/register">
                        <button class="group relative px-8 py-4 bg-gradient-to-br from-amber-400 to-amber-600
                        text-slate-900 text-lg font-bold rounded-full transition-all duration-300
                        hover:shadow-2xl hover:shadow-amber-500/40 hover:scale-[1.02]
                        overflow-hidden">
                            <div class="flex items-center space-x-3">
                                <span>Get Started</span>
                                <div class="relative w-5 h-5">
                                    <svg class="absolute top-1/2 -translate-y-1/2 left-0 w-5 h-5
                                      transition-all duration-300 group-hover:translate-x-1"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                    <svg class="absolute top-1/2 -translate-y-1/2 left-0 w-5 h-5
                                      opacity-0 transition-all duration-300
                                      group-hover:opacity-100 group-hover:translate-x-1"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14M12 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="absolute inset-0 -z-10 bg-gradient-to-br from-amber-400/30
                              to-amber-600/30 opacity-0 group-hover:opacity-100 transition-opacity
                              duration-300 backdrop-blur-sm"></div>
                        </button>
                    </a>
                </div>

                <!-- Floating Elements -->
                <div class="absolute inset-0 pointer-events-none">
                    <div class="absolute top-1/4 left-1/4 w-48 h-48 bg-amber-400/10 rounded-full
                          blur-3xl animate-float"></div>
                    <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-amber-600/10 rounded-full
                          blur-3xl animate-float-delayed"></div>
                </div>
            </main>
        </section>

        <!-- Section Divider -->
        <div class="h-px w-full bg-gradient-to-r from-transparent via-amber-400/50 to-transparent"></div>

        <section id="about">
            <AboutUs/>
        </section>

        <!-- Section Divider -->
        <div class="h-px w-full bg-gradient-to-r from-transparent via-amber-400/50 to-transparent"></div>

        <section id="services">
            <Services />
        </section>

        <!-- Section Divider -->
        <div class="h-px w-full bg-gradient-to-r from-transparent via-amber-400/50 to-transparent"></div>

        <section id="contact">
            <!-- Footer Component -->
            <footer class="relative text-white w-full bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-12 border-t border-slate-700/50">
                <!-- Main Footer Container -->
                <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-10">
                    <!-- Brand Section -->
                    <div class="space-y-4 animate-fadeIn">
                        <h3 class="text-3xl font-bold bg-clip-text text-transparent
                      bg-gradient-to-r from-orange-400 to-orange-600">
                            ZENITH ESTATE
                        </h3>
                        <p class="text-sm leading-relaxed max-w-xs">
                            Innovating real estate with passion and precision. Your dream property awaits.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-orange-400 transition-all duration-300
                                 hover:scale-125">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-400 transition-all duration-300
                                 hover:scale-125">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-400 transition-all duration-300
                                 hover:scale-125">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.04c-5.5 0-10 4.5-10 10 0 4.41 3.59 8 8 8h1.5v-6h-2v-2h2v-1.5c0-2 1.33-3.5 3-3.5h2v2h-2c-.55 0-1 .45-1 1v1.5h2l-.5 2h-1.5v6H14c4.41 0 8-3.59 8-8 0-5.5-4.5-10-10-10z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="space-y-4 animate-fadeIn animation-delay-200">
                        <h4 class="text-lg font-semibold text-orange-400">Quick Links</h4>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="#" class="hover:text-orange-400 transition-all duration-300
                                     hover:pl-2 flex items-center">
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full mr-2"></span>
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-orange-400 transition-all duration-300
                                     hover:pl-2 flex items-center">
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full mr-2"></span>
                                    About Us
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-orange-400 transition-all duration-300
                                     hover:pl-2 flex items-center">
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full mr-2"></span>
                                    Our Services
                                </a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-orange-400 transition-all duration-300
                                     hover:pl-2 flex items-center">
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full mr-2"></span>
                                    Contact Us
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="space-y-4 animate-fadeIn animation-delay-400">
                        <h4 class="text-lg font-semibold text-orange-400">Contact Us</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l9-6 9 6v12a2 2 0 01-2 2H5a2 2 0 01-2-2V8z"/>
                                </svg>
                                123 Zenith Ave, Luxury City
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                +1 (555) 123-4567
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-orange-400" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 8l9-6 9 6v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm2 0v10h14V8L12 3 5 8z"/>
                                </svg>
                                info@zenithestate.com
                            </li>
                        </ul>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="space-y-4 animate-fadeIn animation-delay-600">
                        <h4 class="text-lg font-semibold text-orange-400">Stay Updated</h4>
                        <p class="text-sm">Subscribe for exclusive offers and updates.</p>
                        <form class="flex flex-col space-y-2">
                            <input type="email" placeholder="Your Email"
                                   class="px-4 py-2 rounded-md bg-gray-700 text-gray-200 border border-gray-600
                              focus:outline-none focus:ring-2 focus:ring-orange-400
                              transition-all duration-300">
                            <button type="submit"
                                    class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-md
                               hover:bg-orange-600 transition-all duration-300
                               hover:scale-105 hover:shadow-lg hover:shadow-orange-500/50">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="mt-12 pt-6 border-t border-gray-700 text-center text-sm">
                    <p>&copy; 2025 Zenith Estate. All rights reserved.</p>
                </div>

                <!-- Decorative Element -->
                <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400
                to-transparent opacity-50"></div>
            </footer>
        </section>
    </div>
</template>

<style scoped>
/* Add these new animations */
.section-divider {
    height: 1px;
    background: linear-gradient(90deg,
    rgba(251, 191, 36, 0) 0%,
    rgba(251, 191, 36, 0.4) 50%,
    rgba(251, 191, 36, 0) 100%);
    margin: 4rem 0;
    position: relative;
}

.section-divider::after {
    content: '';
    position: absolute;
    left: 50%;
    top: -2px;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: rgba(251, 191, 36, 0.8);
    border-radius: 2px;
}

/* Enhanced smooth scroll behavior */
html {
    scroll-behavior: smooth;
}

@media screen and (prefers-reduced-motion: reduce) {
    html {
        scroll-behavior: auto;
    }
}
</style>
