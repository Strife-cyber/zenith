<script setup lang="ts">
import { computed, ref } from 'vue';
import type { TableRow } from './types';
import { Edit, LucideTrash } from 'lucide-vue-next';
import Modal from '@/components/ui/table/Modal.vue';

const props = defineProps<{
    data: TableRow[];
    currentPage: number;
    pageSize: number;
    searchQuery: string;
    sortKey: string; // Added
    sortDirection: 'asc' | 'desc'; // Added
    columnFilters: Record<string, string>; // Added
    updatable?: boolean;
    handleUpdate?: (id: string, data: any) => void;
}>();

const isAddMode = ref(false);
const showModal = ref(false);
const selectedRow = ref<TableRow | null>(null);

const emit = defineEmits<{
    (e: 'update-row', row: TableRow): void;
    (e: 'delete-row', id: string): void;
    (e: 'add-row'): void;
}>();

// Filter data based on search query and column filters
const filteredData = computed(() => {
    return props.data.filter(row => {
        const matchesSearch = Object.values(row).some(value =>
            String(value).toLowerCase().includes(props.searchQuery.toLowerCase())
        );
        const matchesFilters = Object.entries(props.columnFilters).every(([key, filter]) => {
            if (!filter) return true;
            return String(row[key]).toLowerCase().includes(filter.toLowerCase());
        });
        return matchesSearch && matchesFilters;
    });
});

// Sort filtered data
const sortedData = computed(() => {
    if (!props.sortKey) return filteredData.value;
    return [...filteredData.value].sort((a, b) => {
        const aValue = a[props.sortKey];
        const bValue = b[props.sortKey];
        if (aValue === bValue) return 0;

        // Handle different data types
        if (typeof aValue === 'number' && typeof bValue === 'number') {
            return props.sortDirection === 'asc' ? aValue - bValue : bValue - aValue;
        }
        // Convert to string for comparison
        const aStr = String(aValue).toLowerCase();
        const bStr = String(bValue).toLowerCase();
        return props.sortDirection === 'asc'
            ? aStr.localeCompare(bStr)
            : bStr.localeCompare(aStr);
    });
});

// Slice sorted data for pagination
const slicedData = computed(() => {
    const start = (props.currentPage - 1) * props.pageSize;
    const end = start + props.pageSize;
    return sortedData.value.slice(start, end);
});

const headers = computed(() => {
    if (!props.data || props.data.length === 0) return [];
    return Object.keys(props.data[0]);
});

// Handler functions
function handleUpdateClick(row: TableRow) {
    emit('update-row', row);
    isAddMode.value = false;
    selectedRow.value = row;
    showModal.value = true;
}

function handleDeleteClick(id: string) {
    emit('delete-row', id);
}

function handleCancel() {
    showModal.value = false;
    selectedRow.value = null;
}

function handleSubmit(formData: Record<string, any>) {
    if (isAddMode.value && props.handleAdd) {
        props.handleAdd(formData);
    } else if (!isAddMode.value && props.handleUpdate && formData.id) {
        props.handleUpdate(formData.id, formData);
    }
    showModal.value = false;
    selectedRow.value = null;
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
                <slot :row="row" />
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
    <Modal
        v-if="showModal"
        :data="selectedRow"
        :headers="headers"
        :is-add-mode="isAddMode"
        :handle-cancel="handleCancel"
        :on-submit="handleSubmit"
    />
</template>
