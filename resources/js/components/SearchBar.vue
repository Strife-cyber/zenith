<!-- SearchBar.vue -->
<script setup lang="ts">
import { ref } from 'vue';

defineProps<{
    placeholder?: string;
}>();

const emit = defineEmits<{
    (e: 'search', value: string): void;
}>();

const searchQuery = ref('');

const handleSearch = () => {
    emit('search', searchQuery.value);
};
</script>

<template>
    <div class="relative w-[250px] md:w-[400px] mx-auto animate-fadeIn">
        <input
            v-model="searchQuery"
            :placeholder="placeholder || 'Search...'"
            @keyup.enter="handleSearch"
            class="w-full dark:bg-gray-800/80 px-4 py-3 backdrop-blur-lg border border-gray-700/50
             rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500
             transition-all duration-300 shadow-lg hover:shadow-orange-500/20"
        />
        <button
            @click="handleSearch"
            class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 transition-all
            text-orange-500 hover:text-orange-700 duration-300"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </button>
    </div>
</template>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.6s ease-out forwards;
}
</style>
