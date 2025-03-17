<script setup lang="ts">
import { ref, computed } from 'vue';
import { MapPin } from 'lucide-vue-next';

const props = defineProps<{
    listing: {
        id: number;
        title: string;
        price: number;
        type: string;
        images: { url: string }[];
        listable: {
            size?: number;
            zoning?: 'residential' | 'commercial' | 'agricultural';
            document?: boolean;
        } | null; // listable can be null
    };
}>();

// Carousel state
const currentImageIndex = ref(0);

const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.listing.images.length;
};

const prevImage = () => {
    currentImageIndex.value = (currentImageIndex.value - 1 + props.listing.images.length) % props.listing.images.length;
};

// Ribbon color (green for land)
const ribbonColor = computed(() => 'bg-green-500');
</script>

<template>
    <div class="relative backdrop-blur-lg rounded-xl p-6 shadow-lg shadow-green-500/20
              border border-gray-700/50 transform hover:scale-105 transition-all duration-500
              animate-slideUp max-w-sm mx-auto">
        <!-- Ribbon -->
        <div :class="['absolute top-0 right-0 px-4 py-1 text-white font-semibold text-sm rounded-bl-lg rounded-tr-lg transform rotate-45 translate-x-4 -translate-y-4 z-10 animate-fadeIn', ribbonColor]">
            Land
        </div>

        <!-- Carousel -->
        <div class="relative mb-4 overflow-hidden rounded-lg">
            <!--:src="listing.images[currentImageIndex]?.image || 'https://th.bing.com/th/id/OIP.DEb9XSbXDEEPIprv2m8RdQHaEF?rs=1&pid=ImgDetMain'"-->
            <img
                :src="'https://th.bing.com/th/id/OIP.DEb9XSbXDEEPIprv2m8RdQHaEF?rs=1&pid=ImgDetMain'"
                :alt="`${listing.title} image ${currentImageIndex + 1}`"
                class="w-full h-64 object-cover transition-all duration-500 ease-in-out transform scale-100 hover:scale-110"
            />
            <!-- Carousel Controls -->
            <button
                v-if="listing.images.length > 1"
                @click="prevImage"
                class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-gray-900/50 p-2 rounded-full
               text-white hover:bg-green-500 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button
                v-if="listing.images.length > 1"
                @click="nextImage"
                class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-gray-900/50 p-2 rounded-full
               text-white hover:bg-green-500 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
            <!-- Dots -->
            <div v-if="listing.images.length > 1" class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2">
        <span
            v-for="(image, index) in listing.images"
            :key="index"
            @click="currentImageIndex = index"
            :class="['w-2 h-2 rounded-full cursor-pointer transition-all duration-300',
                   currentImageIndex === index ? 'bg-green-400 scale-125' : 'bg-gray-400']">
        </span>
            </div>
        </div>

        <!-- Land Details -->
        <div class="space-y-3">
            <div class="flex items-center space-x-3">
                <MapPin class="h-6 w-6 text-green-400 animate-bounceOnce" />
                <h2 class="text-xl font-semibold text-gray-200 truncate">{{ listing.title }}</h2>
            </div>
            <div class="grid grid-cols-2 gap-2 text-sm text-gray-400">
                <div><span class="font-semibold text-green-400">Size:</span> {{ listing.listable?.size ? listing.listable.size + ' acres' : 'N/A' }}</div>
                <div><span class="font-semibold text-green-400">Zoning:</span> {{ listing.listable?.zoning || 'N/A' }}</div>
                <div><span class="font-semibold text-green-400">Document:</span> {{ listing.listable?.document !== undefined ? (listing.listable.document ? 'Yes' : 'No') : 'N/A' }}</div>
            </div>
            <p class="text-green-400 font-bold text-lg">{{ listing.price.toLocaleString() }}</p>
        </div>

        <!-- Decorative Glow -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-xl">
            <div class="w-32 h-32 bg-green-500/20 rounded-full filter blur-3xl absolute -top-16 -left-16
                  animate-float"></div>
            <div class="w-32 h-32 bg-green-500/20 rounded-full filter blur-3xl absolute -bottom-16 -right-16
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
