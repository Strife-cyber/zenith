<script setup lang="ts">
import { computed } from 'vue';
import { Car } from 'lucide-vue-next';
import Carousel from '@/components/ui/carousel/Carousel.vue';

defineProps<{
    listing: {
        id: number;
        title: string;
        price: number;
        type: string;
        images: { url: string }[];
        listable: {
            make: string;
            model: string;
            year: number;
            transmission: string;
            fuel: string;
            condition: string;
        };
    };
}>();

// Ribbon color (blue for cars)
const ribbonColor = computed(() => 'bg-blue-500');
</script>

<template>
    <div class="relative backdrop-blur-lg rounded-xl p-6 shadow-lg shadow-blue-500/20
              border border-gray-700/50 transform hover:scale-105 transition-all duration-500
              animate-slideUp max-w-sm mx-auto">
        <!-- Ribbon -->
        <div :class="['absolute top-0 right-0 px-4 py-1 text-white font-semibold text-sm rounded-bl-lg rounded-tr-lg transform rotate-45 translate-x-4 -translate-y-4 z-10 animate-fadeIn', ribbonColor]">
            Car
        </div>

        <!-- Carousel -->
        <Carousel :images="listing.images"/>

        <!-- Car Details -->
        <div class="space-y-3">
            <div class="flex items-center space-x-3">
                <Car class="h-6 w-6 text-blue-400 animate-bounceOnce" />
                <h2 class="text-xl font-semibold text-gray-200 truncate">{{ listing.title }}</h2>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm text-gray-400">
                <div><span class="font-semibold text-blue-400">Make:</span> {{ listing.listable.make }}</div>
                <div><span class="font-semibold text-blue-400">Model:</span> {{ listing.listable.model }}</div>
                <div><span class="font-semibold text-blue-400">Year:</span> {{ listing.listable.year }}</div>
                <div><span class="font-semibold text-blue-400">Transmission:</span> {{ listing.listable.transmission }}</div>
                <div><span class="font-semibold text-blue-400">Fuel:</span> {{ listing.listable.fuel }}</div>
                <div><span class="font-semibold text-blue-400">Condition:</span> {{ listing.listable.condition }}</div>
            </div>
            <p class="text-blue-400 font-bold text-lg">{{ listing.price.toLocaleString() }}</p>
        </div>

        <!-- Decorative Glow -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-xl">
            <div class="w-32 h-32 bg-blue-500/20 rounded-full filter blur-3xl absolute -top-16 -left-16
                  animate-float"></div>
            <div class="w-32 h-32 bg-blue-500/20 rounded-full filter blur-3xl absolute -bottom-16 -right-16
                  animate-float delay-1000"></div>
        </div>
    </div>
</template>

<style>
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
