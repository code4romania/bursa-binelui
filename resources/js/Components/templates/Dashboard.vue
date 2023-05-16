<template>
    <div class="flex">
        <div class="overflow-y-auto border-r border-gray-200 bg-white lg:w-72 mt-1 p-4">
            <p class="mb-5 text-base font-medium text-gray-500">Administrează</p>
            <nav>
                <ul role="list" class="space-y-1">
                    <li v-for="item in navigation" :key="item.name">
                        <Link
                            :href="route(item.href)"
                            :class="[route().current(item.href) ? 'text-turqoise-500 bg-turqoise-50 rounded-md' : 'text-gray-600', 'group flex gap-x-3 p-2 text-sm leading-6 font-medium']"
                        >
                            <component :is="item.icon" :class="[route().current(item.href) ? 'text-turqoise-500' : 'text-gray-600', 'h-6 w-6 shrink-0']" aria-hidden="true" />
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
        { name: 'Organizatia mea', href: 'dashboard', icon: HomeIcon },
        { name: 'Voluntari', href: 'login', icon: UsersIcon, },
        { name: 'Proiectele mele', href: 'admin.ong.projects', icon: FolderIcon },
        { name: 'Donatii', href: 'login', icon: CalendarIcon },
        { name: 'Tichete', href: 'login', icon: DocumentDuplicateIcon }
    ];
</script>
