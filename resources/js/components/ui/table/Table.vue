<script setup lang="ts">
import { ref } from 'vue';
import TableHeader from './TableHeader.vue';
import TableBody from './TableBody.vue';
import Pagination from './Pagination.vue';
import SearchBar from './SearchBar.vue';
import type { TableRow } from './types';

const props = defineProps<{
    data: TableRow[];
    handleUpdate?: (id: string, data: any) => void;
    handleDelete?: (id: string) => void;
    updatable?: boolean;
}>();

const currentPage = ref(1);
const pageSize = ref(10);
const searchQuery = ref('');
const sortKey = ref('');
const sortDirection = ref<'asc' | 'desc'>('asc');
const columnFilters = ref<Record<string, string>>({});

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
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden">
            <SearchBar v-model="searchQuery" />
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <TableHeader
                        :data="props.data"
                        :sort-key="sortKey"
                        :sort-direction="sortDirection"
                        :column-filters="columnFilters"
                        @sort="sortTable"
                    />
                    <TableBody
                        :data="props.data"
                        :current-page="currentPage"
                        :page-size="pageSize"
                        :search-query="searchQuery"
                        :sort-key="sortKey"
                        :sort-direction="sortDirection"
                        :column-filters="columnFilters"
                        :updatable="props.updatable"
                        @update-row="openUpdateModal"
                        @delete-row="props.handleDelete"
                        :handle-update="handleUpdate"
                    >
                        <template v-slot="{ row }">
                            <slot :row="row"></slot> <!-- Passing row to the next slot -->
                        </template>
                    </TableBody>
                </table>
            </div>
            <Pagination
                :data="props.data"
                :current-page="currentPage"
                :page-size="pageSize"
                :search-query="searchQuery"
            />
        </div>
    </div>
</template>

<style>
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
    from { opacity: 0; }
    to { opacity: 1; }
}

table {
    table-layout: fixed;
    width: 100%;
}

th, td {
    min-width: 200px;
    max-width: 200px;
}
</style>
