<script setup lang="ts">
import { computed } from 'vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import type { TableRow } from './types';

const props = defineProps<{
    data: TableRow[];
    currentPage: number;
    pageSize: number;
    searchQuery: string;
}>();

// Define emits for v-model binding
const emit = defineEmits<{
    (e: 'update:currentPage', value: number): void;
    (e: 'update:pageSize', value: number): void;
}>();

const totalPages = computed(() =>
    Math.ceil(props.data.length / props.pageSize)
);

function prevPage() {
    if (props.currentPage > 1) {
        emit('update:currentPage', props.currentPage - 1);
    }
}

function nextPage() {
    if (props.currentPage < totalPages.value) {
        emit('update:currentPage', props.currentPage + 1);
    }
}
</script>

<template>
    <div class="p-4 border-t border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600 dark:text-gray-400">
            Showing
            <span class="font-medium">{{ (currentPage - 1) * pageSize + 1 }}</span>
            to
            <span class="font-medium">{{ Math.min(currentPage * pageSize, data.length) }}</span>
            of
            <span class="font-medium">{{ data.length }}</span>
            results
        </div>
        <div class="flex items-center gap-4">
            <select
                :value="pageSize"
                @change="emit('update:pageSize', Number($event.target.value))"
                class="px-3 py-1.5 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition-all duration-200"
            >
                <option value="10">10 / page</option>
                <option value="25">25 / page</option>
                <option value="50">50 / page</option>
            </select>
            <div class="flex items-center gap-1">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="px-3 py-1.5 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-750 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                >
                    <ChevronLeft class="size-4" />
                </button>
                <span class="px-4 py-1.5 bg-indigo-50 dark:bg-gray-850 text-indigo-600 dark:text-indigo-400 rounded-md text-sm font-medium">
          {{ currentPage }} / {{ totalPages }}
        </span>
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-1.5 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-750 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                >
                    <ChevronRight class="size-4" />
                </button>
            </div>
        </div>
    </div>
</template>
