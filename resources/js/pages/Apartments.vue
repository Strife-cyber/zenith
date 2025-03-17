<script setup lang="ts">
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import ApartmentCard from '@/components/ApartmentCard.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SearchBar from '@/components/SearchBar.vue';
import type { BreadcrumbItemType } from '@/types'; // Match AppLayout's expected type

// Define types
interface Image {
    id: number;
    url: string;
    listing_id: number;
    created_at: string;
    updated_at: string;
}

interface Apartment {
    bedrooms: number;
    bathrooms: number;
    size: number;
    furnished: boolean;
    parking: boolean;
    amenities: string[];
}

interface Listing {
    id: number;
    title: string;
    price: number;
    type: string;
    images: Image[];
    listable: Apartment;
}

interface PaginatedApartments {
    data: Listing[];
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
}

// Props from Inertia
const props = defineProps<{
    apartments: PaginatedApartments;
}>();

// Pagination navigation
const goToPage = (page: number) => {
    if (page >= 1 && page <= props.apartments.last_page) {
        router.get(route('apartments'), { page }, { preserveState: true });
    }
};

// Handle search event
const handleSearch = (value: string) => {
    console.log('Search query:', value);
    router.get(
        route('apartments'),
        { search: value, page: 1 }, // Reset to page 1 on new search
        { preserveState: true }
    );
};

// Breadcrumbs matching AppLayout's expected type
const breadcrumbs: BreadcrumbItemType[] = [
    {
        title: 'Apartments',
        href: '/apartments',
    },
];
</script>

<template>
    <AppLayout
        :breadcrumbs="breadcrumbs"
        :searchbar="SearchBar"
        :handlesearch="handleSearch"
    >
        <div class="min-h-screen py-12">
            <div class="container mx-auto px-6">
                <!-- Header -->
                <h1 class="text-4xl md:text-5xl font-extrabold text-center bg-clip-text text-transparent
                 bg-gradient-to-r from-orange-400 to-orange-600 mb-10 animate-fadeIn">
                    Our Apartments
                </h1>

                <!-- Apartments Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <ApartmentCard
                        v-for="listing in apartments.data"
                        :key="listing.id"
                        :listing="listing"
                    />
                </div>

                <!-- Pagination Controls -->
                <div class="flex justify-center items-center mt-12 space-x-4">
                    <button
                        @click="goToPage(apartments.current_page - 1)"
                        :disabled="apartments.current_page === 1"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-orange-500
                 hover:text-white transition-all duration-300 disabled:opacity-50
                 disabled:cursor-not-allowed"
                    >
                        Previous
                    </button>

                    <span class="text-gray-200 font-medium">
                      Page {{ apartments.current_page }} of {{ apartments.last_page }} ({{ apartments.total }} total)
                    </span>

                    <button
                        @click="goToPage(apartments.current_page + 1)"
                        :disabled="apartments.current_page === apartments.last_page"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-orange-500
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
