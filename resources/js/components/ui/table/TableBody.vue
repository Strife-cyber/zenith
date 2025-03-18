<script setup lang="ts">
import { computed, ref } from 'vue';
import type { TableRow } from './types';
import { PlusCircleIcon, Edit, LucideTrash } from 'lucide-vue-next';
import Modal from '@/components/ui/table/Modal.vue';

const props = defineProps<{
    data: TableRow[];
    currentPage: number;
    pageSize: number;
    searchQuery: string;
    updatable?: boolean;
    addable?: boolean;
    handleUpdate?: (id: string, data: any) => void;
    handleAdd?: (data: any) => void;
}>();

const mode = ref(false);
const show = ref(false);

// Define emits with proper typing
const emit = defineEmits<{
    (e: 'update-row', row: TableRow): void;
    (e: 'delete-row', id: string): void;
    (e: 'add-row'): void;
}>();

const filteredData = computed(() => {
    return props.data.filter(row =>
        Object.values(row).some(value =>
            String(value).toLowerCase().includes(props.searchQuery.toLowerCase())
        )
    );
});

const slicedData = computed(() => {
    const start = (props.currentPage - 1) * props.pageSize;
    const end = start + props.pageSize;
    return filteredData.value.slice(start, end);
});

const headers = computed(() => {
    if (!props.data || props.data.length === 0) return [];
    return Object.keys(props.data[0]);
});

// Handler functions
function handleUpdateClick(row: TableRow) {
    emit('update-row', row);
    mode.value = false
    show.value = true
}

function handleAddClick() {
    emit('add-row');
    mode.value = true
    show.value = true
}

function handleDeleteClick(id: string) {
    emit('delete-row', id);
}
</script>

<template>
    <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
    <tr
        v-for="(row, index) in slicedData"
        :key="index"
        class="hover:bg-gray-50 dark:hover:bg-gray-700/80 transition-all duration-150"
    >
        <td
            v-for="header in headers"
            :key="header"
            class="w-[200px] px-4 py-4 text-sm text-gray-700 dark:text-gray-300 truncate"
        >
        <span class="animate-fade-in block truncate">
          {{ row[header] ?? 'N/A' }}
        </span>
        </td>
        <td class="w-[200px] px-4 py-4 text-sm">
            <div class="flex space-x-8">
                <slot />
                <button
                    v-if="props.addable"
                    @click="handleAddClick"
                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center transition-all duration-200 transform hover:scale-105"
                    title="Add new row"
                >
                    <PlusCircleIcon class="size-4" />
                </button>
                <button
                    v-if="props.updatable"
                    @click="handleUpdateClick(row)"
                    class="text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 flex items-center transition-all duration-200 transform hover:scale-105"
                    title="Edit row"
                >
                    <Edit class="size-4" />
                </button>
                <button
                    @click="handleDeleteClick(row.id)"
                    class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 flex items-center transition-all duration-200 transform hover:scale-105"
                    title="Delete row"
                >
                    <LucideTrash class="size-4" />
                </button>
            </div>
        </td>
    </tr>
    </tbody>
    <Modal v-if="show" :headers="headers" :is-add-mode="mode" :handle-cancel="() => show = false " :on-submit="() => { console.log('submitted') }"/>
</template>
