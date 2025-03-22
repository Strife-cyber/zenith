<script setup lang="ts">
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import ListingCard from '@/components/ListingCard.vue';
import { BreadcrumbItem } from '@/components/ui/breadcrumb';

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Home',
        href: '/dashboard',
    },
];

// Define Listing type for better TypeScript safety
interface Image {
    id: number;
    url: string;
    listing_id: number;
    created_at: string;
    updated_at: string;
}

interface Listing {
    id: number;
    title: string;
    description: string;
    price: number;
    type: string;
    images: Image[];
    created_at: string;
    updated_at: string;
}

interface PaginatedListings {
    data: Listing[];
    current_page: number;
    last_page: number;
    total: number;
    per_page: number;
}

// Props from Inertia
const props = defineProps<{
    listings: PaginatedListings;
}>();

// Pagination navigation
const goToPage = (page: number) => {
    if (page >= 1 && page <= props.listings.last_page) {
        router.get(route('dashboard'), { page }, { preserveState: true });
    }
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen py-12">
            <div class="container mx-auto px-6">
                <!-- Header -->
                <h1 class="text-4xl md:text-5xl font-extrabold text-center bg-clip-text text-transparent
                 bg-gradient-to-r from-orange-400 to-orange-600 mb-10 animate-fadeIn">
                    Listings
                </h1>

                <!-- Listings Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <ListingCard
                        v-for="listing in listings.data"
                        :key="listing.id"
                        :listing="listing"
                    />
                </div>

                <!-- Pagination Controls -->
                <div class="flex justify-center items-center mt-12 space-x-4">
                    <button
                        @click="goToPage(listings.current_page - 1)"
                        :disabled="listings.current_page === 1"
                        class="px-4 py-2 bg-gray-700 text-gray-200 rounded-full hover:bg-orange-500
                         hover:text-white transition-all duration-300 disabled:opacity-50
                         disabled:cursor-not-allowed"
                    >
                        Previous
                    </button>

                    <span class="font-medium">
                      Page {{ listings.current_page }} of {{ listings.last_page }} ({{ listings.total }} total)
                    </span>

                    <button
                        @click="goToPage(listings.current_page + 1)"
                        :disabled="listings.current_page === listings.last_page"
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
