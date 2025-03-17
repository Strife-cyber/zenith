<script setup lang="ts">
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import LandCard from '@/components/LandCard.vue';
import { BreadcrumbItem } from '@/components/ui/breadcrumb';
import AppLayout from '@/layouts/AppLayout.vue';
import SearchBar from '@/components/SearchBar.vue';

// Define types
interface Image {
    id: number;
    url: string;
    listing_id: number;
    created_at: string;
    updated_at: string;
}

interface Land {
    size?: number;
    zoning?: 'residential' | 'commercial' | 'agricultural';
    document?: boolean;
}

interface Listing {
    id: number;
    title: string;
    price: number;
    type: string;
    images: Image[];
    listable: Land | null;
}

interface PaginatedLands {
    data: Listing[];
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
}

// Props from Inertia
const props = defineProps<{
    lands: PaginatedLands;
}>();

// Pagination navigation
const goToPage = (page: number) => {
    if (page >= 1 && page <= props.lands.last_page) {
        router.get(route('lands'), { page }, { preserveState: true });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lands',
        href: '/lands',
    },
];

const handleSearch = (value: string) => {
    console.log('Search query:', value);
    router.get(
        route('lands'),
        { search: value, page: 1 }, // Reset to page 1 on new search
        { preserveState: true }
    );
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs" :searchbar="SearchBar" :handlesearch="handleSearch">
        <div class="min-h-screen py-12">
            <div class="container mx-auto px-6">
                <!-- Header -->
                <h1 class="text-4xl md:text-5xl font-extrabold text-center bg-clip-text text-transparent
                 bg-gradient-to-r from-green-400 to-green-600 mb-10 animate-fadeIn">
                    Our Lands
                </h1>

                <!-- Lands Grid or Placeholder -->
                <div v-if="lands.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <LandCard
                        v-for="listing in lands.data"
                        :key="listing.id"
                        :listing="listing"
                    />
                </div>
                <div v-else class="text-center text-gray-400 animate-fadeIn">
                    <p class="text-lg">No land listings available yet. Check back soon!</p>
                </div>

                <!-- Pagination Controls -->
                <div v-if="lands.data.length > 0" class="flex justify-center items-center mt-12 space-x-4">
                    <button
                        @click="goToPage(lands.current_page - 1)"
                        :disabled="lands.current_page === 1"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-green-500
                         hover:text-white transition-all duration-300 disabled:opacity-50
                         disabled:cursor-not-allowed"
                    >
                        Previous
                    </button>

                    <span class="font-medium">
                      Page {{ lands.current_page }} of {{ lands.last_page }} ({{ lands.total }} total)
                    </span>

                    <button
                        @click="goToPage(lands.current_page + 1)"
                        :disabled="lands.current_page === lands.last_page"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-green-500
                         hover:text-white transition-all duration-300 disabled:opacity-50
                         disabled:cursor-not-allowed"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fadeIn {
    animation: fadeIn 0.8s ease-out forwards;
}
</style>
