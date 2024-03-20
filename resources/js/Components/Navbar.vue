<template>
    <Disclosure as="nav" class="relative z-10 bg-white shadow" v-slot="{ open }">
        <div class="container flex items-center justify-between h-16 gap-4 lg:gap-6 lg:my-2">
            <Link href="/" class="shrink-0">
                <Icon class="block max-w-36 max-h-10 text-primary-500" name="logo" />
            </Link>

            <!-- Desktop main links -->
            <div class="hidden lg:flex lg:items-center sm:space-x-4 xl:space-x-8">
                <!-- Explore menu -->
                <FlyoutMenu :name="$t('explore_navbar_menu')" :links="explore" />

                <!-- Articles link -->
                <NavLink :href="route('articles.index')" :active="route().current('articles.index')">
                    {{ $t('articles_link') }}
                </NavLink>

                <!-- About menu -->
                <FlyoutMenu :name="$t('about_navbar_menu')" :links="about" />

                <!-- Contact link -->
                <NavLink :href="route('contact')" :active="route().current('contact')">
                    {{ $t('contact_link') }}
                </NavLink>
            </div>

            <div class="hidden lg:flex lg:items-center lg:space-x-4">
                <!-- Auth -->
                <Menu v-if="$page.props.auth?.user" as="div" class="relative">
                    <MenuButton
                        class="flex items-center text-sm font-medium text-gray-500 bg-white rounded-full gap-x-2 focus:outline-none"
                    >
                        <span v-text="$page.props.auth.user.name" />
                        <UserCircleIcon class="w-8 h-8 text-gray-400" />
                    </MenuButton>

                    <transition
                        enter-active-class="transition duration-200 ease-out"
                        enter-from-class="transform scale-95 opacity-0"
                        enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0"
                    >
                        <MenuItems
                            class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                        >
                            <!-- Administrate Link -->
                            <NavLink
                                class="w-full px-3 py-2 text-base"
                                :href="route('donor.index')"
                                :active="route().current('donor.index')"
                            >
                                {{ $t('dashbord') }}
                            </NavLink>
                            <NavLink
                                v-if="['admin', 'manager'].includes($page.props.auth.user.role)"
                                class="w-full px-3 py-2 text-base"
                                :href="route('dashboard.main')"
                                :active="route().current('dashboard.main')"
                            >
                                {{ $t('administrate_link') }}
                            </NavLink>

                            <NavLink
                                class="w-full px-3 py-2 text-base"
                                :href="route('donor.donations')"
                                :active="route().current('donor.donations')"
                            >
                                {{ $t('my_donations') }}
                            </NavLink>

                            <!-- Account settings -->
                            <NavLink
                                class="w-full px-3 py-2 text-base"
                                :href="route('profile.edit')"
                                :active="route().current('profile.edit')"
                            >
                                {{ $t('account_settings') }}
                            </NavLink>

                            <!-- Log out -->
                            <NavLink
                                class="w-full px-3 py-2 text-base"
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                {{ $t('log_out_link') }}
                            </NavLink>
                        </MenuItems>
                    </transition>
                </Menu>

                <!-- Guest -->
                <template v-else>
                    <!-- Login link -->
                    <NavLink :href="route('login')" :active="route().current('login')">
                        {{ $t('login_link') }}
                    </NavLink>

                    <!-- Register link -->
                    <Link
                        :href="route('register')"
                        class="relative inline-flex items-center gap-x-1.5 rounded-md bg-primary-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500"
                    >
                        {{ $t('register_link') }}
                    </Link>
                </template>

                <LanguageSwitcher />
            </div>

            <DisclosureButton
                class="inline-flex justify-center p-2 -mr-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden"
            >
                <component :is="!open ? MenuIcon : XIcon" class="block w-6 h-6" aria-hidden="true" />
            </DisclosureButton>
        </div>

        <!-- Mobile links -->
        <DisclosurePanel class="lg:hidden">
            <div class="">
                <!-- Explore mobile link -->
                <FlyoutMenu :name="$t('explore_navbar_menu')" :links="explore" />

                <!-- Articles link -->
                <Link
                    :class="[
                        'p-3 flex items-center text-base font-medium leading-5',
                        route().current('articles.index') ? 'text-primary-500 bg-primary-50' : 'text-gray-500',
                    ]"
                    :href="route('articles.index')"
                >
                    {{ $t('articles_link') }}
                </Link>

                <!-- About menu -->
                <FlyoutMenu :name="$t('about_navbar_menu')" :links="about" />

                <!-- Contact link -->
                <Link
                    :class="[
                        'p-3 flex items-center text-base font-medium leading-5',
                        route().current('contact') ? 'text-primary-500 bg-primary-50' : 'text-gray-500',
                    ]"
                    :href="route('contact')"
                >
                    {{ $t('contact_link') }}
                </Link>
            </div>

            <div class="pt-4 pb-3 border-t border-gray-200">
                <div v-if="$page.props.auth.user" class="flex items-center px-4">
                    <div class="flex items-center font-medium text-gray-500 gap-x-2">
                        <UserCircleIcon class="w-8 h-8 text-gray-400" />
                        <span v-text="$page.props.auth.user.name" />
                    </div>
                </div>

                <div v-if="$page.props.auth.user" class="mt-3 space-y-1">
                    <!-- Administrate Link -->
                    <NavLink
                        class="w-full px-3 py-2"
                        :href="route('donor.index')"
                        :active="route().current('donor.index')"
                    >
                        {{ $t('dashbord') }}
                    </NavLink>

                    <NavLink
                        v-if="['admin', 'manager'].includes($page.props.auth.user.role)"
                        class="w-full px-3 py-2"
                        :href="route('dashboard.main')"
                        :active="route().current('dashboard.main')"
                    >
                        {{ $t('administrate_link') }}
                    </NavLink>

                    <NavLink
                        class="w-full px-3 py-2"
                        :href="route('donor.donations')"
                        :active="route().current('donor.donations')"
                    >
                        {{ $t('my_donations') }}
                    </NavLink>

                    <!-- Account settings -->
                    <NavLink
                        class="w-full px-3 py-2"
                        :href="route('profile.edit')"
                        :active="route().current('profile.edit')"
                    >
                        {{ $t('account_settings') }}
                    </NavLink>

                    <!-- Log out -->
                    <NavLink class="w-full px-3 py-2" :href="route('logout')" method="post" as="button">
                        {{ $t('log_out_link') }}
                    </NavLink>
                </div>
                <div v-else class="mt-3 space-y-1">
                    <NavLink class="w-full px-3 py-2" :href="route('login')" :active="route().current('login')">
                        {{ $t('login_link') }}
                    </NavLink>

                    <NavLink class="w-full px-3 py-2" :href="route('register')" :active="route().current('register')">
                        {{ $t('register_link') }}
                    </NavLink>
                </div>

                <LanguageSwitcher class="py-2" />
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import route from '@/Helpers/useRoute';

import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { MenuIcon, XIcon } from '@heroicons/vue/outline';
import { UserCircleIcon } from '@heroicons/vue/solid';
import Icon from '@/Components/Icon.vue';

import NavLink from '@/Components/links/NavLink.vue';
import FlyoutMenu from '@/Components/dropdowns/FlyoutMenu.vue';
import LanguageSwitcher from '@/Components/LanguageSwitcher.vue';

/** Explore menu links. */
const explore = [
    {
        name: 'Proiecte',
        description: 'Descoperă proiectele înscrise la Bursa Binelui și susține proiectul pe care îl îndrăgești.',
        href: route('projects.index'),
    },
    {
        name: 'Organizații',
        description: 'Descoperă toate organizațiile înscrise pe Bursa Binelui și alege cauza pe care vrei să o susții.',
        href: route('organizations.index'),
    },
    {
        name: 'BCR pentru comunitate',
        description: 'Descoperă proiectele organizate de BCR.',
        href: route('bcr.index'),
    },
    {
        name: 'Campionatul de Bine',
        description: 'O competiție a faptelor bune. Alătură-te!',
        href: route('championship'),
    },
    {
        name: 'Gale bursa binelui',
        description: 'Proiectele cu cel mai mare impact, pe regiuni. Vezi participanții!',
        href: route('regional'),
    },
];

/** About menu links. */
const about = [
    {
        name: 'Despre Bursa Binelui',
        description:
            'Află mai multe despre inițiativa noastră și cum poți să te alături, atât ca organizație, cât și ca donator sau voluntar.',
        href: route('page', 'about'),
    },
    {
        name: 'Evolutia faptelor bune',
        description: 'Vezi evoluția faptelor bune pe Bursa Binelui în timp, cu ajutorul unor grafice.',
        href: route('evolution'),
    },
    {
        name: 'Întrebări frecvente',
        description: 'Ai o neclaritate? Găsește răspunsul aici.',
        href: route('page', 'faqs'),
    },
];

const languages = computed(() =>
    usePage().props.locales.available.map((locale) => ({
        name: locale,
        id: locale,
    }))
);
</script>
