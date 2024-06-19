<template>
    <footer class="bg-gray-800">
        <div class="bg-gray-100">
            <div class="container py-4">
                <a
                    href="https://code4.ro"
                    target="_blank"
                    rel="noopener"
                    class="flex items-center w-full max-w-2xl gap-3 text-sm hover:text-blue-600 focus:text-blue-600 focus:outline-0 hover:underline focus:underline"
                >
                    <Icon name="code4romania" class="w-20 h-6 sm:h-8 md:h-10 shrink-0 sm:w-28 md:w-36" />

                    <span v-text="$t('code4_solution')" />
                </a>
            </div>
        </div>

        <div class="px-6 pb-8 mx-auto mt-10 max-w-7xl lg:px-8 lg:mt-16">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="grid grid-cols-2 gap-8 xl:col-span-2">
                    <div class="md:grid md:grid-cols-2 md:gap-4">
                        <div>
                            <h3 class="text-sm font-semibold leading-5 text-gray-400">{{ $t('util_links') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <Link
                                        :href="route('page', { slug: 'about' })"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('about_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('page', { slug: 'terms' })"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                        v-text="$t('terms_link')"
                                    />
                                </li>
                                <li>
                                    <Link
                                        :href="route('page', { slug: 'policy' })"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                        v-text="$t('policy_link')"
                                    />
                                </li>
                                <li>
                                    <Link
                                        :href="route('contact')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                        v-text="$t('contact_link')"
                                    />
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="md:grid md:grid-cols-2 md:gap-4">
                        <div>
                            <h3 class="text-sm font-semibold leading-5 text-gray-400" v-text="$t('navigate')" />
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <Link
                                        :href="route('login')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                        v-text="$t('register_ong_link')"
                                    />
                                </li>
                                <li>
                                    <Link
                                        :href="route('register')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('donor_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('organizations.index')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('organizations_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('projects.index')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('projects_link') }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <Newsletter class="mt-10 xl:mt-0" />
            </div>

            <div class="pt-8 mt-10 border-t border-white/10 md:flex md:items-center md:justify-between lg:mt-16">
                <div class="flex gap-6 md:order-2">
                    <a
                        href="https://www.facebook.com/BursaBinelui.ro"
                        class="text-gray-500 hover:text-gray-400"
                        target="_blank"
                    >
                        <Icon name="social/facebook" class="w-6 h-6" />
                    </a>

                    <!--                    <a href="#" class="text-gray-500 hover:text-gray-400">-->
                    <!--                        <Icon name="social/instagram" class="w-6 h-6" />-->
                    <!--                    </a>-->

                    <a
                        href="https://github.com/code4romania/bursa-binelui"
                        class="text-gray-500 hover:text-gray-400"
                        target="_blank"
                    >
                        <Icon name="social/github" class="w-6 h-6" />
                    </a>
                </div>
                <p class="mt-8 text-sm leading-5 text-gray-400 md:order-1 md:mt-0">
                    &copy; {{ currentYear }} {{ $t('footer_info') }}
                </p>
            </div>
        </div>
    </footer>
</template>

<script setup>
    /** Import componets. */
    import Newsletter from '@/Components/FooterNewsletter.vue';
    import Icon from '@/Components/Icon.vue';
    import route from '@/Helpers/useRoute.js';

    /** Get current year. */
    const currentYear = new Date().getFullYear();
</script>
