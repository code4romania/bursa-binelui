<template>
    <Disclosure as="nav" class="relative bg-white shadow z-103" v-slot="{ open }">
        <div class="px-4 mx-auto max-w-7xl xl:px-0 lg:py-2">
            <div class="flex justify-between h-16">

                <!-- Logo -->
                <Link href="/" class="flex items-center flex-shrink-0">
                    <img class="block w-auto h-10 lg:h-full" src="/images/bursa_binelui_logo.png" />
                </Link>

                <!-- Desktop main links -->
                <div class="hidden lg:ml-6 lg:flex lg:items-center sm:space-x-4 xl:space-x-8">

                    <!-- Explore menu -->
                    <FlyoutMenu
                        :name="$t('explore_navbar_menu')"
                        :links="explore"
                    />

                    <!-- Articles link -->
                    <NavLink
                        :href="route('articles')"
                        :active="route().current('articles')"
                    >
                        {{ $t('articles_link') }}
                    </NavLink>

                    <!-- About menu -->
                    <FlyoutMenu
                        :name="$t('about_navbar_menu')"
                        :links="about"
                    />

                    <!-- Contact link -->
                    <NavLink
                        :href="route('contact')"
                        :active="route().current('contact')"
                    >
                        {{ $t('contact_link') }}
                    </NavLink>
                </div>

                <!-- Desktop account links. -->
                <div class="hidden lg:ml-6 lg:flex lg:items-center lg:space-x-4">

                    <!-- Login link -->
                    <NavLink
                        v-if="!$page.props.auth.user"
                        :href="route('dashboard')"
                        :active="route().current('login')"
                    >
                        {{ $t('login_link') }}
                    </NavLink>

                    <!-- Register link -->
                    <Link
                        v-if="!$page.props.auth.user"
                        :href="route('register')"
                        class="relative inline-flex items-center gap-x-1.5 rounded-md bg-primary-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-500"
                    >
                        {{ $t('register_link') }}
                    </Link>

                    <!-- Notification icon -->
                    <button
                        v-if="$page.props.auth.user"
                        type="button"
                        class="p-1 text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <BellIcon class="w-6 h-6" aria-hidden="true" />
                    </button>

                    <!-- User links -->
                    <Menu
                        v-if="$page.props.auth.user"
                        as="div"
                        class="relative ml-3"
                    >


                        <MenuButton class="flex items-center gap-4 text-sm bg-white rounded-full focus:outline-none">
                            {{ $page.props.auth.user.name }}
                            <img
                                v-if="$page.props.auth.user.avatar"
                                class="w-8 h-8 rounded-full"
                                :src="$page.props.auth.user.avatar"
                                alt="avatar"
                            />
                            <SvgLoader class="shrink-0" name="default_avatar" />
                        </MenuButton>


                        <transition enter-active-class="transition duration-200 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
                            <MenuItems class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <!-- Administrate Link -->
                                <NavLink
                                    class="w-full px-3 py-2"
                                    :href="'donor' === $page.props.auth.user.role ? route('donor.index') : route('dashboard')"
                                    :active="'donor' === $page.props.auth.user.role ? route().current('donor.index') : route().current('dashboard')"
                                >
                                    {{ 'donor' === $page.props.auth.user.role ? $t('dashbord') : $t('administrate_link') }}
                                </NavLink>

                                <NavLink
                                    v-if="$page.props.auth.user && 'donor' === $page.props.auth.user.role"
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
                                <NavLink
                                    class="w-full px-3 py-2"
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    {{ $t('log_out_link') }}
                                </NavLink>
                            </MenuItems>
                        </transition>
                    </Menu>

                    <SelectNoBorder
                        :options="languages"
                    />
                </div>

                <div class="flex items-center -mr-2 lg:hidden">
                    <!-- Mobile menu button -->
                    <DisclosureButton class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                        <Bars3Icon v-if="!open" class="block w-6 h-6" aria-hidden="true" />
                        <XMarkIcon v-else class="block w-6 h-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
            </div>
        </div>

        <!-- Mobile links -->
        <DisclosurePanel class="lg:hidden">

            <div class="">

                <!-- Explore mobile link -->
                <FlyoutMenu
                    :name="$t('explore_navbar_menu')"
                    :links="explore"
                />

                <!-- Articles link -->
                <Link
                    :class="['p-3 flex items-center text-base font-medium leading-5', route().current('articles') ? 'text-primary-500 bg-primary-50' : 'text-gray-500']"
                    :href="route('articles')"
                >
                    {{ $t('articles_link') }}
                </Link>

                <!-- About menu -->
                <FlyoutMenu
                    :name="$t('about_navbar_menu')"
                    :links="about"
                />

                <!-- Contact link -->
                <Link
                    :class="['p-3 flex items-center text-base font-medium leading-5', route().current('contact') ? 'text-primary-500 bg-primary-50' : 'text-gray-500']"
                    :href="route('contact')"
                >
                    {{ $t('contact_link') }}
                </Link>
            </div>

            <div class="pt-4 pb-3 border-t border-gray-200">

                <div v-if="$page.props.auth.user" class="flex items-center px-4">

                    <div class="flex items-center gap-4">
                        <p class="text-base font-medium text-gray-500">{{ $page.props.auth.user.name }}</p>
                        <img
                            v-if="$page.props.auth.user.avatar"
                            class="w-8 h-8 rounded-full"
                            :src="$page.props.auth.user.avatar"
                            alt="avatar"
                        />
                        <SvgLoader class="w-8 h-8 shrink-0 object-fit" name="default_avatar" />
                    </div>

                    <button type="button" class="flex-shrink-0 p-1 ml-auto text-gray-400 bg-white rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        <span class="sr-only">View notifications</span>
                        <BellIcon class="w-6 h-6" aria-hidden="true" />
                    </button>
                </div>

                <div class="mt-3 space-y-1">
                     <!-- Administrate Link -->
                     <NavLink
                        v-if="$page.props.auth.user"
                        class="w-full px-3 py-2"
                        :href="'donor' === $page.props.auth.user.role ? route('donor.index') : route('dashboard')"
                        :active="'donor' === $page.props.auth.user.role ? route().current('donor.index') : route().current('dashboard')"
                    >
                        {{ 'donor' === $page.props.auth.user.role ? $t('dashbord') : $t('administrate_link') }}
                    </NavLink>

                    <NavLink
                        v-if="$page.props.auth.user && 'donor' === $page.props.auth.user.role"
                        class="w-full px-3 py-2"
                        :href="route('donor.donations')"
                        :active="route().current('donor.donations')"
                    >
                        {{ $t('my_donations') }}
                    </NavLink>

                    <!-- Account settings -->
                    <NavLink
                        v-if="$page.props.auth.user"
                        class="w-full px-3 py-2"
                        :href="route('profile.edit')"
                        :active="route().current('profile.edit')"
                    >
                        {{ $t('account_settings') }}
                    </NavLink>

                    <!-- Log out -->
                    <NavLink
                        v-if="$page.props.auth.user"
                        class="w-full px-3 py-2"
                        :href="route('logout')"
                        method="post"
                        as="button"
                    >
                        {{ $t('log_out_link') }}
                    </NavLink>

                    <NavLink
                        class="w-full px-3 py-2"
                        v-if="!$page.props.auth.user"
                        :href="route('login')"
                        :active="route().current('login')"
                    >
                        {{ $t('login_link') }}
                    </NavLink>

                    <NavLink
                        class="w-full px-3 py-2"
                        v-if="!$page.props.auth.user"
                        :href="route('register')"
                        :active="route().current('register')"
                    >
                        {{ $t('register_link') }}
                    </NavLink>

                    <SelectNoBorder
                        class="py-2"
                        :options="languages"
                    />
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
    import SvgLoader from './SvgLoader.vue';

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
            href: 'bcr.projects'
        },
        {
            name: 'Campionatul de Bine',
            description: 'O competiție a faptelor bune. Alătură-te!',
            href: 'championship'
        },
        {
            name: 'Gale Regionale',
            description: 'Proiectele cu cel mai mare impact, pe regiuni. Vezi participanții!',
            href: 'regional'
        }
    ];

    /** About menu links. */
    const about = [
        {
            name: 'Despre Bursa Binelui',
            description: 'Află mai multe despre inițiativa noastră și cum poți să te alături, atât ca organizație, cât și ca donator sau voluntar.',
            href: 'about'
        },
        {
            name: 'Evolutia faptelor bune',
            description: 'Vezi evoluția faptelor bune pe Bursa Binelui în timp, cu ajutorul unor grafice.',
            href: 'evolution'
        },
        {
            name: 'Întrebări frecvente',
            description: 'Ai o neclaritate? Găsește răspunsul aici.',
            href: 'faqs'
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
