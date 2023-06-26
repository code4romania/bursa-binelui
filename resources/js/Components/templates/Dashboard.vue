<template>
    <div class="flex">
        <div class="overflow-y-auto border-r border-gray-200 bg-white lg:w-72 mt-1 p-4">
            <p class="mb-5 text-base font-medium text-gray-500">Administrează</p>
            <nav>
                <ul role="list" class="space-y-1">
                    <li v-for="item in navigation" :key="item.name" >

                        <Link
                            :href="item.route"
                            :class="[isActive(item) ? 'text-turqoise-500 bg-turqoise-50 rounded-md' : 'text-gray-600', 'group flex gap-x-3 p-2 text-sm leading-6 font-medium']"
                        >
                            <component :is="item.icon"
                                       :class="[isActive(item) ? 'text-turqoise-500' : 'text-gray-600', 'h-6 w-6 shrink-0']"
                                       aria-hidden="true"/>
                            {{ item.name }}
                        </Link>
                        <ul role="list" class="space-y-1" v-if="item.subMenu?.length>0"
                            :class="[isActive(item) ? 'text-turqoise-500 bg-turqoise-50 rounded-md' : 'text-gray-600', 'group flex flex-wrap gap-x-3 p-2 text-sm leading-6 font-medium']"
                        >
                            <li v-for="subItem in item.subMenu" class="mr-3" :key="subItem.name">
                                <Link
                                    :href="subItem.route"
                                    :class="[isActive(subItem) ? 'text-turqoise-500 bg-turqoise-50 rounded-md' : 'text-gray-600', 'group flex gap-x-3 p-2 text-sm leading-6 font-medium']"
                                >
                                    <component :is="subItem.icon"
                                               :class="[isActive(subItem) ? 'text-turqoise-500' : 'text-gray-600', 'h-6 w-6 shrink-0']"
                                               aria-hidden="true"/>
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
import {Link} from '@inertiajs/vue3';

/** Import plugins. */
import {
    CalendarIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    FolderOpenIcon,
    FolderMinusIcon
} from '@heroicons/vue/24/outline';

/** Sidebar links. */
const navigation = [
    {
        name: 'Organizatia mea',
        href: 'admin.ong.edit',
        route: route('admin.ong.edit', 1),
        subroutes: [],
        icon: HomeIcon
    },
    {
        name: 'Voluntari',
        href: 'admin.ong.volunteers',
        route: route('admin.ong.volunteers'),
        subroutes: ['admin.ong.project.add', 'admin.ong.project.edit'],
        subMenu: [
            {
                name: 'volunteers_approved',
                href: 'admin.ong.volunteers',
                route: route('admin.ong.volunteers', {'status': 'approved'}),
                icon: UsersIcon,
                subroutes: [],
            },
            {
                name: 'volunteers_pending',
                href: 'admin.ong.volunteers',
                route: route('admin.ong.volunteers', {'status': 'pending'}),
                subroutes: [],
                icon: UsersIcon
            },
            {
                name: 'volunteers_rejected',
                href: 'admin.ong.volunteers',
                route: route('admin.ong.volunteers', {'status': 'rejected'}),
                subroutes: [],
                icon: UsersIcon
            }
        ],
        icon: UsersIcon,
    },
    {
        name: 'Proiectele mele',
        href: 'admin.ong.projects',
        route: route('admin.ong.projects'),
        subroutes: ['admin.ong.project.add', 'admin.ong.project.edit'],
        subMenu: [
            {
                name: 'published_projects',
                href: 'admin.ong.projects.live',
                route: route('admin.ong.projects', {'project_status': 'published'}),
                icon: FolderOpenIcon,
                subroutes: [],
            },
            {
                name: 'draft_projects',
                href: 'admin.ong.projects.draft',
                route: route('admin.ong.projects', {'project_status': 'draft'}),
                subroutes: [],
                icon: FolderMinusIcon
            }
        ],
        icon: FolderIcon
    },
    {
        name: 'Donatii',
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
    if (route().current(item.href)) {
        return true;
    }

    return item.subroutes.some(subroute => route().current(subroute));
}
</script>
