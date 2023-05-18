<template>
    <div class="flex">
        <div class="overflow-y-auto border-r border-gray-200 bg-white lg:w-72 mt-1 p-4">
            <p class="mb-5 text-base font-medium text-gray-500">Administrează</p>
            <nav>
                <ul role="list" class="space-y-1">
                    <li v-for="item in navigation" :key="item.name">
                        <Link
                            :href="item.route"
                            :class="[isActive(item) ? 'text-turqoise-500 bg-turqoise-50 rounded-md' : 'text-gray-600', 'group flex gap-x-3 p-2 text-sm leading-6 font-medium']"
                        >
                            <component :is="item.icon" :class="[isActive(item) ? 'text-turqoise-500' : 'text-gray-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                           {{ item.name }}
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="flex-1">
            <div>
                <slot />
            </div>
        </div>
    </div>
  </template>

<script setup>
    /** Import form inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import plugins. */
    import { CalendarIcon, DocumentDuplicateIcon, FolderIcon, HomeIcon, UsersIcon } from '@heroicons/vue/24/outline';

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
            subroutes: [],
            icon: UsersIcon,
        },
        {
            name: 'Proiectele mele',
            href: 'admin.ong.projects',
            route: route('admin.ong.projects'),
            subroutes: ['admin.ong.project.add', 'admin.ong.project.edit'],
            icon: FolderIcon
        },
        {
            name: 'Donatii',
            href: 'login',
            route: route('login'),
            subroutes: [],
            icon: CalendarIcon
        },
        {
            name: 'Tichete',
            href: 'login',
            route: route('login'),
            subroutes: [],
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
