<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItemType } from '@/types';
import { defineComponent } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
    searchbar?: {
        type: ReturnType<typeof defineComponent>;
        required?: boolean;
    };
    handlesearch?: (value: string) => void;
}

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />
        <AppContent variant="sidebar">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" :searchbar="searchbar" :handlesearch="handlesearch" />
            <slot />
        </AppContent>
    </AppShell>
</template>
