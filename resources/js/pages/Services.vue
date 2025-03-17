<!-- resources/js/components/Services.vue -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Home, Car, MapPin, Building2, ChevronRight } from 'lucide-vue-next';

const services = ref([
    {
        title: 'Property Sales',
        description: 'Buy or sell your dream home with ease through our expert real estate services.',
        icon: Home,
    },
    {
        title: 'Vehicle Listings',
        description: 'Explore a curated selection of luxury vehicles tailored to your needs.',
        icon: Car,
    },
    {
        title: 'Land Acquisition',
        description: 'Secure prime land for residential, commercial, or agricultural use.',
        icon: MapPin,
    },
    {
        title: 'Apartment Rentals',
        description: 'Find the perfect rental with our comprehensive apartment listings.',
        icon: Building2,
    },
]);

const serviceRefs = ref<HTMLElement[]>([]);

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('opacity-100', 'translate-y-0', 'blur-0');
                    }, index * 150);
                }
            });
        },
        { threshold: 0.2 }
    );

    serviceRefs.value.forEach((ref) => observer.observe(ref));
});
</script>

<template>
    <section
        class="min-h-screen py-16 flex items-center justify-center relative overflow-hidden"
    >
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="w-80 h-80 bg-amber-500/10 rounded-full filter blur-3xl absolute top-10 left-10
               animate-float-slow"
            ></div>
            <div
                class="w-96 h-96 bg-orange-500/10 rounded-full filter blur-3xl absolute bottom-10 right-10
               animate-float-slow delay-1500"
            ></div>
        </div>

        <div class="container mx-auto px-6 z-10">
            <!-- Header -->
            <div class="text-center mb-16">
                <h2
                    class="text-5xl md:text-6xl font-extrabold text-transparent bg-clip-text
                 bg-gradient-to-r from-amber-300 via-orange-300 to-red-300 animate-slide-up"
                >
                    Our Services
                </h2>
                <p
                    class="mt-4 text-lg md:text-xl text-gray-300 max-w-2xl mx-auto animate-fade-in"
                >
                    At <span class="font-bold text-amber-300">Zenith Estate</span>, we offer a
                    comprehensive range of services designed to meet your unique needs with
                    elegance and efficiency.
                </p>
            </div>

            <!-- Service Boxes -->
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"
            >
                <div
                    v-for="(service, index) in services"
                    :key="service.title"
                    :ref="(el) => serviceRefs[index] = el as HTMLElement"
                    class="service-box bg-gray-800/80 backdrop-blur-lg rounded-xl p-6
                 border border-amber-500/20 shadow-lg hover:shadow-amber-500/30
                 transform hover:scale-[1.03] transition-all duration-500
                 opacity-0 translate-y-10 blur-sm animate-service-box
                 hover:border-amber-400/30 group"
                >
                    <!-- Icon -->
                    <component
                        :is="service.icon"
                        class="w-12 h-12 text-amber-400 mb-4 transition-all
                        group-hover:scale-110 group-hover:text-amber-300"
                    />

                    <!-- Title -->
                    <h3 class="text-xl font-semibold text-white mb-2">
                        {{ service.title }}
                    </h3>

                    <!-- Description -->
                    <p class="text-gray-300 text-sm leading-relaxed">
                        {{ service.description }}
                    </p>

                    <!-- Learn More Link -->
                    <a
                        href="#"
                        class="mt-4 inline-flex items-center text-amber-400 hover:text-amber-300
                   text-sm font-medium transition-colors duration-300 group/button"
                    >
                        Learn More
                        <ChevronRight
                            class="w-4 h-4 ml-1 transition-transform
                            group-hover/button:translate-x-1"
                        />
                    </a>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Animations */
.animate-slide-up {
    animation: slideUp 1s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
}

.animate-fade-in {
    animation: fadeIn 1.2s ease-out forwards;
}

.animate-service-box {
    animation: fadeInUp 0.8s cubic-bezier(0.22, 0.61, 0.36, 1) forwards;
}

.animate-float-slow {
    animation: floatSlow 7s ease-in-out infinite;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        filter: blur(4px);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }
}

@keyframes floatSlow {
    0%,
    100% {
        transform: translateY(0) rotate(0deg);
    }
    20% {
        transform: translateY(-15px) rotate(2deg);
    }
    60% {
        transform: translateY(10px) rotate(-1deg);
    }
}

.delay-1500 {
    animation-delay: 1.5s;
}
</style>
