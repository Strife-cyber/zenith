<script setup lang="ts">
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import NavFooter from '@/components/NavFooter.vue';
import { LayoutGrid, Building, CarFront, Map } from 'lucide-vue-next';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Apartments',
        href: '/apartments',
        icon: Building
    },
    {
        title: 'Vehicles',
        href: '/vehicles',
        icon: CarFront
    },
    {
        title: 'Lands',
        href: '/lands',
        icon: Map
    }
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')" class="text-orange-500 font-bold text-xl">
                            ZENITH ESTATE
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
