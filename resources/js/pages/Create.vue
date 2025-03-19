
<script setup lang="ts">
import { ref, onMounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/components/ui/breadcrumb';
import Table from '@/components/ui/table/Table.vue';
import AddApartment from '@/components/AddApartment.vue';
import AddVehicle from '@/components/AddVehicle.vue';
import AddLand from '@/components/AddLand.vue';

// Define the tab type
interface Tab {
    name: string;
    label: string;
}

// Define tabs array (hardcoded since no props)
const tabs: Tab[] = [
    { name: 'apartments', label: 'Apartments' },
    { name: 'vehicles', label: 'Vehicles' },
    { name: 'lands', label: 'Lands' },
];

// Reactive state for active tab
const activeTab = ref<string>('apartments');

// Cookie handling functions
const COOKIE_NAME = 'createtabcookie';

function getCookie(name: string): string | null {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop()?.split(';').shift() || null;
    return null;
}

function setCookie(name: string, value: string, days: number = 30): void {
    const expires = new Date();
    expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
    document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}

// Load saved tab from cookie on mount
onMounted(() => {
    const savedTab = getCookie(COOKIE_NAME);
    if (savedTab && tabs.some(tab => tab.name === savedTab)) {
        activeTab.value = savedTab;
    }
});

// Handle tab change
function changeTab(tabName: string): void {
    activeTab.value = tabName;
    setCookie(COOKIE_NAME, tabName);
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin',
        href: '/admin/create',
    },
];
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
            <nav class="flex space-x-12 p-4" aria-label="Tabs">
                <button
                    v-for="tab in tabs"
                    :key="tab.name"
                    @click="changeTab(tab.name)"
                    :class="[
                    activeTab === tab.name
                        ? 'bg-white dark:bg-gray-800 text-orange-600 dark:text-orange-400 shadow-sm'
                        : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-850/60',
                      'px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500'
                    ]"
                >
                    {{ tab.label }}
                </button>
            </nav>
            <div class="p-6">
                <div v-if="activeTab === 'apartments'" class="animate-fade-in">
                    <h1>Add an apartment</h1>
                    <AddApartment/>
                </div>
                <div v-if="activeTab === 'vehicles'" class="animate-fade-in">
                    <h1>Add a vehicle</h1>
                    <AddVehicle/>
                </div>
                <div v-if="activeTab === 'lands'" class="animate-fade-in">
                    <h1>Add a land</h1>
                    <AddLand/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* No additional CSS needed since we're using Tailwind */
</style>
