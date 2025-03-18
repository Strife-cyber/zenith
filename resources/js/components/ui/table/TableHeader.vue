<script setup lang="ts">
import { computed, ref } from 'vue';
import type { TableRow } from './types';

const props = defineProps<{
    data: TableRow[];
}>();

const sortKey = ref('');
const sortDirection = ref<'asc' | 'desc'>('asc');
const columnFilters = ref<Record<string, string>>({});

const headers = computed(() => {
    if (!props.data || props.data.length === 0) return [];
    return Object.keys(props.data[0]);
});

function sortTable(header: string) {
    if (sortKey.value === header) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = header;
        sortDirection.value = 'asc';
    }
}
</script>

<template>
    <thead class="bg-gradient-to-r from-gray-800 to-gray-700 dark:from-gray-900 dark:to-gray-800">
    <tr>
        <th
            v-for="header in headers"
            :key="header"
            @click="sortTable(header)"
            class="w-[200px] px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider cursor-pointer hover:bg-gray-700 transition-colors duration-150"
        >
            <div class="flex items-center justify-between">
                {{ header }}
                <span v-if="sortKey === header" class="ml-2 text-indigo-300">
            {{ sortDirection === 'asc' ? '▲' : '▼' }}
          </span>
            </div>
        </th>
        <th class="w-[200px] px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
            Actions
        </th>
    </tr>
    <tr class="bg-gray-50 dark:bg-gray-800">
        <th v-for="header in headers" :key="header" class="w-[200px] px-4 py-3">
            <input
                v-model="columnFilters[header]"
                type="text"
                :placeholder="`Filter ${header}`"
                class="w-full px-2 py-1.5 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm transition-all duration-200 truncate"
            />
        </th>
        <th class="w-[200px] px-4 py-3"></th>
    </tr>
    </thead>
</template>
