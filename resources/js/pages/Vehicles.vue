<script setup lang="ts">
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import CarCard from '@/components/CarCard.vue';
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

interface Car {
    make: string;
    model: string;
    year: number;
    transmission: string;
    fuel: string;
    condition: string;
}

interface Listing {
    id: number;
    title: string;
    price: number;
    type: string;
    images: Image[];
    listable: Car;
}

interface PaginatedVehicles {
    data: Listing[];
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
}

// Props from Inertia
const props = defineProps<{
    vehicles: PaginatedVehicles;
}>();

// Pagination navigation
const goToPage = (page: number) => {
    if (page >= 1 && page <= props.vehicles.last_page) {
        router.get(route('vehicles'), { page }, { preserveState: true });
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Vehicles',
        href: '/vehicles',
    },
];

const handleSearch = (value: string) => {
    console.log('Search query:', value);
    router.get(
        route('vehicles'),
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
                 bg-gradient-to-r from-blue-400 to-blue-600 mb-10 animate-fadeIn">
                    Our Vehicles
                </h1>

                <!-- Vehicles Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <CarCard
                        v-for="listing in vehicles.data"
                        :key="listing.id"
                        :listing="listing"
                    />
                </div>

                <!-- Pagination Controls -->
                <div class="flex justify-center items-center mt-12 space-x-4">
                    <button
                        @click="goToPage(vehicles.current_page - 1)"
                        :disabled="vehicles.current_page === 1"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-blue-500
                         hover:text-white transition-all duration-300 disabled:opacity-50
                         disabled:cursor-not-allowed"
                    >
                        Previous
                    </button>

                    <span class="font-medium">
                      Page {{ vehicles.current_page }} of {{ vehicles.last_page }} ({{ vehicles.total }} total)
                    </span>

                    <button
                        @click="goToPage(vehicles.current_page + 1)"
                        :disabled="vehicles.current_page === vehicles.last_page"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-blue-500
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
