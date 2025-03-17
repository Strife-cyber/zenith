<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
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
    <AppLayout :breadcrumbs="breadcrumbs" :searchbar="searchbar" :handlesearch="handlesearch">
        <slot />
    </AppLayout>
</template>
