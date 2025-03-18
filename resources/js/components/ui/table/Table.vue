<script setup lang="ts">
import { ref } from 'vue';
import TableHeader from './TableHeader.vue';
import TableBody from './TableBody.vue';
import Pagination from './Pagination.vue';
import SearchBar from './SearchBar.vue';
import type { TableRow } from './types';

const props = defineProps<{
    data: TableRow[];
    handleAdd?: (data: any) => void;
    handleUpdate?: (id: string, data: any) => void;
    handleDelete?: (id: string) => void;
    updatable?: boolean;
    addable?: boolean;
}>();

const currentPage = ref(1);
const pageSize = ref(10);
const searchQuery = ref('');
</script>

<template>
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden">
            <SearchBar v-model="searchQuery" />
            <div class="overflow-x-auto">
                <table class="w-full table-fixed">
                    <TableHeader :data="props.data" />
                    <TableBody
                        :data="props.data"
                        :current-page="currentPage"
                        :page-size="pageSize"
                        :search-query="searchQuery"
                        :updatable="props.updatable"
                        :addable="props.addable"
                        @update-row="openUpdateModal"
                        @delete-row="props.handleDelete"
                        :handle-update="handleUpdate"
                        :handle-add="handleAdd"
                    ><slot/></TableBody>
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
