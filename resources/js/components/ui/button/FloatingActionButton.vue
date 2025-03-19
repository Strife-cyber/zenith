<template>
    <button
        class="fab fixed bottom-8 right-8 w-16 h-16 rounded-full bg-gradient-to-br from-orange-500 to-amber-600 text-white border-none shadow-lg cursor-pointer flex items-center justify-center z-[1000] hover:scale-110 hover:shadow-2xl active:scale-95 active:shadow-md transition-all duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] animate-float"
    >
        <span class="fab-icon w-8 h-8 flex items-center justify-center transform transition-transform duration-300 hover:rotate-180">
          <Plus class="w-6 h-6" />
        </span>
    </button>
</template>

<script setup>
import { Plus } from 'lucide-vue-next';
</script>

<style scoped>
/* Custom floating animation */
@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-float {
    animation: float 3s ease-in-out infinite;
}

/* Glow effect on hover */
.fab:hover {
    box-shadow: 0 0 20px rgba(255, 165, 0, 0.6), 0 0 40px rgba(255, 165, 0, 0.4);
}

/* Smooth icon rotation */
.fab-icon {
    transition: transform 0.3s ease-in-out;
}
</style>
