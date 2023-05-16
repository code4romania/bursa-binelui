<template>
    <Disclosure as="nav" class="bg-white shadow" v-slot="{ open }">
        <div class="mx-auto max-w-7xl px-4 xl:px-0 lg:py-2">
            <div class="flex h-16 justify-between">

                <!-- Logo -->
                <Link href="/" class="flex flex-shrink-0 items-center">
                    <img class="block h-10 lg:h-full w-auto" src="/images/bursa_binelui_logo.png" />
                </Link>

                <!-- Desktop main links -->
                <div class="hidden lg:ml-6 lg:flex lg:items-center sm:space-x-4 xl:space-x-8">

                    <FlyoutMenu
                        name="Explorează"
                        :links="explore"
                    />

                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('/')"
                    >
                        Articole
                    </NavLink>

                    <FlyoutMenu
                        name="Despre"
                        :links="about"
                    />

                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                    >
                        Contact
                    </NavLink>
                </div>

                <!-- Desktop account links. -->
                <div class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">

                    <NavLink
                        v-if="!$page.props.auth.user" :href="route('dashboard')"
                        :active="route().current('login')"
                    >
                        Intră în cont
                    </NavLink>

                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('register')"
                        class="relative inline-flex items-center gap-x-1.5 rounded-md bg-turqoise-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-turqoise-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-turqoise-500"
                    >
                        Creează cont
                    </Link>

                    <button
                        v-if="$page.props.auth.user"
                        type="button"
                        class="rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                    </button>

                    <!-- Profile dropdown -->
                    <Menu v-if="$page.props.auth.user" as="div" class="relative ml-3">

                        <div>
                            <MenuButton class="flex space-x-4 items-center rounded-full bg-white text-sm focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                {{ $page.props.auth.user.name }}
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                            </MenuButton>
                        </div>

                        <transition enter-active-class="transition ease-out duration-200" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <NavLink
                                    class="py-2 px-3 w-full"
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Administrează
                                </NavLink>

                                <NavLink
                                    class="py-2 px-3 w-full"
                                    :href="route('profile.edit')"
                                    :active="route().current('profile.edit')"
                                >
                                    Setări cont
                                </NavLink>

                                <NavLink
                                    class="py-2 px-3 w-full"
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log out
                                </NavLink>
                            </MenuItems>
                        </transition>
                    </Menu>

                    <SelectNoBorder
                        :options="languages"
                    />
                </div>

                <div class="-mr-2 flex items-center lg:hidden">
                    <!-- Mobile menu button -->
                    <DisclosureButton class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open main menu</span>
                        <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
            </div>
        </div>

        <!-- Mobile links -->
        <DisclosurePanel class="lg:hidden">

            <div class="space-y-1 pb-3 pt-2 space-x-4">
                <FlyoutMenu name="Explorează" :links="explore" />

                <NavLink :href="route('dashboard')" :active="route().current('/')">
                    Articole
                </NavLink>

                <FlyoutMenu name="Despre" :links="about" />

                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                    Contact
                </NavLink>
            </div>

            <div class="border-t border-gray-200 pb-3 pt-4">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800">Tom Cook</div>
                        <div class="text-sm font-medium text-gray-500">tom@example.com</div>
                    </div>
                    <button type="button" class="ml-auto flex-shrink-0 rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>

                <div class="mt-3 space-y-1">
                    <DisclosureButton as="a" href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Your Profile</DisclosureButton>
                    <DisclosureButton as="a" href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Settings</DisclosureButton>
                    <DisclosureButton as="a" href="#" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Sign out</DisclosureButton>
                </div>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script setup>
    /** Import from inertia. */
    import { Link } from '@inertiajs/vue3';

    /** Import plugins. */
    import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
    import { Bars3Icon, BellIcon, XMarkIcon } from '@heroicons/vue/24/outline';

    /** Import components. */
    import NavLink from '@/Components/links/NavLink.vue';
    import FlyoutMenu from '@/Components/dropdowns/FlyoutMenu.vue';
    import SelectNoBorder from '@/Components/form/SelectNoBorder.vue';

    /** Explore menu links. */
    const explore = [
        {
            name: 'Proiecte',
            description: 'Descoperă proiectele înscrise la Bursa Binelui și susține proiectul pe care îl îndrăgești.',
            href: 'projects'
        },
        {
            name: 'Organizatii',
            description: 'Descoperă toate organizațiile înscrise pe Bursa Binelui și alege cauza pe care vrei să o susții.',
            href: 'organizations'
        },
        {
            name: 'BCR pentru comunitate',
            description: "Descoperă proiectele organizate de BCR.",
            href: 'register'
        },
        {
            name: 'Campionatul de Bine',
            description: 'O competiție a faptelor bune. Alătură-te!',
            href: 'register'
        }
    ];

    /** About menu links. */
    const about = [
        {
            name: 'Proiecte',
            description: 'Descoperă proiectele înscrise la Bursa Binelui și susține proiectul pe care îl îndrăgești.',
            href: 'register'
        },
        {
            name: 'Organizatii',
            description: 'Descoperă toate organizațiile înscrise pe Bursa Binelui și alege cauza pe care vrei să o susții.',
            href: 'register'
        },
        {
            name: 'BCR pentru comunitate',
            description: "Descoperă proiectele organizate de BCR.",
            href: 'register'
        },
        {
            name: 'Campionatul de Bine',
            description: 'O competiție a faptelor bune. Alătură-te!',
            href: 'register'
        }
    ];

    /** Languages menu links. */
    const languages = [
        {
            id: 1,
            name: 'RO',
        },
        {
            id: 2,
            name: 'EN'
        },
    ];
</script>
