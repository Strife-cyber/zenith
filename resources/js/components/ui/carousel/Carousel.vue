<script setup lang="ts">
import { ref } from 'vue';

// Define props with TypeScript interface
interface Image {
    image: string;
}

const props = defineProps<{
    images: Image[];
}>();

const currentImageIndex = ref(0);

// Navigate to the next image
const nextImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % props.images.length;
};

// Navigate to the previous image
const prevImage = () => {
    currentImageIndex.value =
        (currentImageIndex.value - 1 + props.images.length) % props.images.length;
};
console.log(props.images[currentImageIndex]?.image)
</script>

<template>
    <div class="relative mb-4 overflow-hidden rounded-lg">
        <!-- Main Image -->
        <img
            :src="props.images[currentImageIndex].image || 'https://th.bing.com/th/id/OIP.DEb9XSbXDEEPIprv2m8RdQHaEF?rs=1&pid=ImgDetMain'"
            :alt="`Image ${currentImageIndex + 1}`"
            class="w-full h-64 object-cover transition-all duration-500 ease-in-out transform hover:scale-110"
        />

        <!-- Carousel Controls (only shown if more than one image) -->
        <template v-if="props.images.length > 1">
            <!-- Previous Button -->
            <button
                @click="prevImage"
                class="absolute left-2 top-1/2 -translate-y-1/2 bg-gray-900/50 p-2 rounded-full text-white hover:bg-blue-500 transition-all duration-300"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <!-- Next Button -->
            <button
                @click="nextImage"
                class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-900/50 p-2 rounded-full text-white hover:bg-blue-500 transition-all duration-300"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Navigation Dots -->
            <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2">
        <span
            v-for="(image, index) in props.images"
            :key="index"
            @click="currentImageIndex = index"
            :class="[
            'w-2 h-2 rounded-full cursor-pointer transition-all duration-300',
            currentImageIndex === index ? 'bg-blue-400 scale-125' : 'bg-gray-400',
          ]"
        />
            </div>
        </template>
    </div>
</template>

<style scoped>
/* Optional: Add subtle shadow to the carousel */
.relative {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
