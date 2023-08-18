<template>
    <div class="flex">
        <div
            class="p-4 mt-1 overflow-y-auto bg-white border-r border-gray-200 lg:w-72"
        >
            <p class="mb-5 text-base font-medium text-gray-500">
                Administrează
            </p>
            <nav>
                <ul role="list" class="space-y-1">
                    <li v-for="item in navigation" :key="item.name">
                        <Link
                            :href="item.route"
                            :class="[
                                isActive(item)
                                    ? 'text-primary-500 bg-primary-50 rounded-md'
                                    : 'text-gray-600',
                                'group flex gap-x-3 p-2 text-sm leading-6 font-medium',
                            ]"
                        >
                            <component
                                :is="item.icon"
                                :class="[
                                    isActive(item)
                                        ? 'text-primary-500'
                                        : 'text-gray-600',
                                    'h-6 w-6 shrink-0',
                                ]"
                                aria-hidden="true"
                            />
                            {{ item.name }}
                        </Link>

                        <ul
                            role="list"
                            class="space-y-1"
                            v-if="item.subMenu?.length > 0"
                            :class="[
                                'text-gray-600',
                                'group flex flex-wrap gap-x-3 p-2 text-sm leading-6 font-medium',
                            ]"
                        >
                            <li
                                v-for="subItem in item.subMenu"
                                class="mr-3"
                                :key="subItem.name"
                            >
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
                                            isActive(subItem)
                                                ? 'text-primary-500'
                                                : 'text-gray-600',
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

        <div class="flex-1">
            <div>
                <slot />
            </div>
        </div>
    </div>
</template>

<script setup>
    /** Import form inertia. */
    import { Link, usePage } from "@inertiajs/vue3";

    /** Import plugins. */
    import {
        CalendarIcon,
        DocumentDuplicateIcon,
        FolderIcon,
        HomeIcon,
        UsersIcon,
        FolderOpenIcon,
        FolderMinusIcon,
        UserMinusIcon,
        UserPlusIcon,
        UserGroupIcon,
    } from "@heroicons/vue/24/outline";

    /** Sidebar links. */
    const navigation = [
        {
            name: "Organizația mea",
            route: route("admin.ong.edit", 1),
            icon: HomeIcon,
        },
        {
            name: "Proiectele mele",
            route: route("admin.ong.projects"),
            subMenu: [
                {
                    name: "published_projects",
                    route: route("admin.ong.projects", {
                        project_status: "published",
                    }),
                    icon: FolderOpenIcon,
                },
                {
                    name: "draft_projects",
                    route: route("admin.ong.projects", { project_status: "draft" }),
                    icon: FolderMinusIcon,
                },
                {
                    name: "regional_projects",
                    route: route("admin.ong.regional.project.add"),
                    icon: FolderMinusIcon,
                },
            ],
            icon: FolderIcon,
        },
        {
            name: "Proiectele mele regionale",
            route: route("admin.ong.regional.projects"),
            subMenu: [
                {
                    name: "published_projects",
                    route: route("admin.ong.regional.projects", {
                        project_status: "published",
                    }),
                    icon: FolderOpenIcon,
                },
                {
                    name: "draft_projects",
                    route: route("admin.ong.regional.projects", {
                        project_status: "draft",
                    }),
                    icon: FolderMinusIcon,
                },
            ],
            icon: FolderIcon,
        },
        {
            name: "Voluntari",
            route: route("admin.ong.volunteers"),
            subMenu: [
                {
                    name: "volunteers_approved",
                    route: route("admin.ong.volunteers", { status: "approved" }),
                    icon: UserGroupIcon,
                },
                {
                    name: "volunteers_pending",
                    route: route("admin.ong.volunteers", { status: "pending" }),
                    icon: UserPlusIcon,
                },
                {
                    name: "volunteers_rejected",
                    route: route("admin.ong.volunteers", { status: "rejected" }),
                    icon: UserMinusIcon,
                },
            ],
            icon: UsersIcon,
        },
        {
            name: "Donații",
            route: route("admin.ong.donations"),
            icon: CalendarIcon,
        },
        {
            name: "Tickets",
            route: route("admin.ong.tickets.index", { status: "open" }),
            icon: DocumentDuplicateIcon,
        },
    ];

    /**
     * Determines if a navigation item should be active based on the current route.
     *
     * @param {Object} item The navigation item to check.
     *
     * @returns {Boolean} Whether or not the navigation item should be active.
     */
    const isActive = (item) => {
        if (
            item.route ===
            `${window.location.origin}${window.location.pathname}${window.location.search}`
        ) {
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
