<script setup lang="ts">
import { computed } from 'vue';
import { Home, Car, Map } from 'lucide-vue-next';
import Carousel from '@/components/ui/carousel/Carousel.vue';

// Props for the listing data
const props = defineProps<{
    listing: {
        id: number;
        title: string;
        description: string;
        price: number;
        type: string;
        images: { url: string }[];
    };
}>();

// Ribbon color based on type
const ribbonColor = computed(() => {
    switch (props.listing.type) {
        case 'apartment': return 'bg-orange-500';
        case 'car': return 'bg-blue-500'; // Blue for cars
        case 'land': return 'bg-green-500'; // Green for land
        default: return 'bg-gray-500';
    }
});
</script>

<template>
    <div class="relative backdrop-blur-lg rounded-xl p-6 shadow-lg shadow-orange-500/20
              border border-gray-700/50 transform hover:scale-105 transition-all duration-500
              animate-slideUp max-w-sm mx-auto">
        <!-- Ribbon -->
        <div :class="['absolute top-0 right-0 px-4 py-1 font-semibold text-sm rounded-bl-lg rounded-tr-lg transform rotate-45 translate-x-4 -translate-y-4 z-10 animate-fadeIn', ribbonColor]">
            {{ listing.type.charAt(0).toUpperCase() + listing.type.slice(1) }}
        </div>

        <!-- Carousel -->
        <Carousel :images="listing.images"/>

        <!-- Listing Details -->
        <div class="space-y-3">
            <div class="flex items-center space-x-3">
                <Home v-if="listing.type === 'apartment'" class="h-6 w-6 text-orange-400 animate-bounceOnce" />
                <Car v-if="listing.type === 'car'" class="h-6 w-6 text-blue-400 animate-bounceOnce" />
                <Map v-if="listing.type === 'land'" class="h-6 w-6 text-green-400 animate-bounceOnce" />
                <h2 class="text-xl font-semibold truncate">{{ listing.title }}</h2>
            </div>
            <p class="text-sm line-clamp-2">{{ listing.description }}</p>
            <p class="text-orange-400 font-bold text-lg">{{ listing.price.toLocaleString() }}</p>
        </div>

        <!-- Decorative Glow -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-xl">
            <div class="w-32 h-32 bg-orange-500/20 rounded-full filter blur-3xl absolute -top-16 -left-16
                  animate-float"></div>
            <div class="w-32 h-32 bg-orange-500/20 rounded-full filter blur-3xl absolute -bottom-16 -right-16
                  animate-float delay-1000"></div>
        </div>
    </div>
</template>

<style>
/* Custom Animations */
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes bounceOnce {
    0% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
    100% { transform: translateY(0); }
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

.animate-slideUp {
    animation: slideUp 0.8s ease-out forwards;
}

.animate-fadeIn {
    animation: fadeIn 1s ease-out forwards;
}

.animate-bounceOnce {
    animation: bounceOnce 1s ease-out;
}

.animate-float {
    animation: float 5s ease-in-out infinite;
}

.delay-1000 {
    animation-delay: 1s;
}
</style>
