<template>
    <div class="flex flex-col min-h-screen">
        <Navbar />
        <PontBanner />

        <Notification />
        <OrganizationStatus />

        <div class="flex items-start flex-1 gap-y-10">
            <div class="p-4 mt-1 overflow-y-auto bg-white border-r border-gray-200 lg:w-72 shrink-0">
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

            <div class="grid items-start flex-1 p-9" :class="gridClass">
                <slot />
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

const props = defineProps({
    gridClass: {
        type: String,
        default: 'gap-8',
    },
});

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

const isActive = (item) => {
    if (typeof window === 'undefined') {
        return false;
    }

    return item.route === `${window.location.origin}${window.location.pathname}${window.location.search}`;
};
</script>
