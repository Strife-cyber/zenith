<script setup lang="ts">
import { type NavItem, User } from '@/types';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Link, usePage } from '@inertiajs/vue3';
import NavFooter from '@/components/NavFooter.vue';
import { LayoutGrid, Building, CarFront, Map, UserCog2Icon } from 'lucide-vue-next';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import AppLogo from '@/components/AppLogo.vue';

const page = usePage<ShareData>();
const user = page.props.auth.user as User;

const mainNavItems: NavItem[] = [
    {
        title: 'Home',
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
    },
    ...(user.admin ? [{
        title: 'Admin',
        href: '/admin',
        icon: UserCog2Icon
    }] : [])
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo/>
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
