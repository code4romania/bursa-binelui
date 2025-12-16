<template>
    <div class="flex flex-col min-h-screen">
        <Navbar />
        <PontBanner />

        <Notification />
        <OrganizationStatus />

        <div class="flex items-start flex-1 gap-y-10">
            <!-- Desktop sidebar -->
            <div class="hidden md:block p-4 mt-1 overflow-y-auto bg-white border-r border-gray-200 lg:w-72 shrink-0">
                <nav>
                    <ul class="space-y-1">
                        <li v-for="item in navigation" :key="item.name">
                            <Link
                                :href="item.route"
                                :class="[
                                    isActive(item) ? 'text-primary-500 bg-primary-50 rounded-md' : 'text-gray-600',
                                    'group flex gap-x-3 p-2 text-sm leading-6 font-medium',
                                ]"
                            >
                                <component
                                    :is="item.icon"
                                    :class="[isActive(item) ? 'text-primary-500' : 'text-gray-600', 'h-6 w-6 shrink-0']"
                                    aria-hidden="true"
                                />
                                {{ item.name }}
                            </Link>

                            <ul
                                class="p-2 space-y-1 text-sm font-medium leading-6 text-gray-600 group gap-x-3"
                                v-if="item.subMenu?.length"
                            >
                                <li v-for="subItem in item.subMenu" class="mr-3" :key="subItem.name">
                                    <Link
                                        :href="subItem.route"
                                        :class="[
                                            isActive(subItem)
                                                ? 'text-primary-500 bg-primary-50 rounded-md'
                                                : 'text-gray-600',
                                            'group flex gap-x-3 p-2 text-sm leading-6 font-medium',
                                        ]"
                                    >
                                        <component
                                            :is="subItem.icon"
                                            :class="[
                                                isActive(subItem) ? 'text-primary-500' : 'text-gray-600',
                                                'h-6 w-6 shrink-0',
                                            ]"
                                            aria-hidden="true"
                                        />
                                        {{ $t(subItem.name) }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Main content -->
            <div class="grid items-start flex-1 p-9 pb-24 md:pb-9" :class="gridClass">
                <slot />
            </div>
        </div>

        <!-- Mobile bottom nav -->
        <div class="md:hidden fixed inset-x-0 bottom-0 z-50">
            <!-- Dropdown / sheet pentru submenu -->
            <transition
                enter-active-class="transition duration-150 ease-out"
                enter-from-class="opacity-0 translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 translate-y-2"
            >
                <div v-if="openSubMenuItem" class="px-3 pb-2">
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                            <div class="text-sm font-semibold text-gray-800">
                                {{ openSubMenuItem.name }}
                            </div>
                            <button type="button" class="text-sm font-medium text-gray-500" @click="closeSubMenu">
                                Închide
                            </button>
                        </div>

                        <div class="p-2">
                            <Link
                                v-for="sub in openSubMenuItem.subMenu"
                                :key="sub.name"
                                :href="sub.route"
                                class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm font-medium"
                                :class="isActive(sub) ? 'bg-primary-50 text-primary-600' : 'text-gray-700'"
                                @click="closeSubMenu"
                            >
                                <component
                                    :is="sub.icon"
                                    class="h-5 w-5"
                                    :class="isActive(sub) ? 'text-primary-600' : 'text-gray-500'"
                                    aria-hidden="true"
                                />
                                {{ $t(sub.name) }}
                            </Link>
                        </div>
                    </div>
                </div>
            </transition>

            <!-- Bara de jos -->
            <div class="bg-white border-t border-gray-200 pb-[env(safe-area-inset-bottom)]">
                <nav class="grid grid-cols-5">
                    <button
                        v-for="item in mobileNavigation"
                        :key="item.name"
                        type="button"
                        class="flex flex-col items-center justify-center gap-1 py-2"
                        :class="isActive(item) ? 'text-primary-600' : 'text-gray-600'"
                        @click="onMobileNavClick(item)"
                    >
                        <component
                            :is="item.icon"
                            class="h-6 w-6"
                            :class="isActive(item) ? 'text-primary-600' : 'text-gray-500'"
                            aria-hidden="true"
                        />
                        <span class="text-[11px] leading-none font-medium truncate max-w-[72px]">
                            {{ item.name }}
                        </span>
                    </button>
                </nav>
            </div>
        </div>

        <Footer class="mt-16" />
    </div>
</template>
<script setup>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import PontBanner from '@/Components/PontBanner.vue';
import Notification from '@/Components/Notification.vue';
import route from '@/Helpers/useRoute';

import {
    AnnotationIcon,
    CurrencyEuroIcon,
    FolderIcon,
    FolderOpenIcon,
    FolderRemoveIcon,
    HomeIcon,
    OfficeBuildingIcon,
    UserAddIcon,
    UserCircleIcon,
    UserGroupIcon,
    UserRemoveIcon,
} from '@heroicons/vue/outline';
import OrganizationStatus from '@/Components/OrganizationStatus.vue';
import { trans } from 'laravel-vue-i18n';
import { computed, ref } from 'vue';

const props = defineProps({
    gridClass: {
        type: String,
        default: 'gap-8',
    },
});
const openSubMenuName = ref(null);

const navigation = [
    {
        name: 'Panou de control',
        route: route('dashboard.main'),
        icon: HomeIcon,
    },
    {
        name: 'Organizația mea',
        route: route('dashboard.organization.edit'),
        icon: OfficeBuildingIcon,
    },
    {
        name: 'Toate proiectele',
        route: route('dashboard.projects.index'),
        icon: FolderIcon,
        subMenu: [
            {
                name: 'published_projects',
                route: route('dashboard.projects.index', {
                    project_status: 'published',
                }),
                icon: FolderOpenIcon,
            },
            {
                name: 'draft_projects',
                route: route('dashboard.projects.index', { project_status: 'draft' }),
                icon: FolderRemoveIcon,
            },
        ],
    },
    {
        name: 'Gale bursa binelui',
        route: route('dashboard.projects.gala.index'),
        icon: FolderIcon,
    },
    {
        name: 'Voluntari',
        route: route('dashboard.volunteers.index'),
        icon: UserGroupIcon,
        subMenu: [
            {
                name: 'volunteers_pending',
                route: route('dashboard.volunteers.index', { status: 'pending' }),
                icon: UserAddIcon,
            },
            {
                name: 'volunteers_rejected',
                route: route('dashboard.volunteers.index', { status: 'rejected' }),
                icon: UserRemoveIcon,
            },
        ],
    },
    {
        name: 'Manageri ONG',
        route: route('dashboard.users.index'),
        icon: UserCircleIcon,
    },
    {
        name: 'Donații ONG',
        route: route('dashboard.donations.index'),
        icon: CurrencyEuroIcon,
    },
    {
        name: 'Tickets',
        route: route('dashboard.tickets.index', { status: 'open' }),
        icon: AnnotationIcon,
    },
];

const openSubMenuItem = computed(() => {
    if (!openSubMenuName.value) return null;
    return navigation.find((x) => x.name === openSubMenuName.value && x.subMenu?.length);
});

const closeSubMenu = () => {
    openSubMenuName.value = null;
};

const mobileNavigation = computed(() => {
    const wanted = ['Panou de control', 'Toate proiectele', 'Voluntari', 'Donații ONG', 'Tickets'];
    return navigation.filter((x) => wanted.includes(x.name));
});

const onMobileNavClick = (item) => {
    if (item.subMenu?.length) {
        openSubMenuName.value = openSubMenuName.value === item.name ? null : item.name;
        return;
    }

    closeSubMenu();
    window.location.href = item.route;
};

const isActive = (item) => {
    if (typeof window === 'undefined') {
        return false;
    }

    return item.route === `${window.location.origin}${window.location.pathname}${window.location.search}`;
};
</script>
