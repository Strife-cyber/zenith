<script setup lang="ts">
import { defineProps, ref, onMounted } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import Table from '@/components/ui/table/Table.vue';
import { BreadcrumbItem } from '@/components/ui/breadcrumb';
import { router } from '@inertiajs/vue3';
import Toast from '@/components/ui/toast/Toast.vue';
import { UserCog2 } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Admin',
        href: '/admin',
    },
];

const showToast = ref(false);
const toastMessage = ref("");

// Define props for passing in data
defineProps<{
    cars: any;
    lands: any;
    users: any;
    listings: any;
    apartments: any;
}>();

// Reactive state for tabs
const activeTab = ref('users');

// Save active tab to localStorage
function saveActiveTab(tabName: string) {
    localStorage.setItem('activeTab', tabName);
}

// Load active tab from localStorage
function loadActiveTab() {
    const savedTab = localStorage.getItem('activeTab');
    if (savedTab) {
        activeTab.value = savedTab;
    }
}

// Fetch saved active tab on component mount
onMounted(() => {
    loadActiveTab();
});

const tabs = [
    { name: 'users', label: 'Users' },
    { name: 'listings', label: 'Listings' },
    { name: 'apartments', label: 'Apartments' },
    { name: 'vehicles', label: 'Vehicles' },
    { name: 'lands', label: 'Lands' },
];

// Update row function, you can implement the update logic here
function updateRow(id: string, data: any) {
    console.log(`Updating row ${id} with:`, data);
    // Implement your update logic here (e.g., open a modal or send a PUT request)
    router.put(`/${activeTab.value}/${id}`, data, {
        onSuccess: () => {
            toastMessage.value = "Item updated successfully";
            showToast.value = true;
            setTimeout(() => (showToast.value = false), 100);
        },
        onError: (error) => console.error(error),
    });
}

// Delete row function, uses Inertia to delete the item and trigger a toast notification
function deleteRow(id: string) {
    if (confirm('Are you sure you want to delete this item?')) {
        router.delete(`/${activeTab.value}/${id}`, {
            onSuccess: () => {
                toastMessage.value = "Item deleted successfully";
                showToast.value = true;
                setTimeout(() => (showToast.value = false), 100);
                // Optionally, you can refresh the page or reload the list after to delete
                window.location.reload();
            },
            onError: (error) => {
                toastMessage.value = "Failed to delete item";
                showToast.value = true;
                setTimeout(() => (showToast.value = false), 100);
                console.error(error);
            },
        });
    }
}

// Set active tab for the table view
function setActiveTab(tabName: string) {
    activeTab.value = tabName;
    saveActiveTab(tabName); // Save the active tab to localStorage
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- Toast component for showing messages -->
        <Toast :message="toastMessage" :active="showToast"/>

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">

                <!-- Tab Navigation -->
                <div class="bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                    <nav class="flex space-x-4 p-4" aria-label="Tabs">
                        <button
                            v-for="tab in tabs"
                            :key="tab.name"
                            @click="setActiveTab(tab.name)"
                            :class="[activeTab === tab.name
                                  ? 'bg-white dark:bg-gray-800 text-orange-600 dark:text-orange-400 shadow-sm'
                                  : 'text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-800 dark:hover:bg-gray-850/60',
                                'px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-orange-500']"
                        >
                            {{ tab.label }}
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="p-4">
                    <!-- Users Tab -->
                    <div v-if="activeTab === 'users'" class="animate-fade-in">
                        <Table :data="users" :handle-update="updateRow" :handle-delete="deleteRow" :updatable="false">
                            <template v-slot="{ row }">
                                <button
                                    @click="() => updateRow(row.id, { 'admin': true })"
                                    class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center transition-all duration-200 transform hover:scale-105"
                                >
                                    <UserCog2 class="size-4"/>
                                </button>
                            </template>
                        </Table>
                    </div>

                    <!-- Other Tabs (Listings, Apartments, Vehicles, Lands) -->
                    <div v-if="activeTab === 'listings'" class="animate-fade-in">
                        <Table :data="listings" :handle-update="updateRow" :handle-delete="deleteRow" :updatable="true"/>
                    </div>
                    <div v-if="activeTab === 'apartments'" class="animate-fade-in">
                        <Table :data="apartments" :handle-update="updateRow" :handle-delete="deleteRow" :updatable="true"/>
                    </div>
                    <div v-if="activeTab === 'vehicles'" class="animate-fade-in">
                        <Table :data="cars" :handle-update="updateRow" :handle-delete="deleteRow" :updatable="true"/>
                    </div>
                    <div v-if="activeTab === 'lands'" class="animate-fade-in">
                        <Table :data="lands" :handle-update="updateRow" :handle-delete="deleteRow" :updatable="true"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
.animate-fade-in {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
