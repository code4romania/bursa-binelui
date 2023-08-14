<template>
    <div class="flex">
        <div class="p-4 mt-1 overflow-y-auto bg-white border-r border-gray-200 lg:w-72">
            <p class="mb-5 text-base font-medium text-gray-500">Administrează</p>
            <nav>
                <ul role="list" class="space-y-1">
                    <li v-for="item in navigation" :key="item.name" >
                        <Link
                            :href="item.route"
                            :class="[isActive(item) ? 'text-primary-500 bg-primary-50 rounded-md' : 'text-gray-600', 'group flex gap-x-3 p-2 text-sm leading-6 font-medium']"
                        >
                            <component
                                :is="item.icon"
                                :class="[isActive(item) ? 'text-primary-500' : 'text-gray-600', 'h-6 w-6 shrink-0']"
                                aria-hidden="true"
                            />
                            {{ item.name }}
                        </Link>

                        <ul
                            role="list"
                            class="space-y-1"
                            v-if="item.subMenu?.length>0"
                            :class="['text-gray-600', 'group flex flex-wrap gap-x-3 p-2 text-sm leading-6 font-medium']"
                        >
                            <li v-for="subItem in item.subMenu" class="mr-3" :key="subItem.name">
                                <Link
                                    :href="subItem.route"
                                    :class="[isActive(subItem) ? 'text-primary-500 bg-primary-50 rounded-md' : 'text-gray-600', 'group flex gap-x-3 p-2 text-sm leading-6 font-medium']"
                                >
                                    <component
                                        :is="subItem.icon"
                                        :class="[isActive(subItem) ? 'text-primary-500' : 'text-gray-600', 'h-6 w-6 shrink-0']"
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

        <div class="flex-1">
            <div>
                <slot/>
            </div>
        </div>
    </div>
</template>

<script setup>
/** Import form inertia. */
import {Link, usePage} from '@inertiajs/vue3';

/** Import plugins. */
import {
    CalendarIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    FolderOpenIcon,
    FolderMinusIcon, UserMinusIcon, UserPlusIcon,UserGroupIcon
} from '@heroicons/vue/24/outline';


/** Sidebar links. */
const navigation = [
    {
        name: 'Organizația mea',
        href: 'admin.ong.edit',
        route: route('admin.ong.edit', 1),
        subroutes: [],
        icon: HomeIcon
    },
    {
        name: 'Proiectele mele',
        href: 'admin.ong.projects',
        route: route('admin.ong.projects'),
        subroutes: ['admin.ong.project.add', 'admin.ong.project.edit'],
        subMenu: [
            {
                name: 'published_projects',
                href: 'admin.ong.projects',
                route: route('admin.ong.projects', {'project_status': 'published'}),
                icon: FolderOpenIcon,
                subroutes: [],
            },
            {
                name: 'draft_projects',
                href: 'admin.ong.projects',
                route: route('admin.ong.projects', {'project_status': 'draft'}),
                subroutes: [],
                icon: FolderMinusIcon
            },
            {
                name: 'regional_projects',
                href: 'admin.ong.projects',
                route: route('admin.ong.regional.project.add'),
                subroutes: [],
                icon: FolderMinusIcon
            }
        ],
        icon: FolderIcon
    },
    {
        name: 'Proiectele mele regionale',
        href: 'admin.ong.projects',
        route: route('admin.ong.regional.projects'),
        subroutes: ['admin.ong.project.add', 'admin.ong.project.edit'],
        subMenu: [
            {
                name: 'published_projects',
                href: 'admin.ong.projects',
                route: route('admin.ong.regional.projects', {'project_status': 'published'}),
                icon: FolderOpenIcon,
                subroutes: [],
            },
            {
                name: 'draft_projects',
                href: 'admin.ong.projects',
                route: route('admin.ong.regional.projects', {'project_status': 'draft'}),
                subroutes: [],
                icon: FolderMinusIcon
            },
        ],
        icon: FolderIcon
    },
    {
        name: 'Voluntari',
        href: 'admin.ong.volunteers',
        route: route('admin.ong.volunteers'),
        subroutes: ['admin.ong.project.add', 'admin.ong.project.edit'],
        subMenu: [
            {
                name: 'volunteers_approved',
                href: route('admin.ong.volunteers', {'status': 'approved'}),
                route: route('admin.ong.volunteers', {'status': 'approved'}),
                icon: UserGroupIcon,
                subroutes: [],
            },
            {
                name: 'volunteers_pending',
                href: route('admin.ong.volunteers', {'status': 'pending'}),
                route: route('admin.ong.volunteers', {'status': 'pending'}),
                subroutes: [],
                icon: UserPlusIcon
            },
            {
                name: 'volunteers_rejected',
                href: route('admin.ong.volunteers', {'status': 'rejected'}),
                route: route('admin.ong.volunteers', {'status': 'rejected'}),
                subroutes: [],
                icon: UserMinusIcon
            }
        ],
        icon: UsersIcon,
    },
    {
        name: 'Donații',
        href: 'admin.ong.donations',
        route: route('admin.ong.donations'),
        subroutes: [],
        icon: CalendarIcon
    },
    {
        name: 'Tichete',
        href: 'admin.ong.tickets.open',
        route: route('admin.ong.tickets.open'),
        subroutes: ['admin.ong.tickets.open', 'admin.ong.tickets.closed', 'admin.ong.tickets.view'],
        icon: DocumentDuplicateIcon
    }
];

/**
 * Determines if a navigation item should be active based on the current route.
 *
 * @param {Object} item The navigation item to check.
 *
 * @returns {Boolean} Whether or not the navigation item should be active.
 */
const isActive = (item) => {
    if (item.route === `${window.location.origin}${window.location.pathname}${window.location.search}`) {
    return true;
    }

    /** UNCOMENT IF PARENT NEED TO BE SELECTED TO */

    // if (item.subMenu) {
    //     for (const subItem of item.subMenu) {
    //         if (subItem.route  === `${window.location.origin}${window.location.pathname}${window.location.search}`) {
    //             return true;
    //         }
    //     }
    // }

    return false;
};
</script>
