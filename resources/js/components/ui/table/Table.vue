<script setup lang="ts">
import { computed, ref } from 'vue';
import { PlusCircleIcon, Edit, LucideTrash, ChevronLeft, ChevronRight } from 'lucide-vue-next';

interface TableRow {
    [key: string]: any;
}

const props = defineProps<{
    data: TableRow[];
    handleUpdate?: (id: string, data: any) => void;
    handleDelete?: (id: string) => void;
    updatable?: boolean;
    addable?: boolean;
}>();

// Reactive state
const currentPage = ref(1);
const pageSize = ref(10);
const searchQuery = ref('');
const sortKey = ref('');
const sortDirection = ref<'asc' | 'desc'>('asc');
const columnFilters = ref<Record<string, string>>({});

// Modal state
const showModal = ref(false);
const selectedRow = ref<TableRow | null>(null);
const formData = ref<Record<string, any>>({});

// Computed properties
const headers = computed(() => {
    if (!props.data || props.data.length === 0) return [];
    return Object.keys(props.data[0]);
});

const filteredData = computed(() => {
    return props.data.filter((row) => {
        const matchesSearchQuery = Object.values(row).some((value) =>
            String(value).toLowerCase().includes(searchQuery.value.toLowerCase())
        );
        const matchesColumnFilters = Object.entries(columnFilters.value).every(
            ([key, filterValue]) => {
                if (!filterValue) return true;
                return String(row[key]).toLowerCase().includes(filterValue.toLowerCase());
            }
        );
        return matchesSearchQuery && matchesColumnFilters;
    });
});

const sortedData = computed(() => {
    if (!sortKey.value) return filteredData.value;
    return filteredData.value.slice().sort((a, b) => {
        const aValue = a[sortKey.value];
        const bValue = b[sortKey.value];
        if (aValue < bValue) return sortDirection.value === 'asc' ? -1 : 1;
        if (aValue > bValue) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });
});

const slicedData = computed(() => {
    const start = (currentPage.value - 1) * pageSize.value;
    const end = start + pageSize.value;
    return sortedData.value.slice(start, end);
});

const totalPages = computed(() => Math.ceil(filteredData.value.length / pageSize.value));

// Functions
function prevPage() {
    if (currentPage.value > 1) currentPage.value--;
}

function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
}

function sortTable(header: string) {
    if (sortKey.value === header) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortKey.value = header;
        sortDirection.value = 'asc';
    }
}

function updateColumnFilter(header: string, value: string) {
    columnFilters.value[header] = value;
    currentPage.value = 1;
}

function openUpdateModal(row: TableRow) {
    selectedRow.value = row;
    formData.value = { ...row }; // Create a copy of the row data
    showModal.value = true;
}

function openAddModal() {
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    selectedRow.value = null;
    formData.value = {};
}

function submitUpdate() {
    if (selectedRow.value && selectedRow.value.id) {
        props.handleUpdate(selectedRow.value.id, formData.value);
        closeModal();
    }
}
</script>

<template>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden">
            <!-- Search Bar -->
            <div class="p-4 border-b border-gray-200 dark:border-gray-800">
                <div class="relative">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                    />
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <thead class="bg-gradient-to-r from-gray-800 to-gray-700 dark:from-gray-900 dark:to-gray-800">
                    <tr>
                        <th
                            v-for="header in headers"
                            :key="header"
                            class="w-[200px] px-4 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider cursor-pointer hover:bg-gray-700 transition-colors duration-150"
                            @click="sortTable(header)"
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
                    <transition-group name="list" tag="tbody" class="divide-y divide-gray-200 dark:divide-gray-800">
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
                                <div class="flex space-x-4">
                                    <button
                                        v-if="props.addable"
                                        @click="openAddModal()"
                                        class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center transition-all duration-200 transform hover:scale-105"
                                    >
                                        <PlusCircleIcon class="size-4"/>
                                    </button>
                                    <button
                                        v-if="props.updatable"
                                        @click="openUpdateModal(row)"
                                        class="text-orange-600 dark:text-orange-400 hover:text-orange-800 dark:hover:text-orange-300 flex items-center transition-all duration-200 transform hover:scale-105"
                                    >
                                        <Edit class="size-4"/>
                                    </button>
                                    <button
                                        @click="props.handleDelete(row.id)"
                                        class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 flex items-center transition-all duration-200 transform hover:scale-105"
                                    >
                                        <LucideTrash class="size-4"/>
                                    </button>
                                    <slot/>
                                </div>
                            </td>
                        </tr>
                    </transition-group>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Showing
                    <span class="font-medium">{{ (currentPage - 1) * pageSize + 1 }}</span>
                    to
                    <span class="font-medium">{{ Math.min(currentPage * pageSize, filteredData.length) }}</span>
                    of
                    <span class="font-medium">{{ filteredData.length }}</span>
                    results
                </div>
                <div class="flex items-center gap-4">
                    <select
                        v-model="pageSize"
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
                            <ChevronLeft class="size-4"/>
                        </button>
                        <span class="px-4 py-1.5 bg-indigo-50 dark:bg-gray-850 text-indigo-600 dark:text-indigo-400 rounded-md text-sm font-medium">
                          {{ currentPage }} / {{ totalPages }}
                        </span>
                        <button
                            @click="nextPage"
                            :disabled="currentPage === totalPages"
                            class="px-3 py-1.5 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-750 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                        >
                            <ChevronRight class="size-4"/>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Modal -->
        <div
            v-if="showModal"
            class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
            @click="closeModal"
        >
            <div
                class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md max-h-[80vh] overflow-y-auto"
                @click.stop
            >
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Update Row</h2>
                <form @submit.prevent="submitUpdate">
                    <div v-for="header in headers" :key="header" class="mb-4">
                        <label
                            :for="header"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 capitalize"
                        >
                            {{ header }}
                        </label>
                        <input
                            v-model="formData[header]"
                            :id="header"
                            type="text"
                            class="w-full px-3 py-2 rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                        />
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button
                            type="button"
                            @click="closeModal"
                            class="px-4 py-2 rounded-md border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 transition-all duration-200"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.3s ease;
}
.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateY(10px);
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

table {
    table-layout: fixed;
    width: 100%;
}

th,
td {
    min-width: 200px;
    max-width: 200px;
}
</style>
