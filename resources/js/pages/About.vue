<!-- resources/js/components/AboutUs.vue -->
<script setup lang="ts">
import { ref, onMounted } from 'vue';

const content = ref(null);
const image = ref(null);

const bounceButton = (event: MouseEvent) => {
    const button = event.target as HTMLElement;
    button.classList.add('animate-bounce');
    setTimeout(() => button.classList.remove('animate-bounce'), 500);
};

onMounted(() => {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('opacity-100', 'translate-x-0');
                }
            });
        },
        { threshold: 0.1 }
    );

    if (content.value) observer.observe(content.value);
    if (image.value) observer.observe(image.value);
});
</script>

<template>
    <section
        class="min-h-screen flex items-center justify-center py-16 overflow-hidden relative"
    >
        <!-- Decorative Background Elements -->
        <div
            class="absolute inset-0 pointer-events-none overflow-hidden"
        >
            <div
                class="w-96 h-96 bg-amber-500/10 rounded-full filter blur-3xl absolute top-0 left-0
               animate-float-slow"
            ></div>
            <div
                class="w-72 h-72 bg-orange-500/10 rounded-full filter blur-3xl absolute bottom-0 right-0
               animate-float-slow delay-2000"
            ></div>
        </div>

        <div class="container mx-auto px-6 z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content Section -->
                <div
                    ref="content"
                    class="space-y-10 animate-fade-in-left opacity-0 translate-x-[-50px]"
                >
                    <h1
                        class="text-5xl md:text-6xl font-extrabold text-transparent bg-clip-text
                   bg-gradient-to-r from-amber-300 via-orange-300 to-red-300 tracking-tight
                   animate-slide-up"
                    >
                        About Zenith Estate
                    </h1>

                    <div class="space-y-6">
                        <h3
                            class="text-2xl md:text-3xl font-semibold text-gray-200 leading-tight"
                        >
                            A Warm Welcome from CEO Milo N. Buro & Our Expert Team
                        </h3>

                        <p
                            class="text-gray-300 leading-relaxed text-lg md:text-xl max-w-prose"
                        >
                            At <span class="font-bold text-amber-300">Zenith Estate</span>, we redefine luxury real estate in Cameroon.
                            With over a year of market expertise, we’ve crafted a seamless, one-stop platform to bring you the finest,
                            most up-to-date property listings. Say goodbye to tedious processes and hello to a curated experience
                            showcasing the best lands, apartments, and vehicles across the country.
                        </p>

                        <div class="pt-4">
                            <a
                                href="#"
                                @mouseover="bounceButton"
                                class="inline-block bg-gradient-to-r from-amber-500 to-orange-500 text-white
                       px-8 py-3 rounded-full hover:from-amber-600 hover:to-orange-600
                       transform hover:scale-105 transition-all duration-300 shadow-lg
                       hover:shadow-amber-500/50 font-semibold text-lg"
                            >
                                Discover More
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Image Section -->
                <div
                    ref="image"
                    class="relative animate-fade-in-right opacity-0 translate-x-[50px]"
                >
                    <div
                        class="relative overflow-hidden rounded-3xl shadow-2xl border border-amber-500/20
                   transform hover:scale-[1.02] transition-transform duration-500"
                    >
                        <!-- Verify image path: should be in public/images/estate-hero.jpg -->
                        <img
                            src="/images/estate-hero.jpg"
                            alt="Zenith Estate Showcase"
                            class="w-full h-[500px] object-cover transform hover:scale-110
                            transition-transform duration-700"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-transparent to-transparent
                     flex items-end p-6"
                        >
              <span
                  class="text-white text-lg font-semibold bg-amber-500/20 backdrop-blur-md
                       px-4 py-2 rounded-full shadow-md"
              >
                Luxury Living Awaits
              </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
/* Enhanced Animations */
.animate-fade-in-left {
    animation: fadeInLeft 1.2s ease-out forwards;
}

.animate-fade-in-right {
    animation: fadeInRight 1.2s ease-out forwards;
}

.animate-slide-up {
    animation: slideUp 1s ease-out forwards;
}

.animate-float-slow {
    animation: floatSlow 8s ease-in-out infinite;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
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

@keyframes floatSlow {
    0%,
    100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

.delay-2000 {
    animation-delay: 2s;
}
</style>
