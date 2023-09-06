<template>
    <footer class="mt-32 bg-gray-800">
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
                                        href="route('page', { slug: 'about' })"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('about_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('terms')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('terms_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('policy')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('policy_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('contact')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('contact_link') }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="md:grid md:grid-cols-2 md:gap-4">
                        <div>
                            <h3 class="text-sm font-semibold leading-5 text-gray-400">{{ $t('navigate') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <Link
                                        :href="route('login')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('register_ong_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('donor')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('donor_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('organizations')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('organizations_link') }}
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        :href="route('projects')"
                                        class="text-sm leading-6 text-gray-400 hover:text-white"
                                    >
                                        {{ $t('projects_link') }}
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-10 xl:mt-0">
                    <h3 class="text-sm font-semibold leading-5 text-gray-400">
                        {{ $t('news_letter_subscribe_title') }}
                    </h3>
                    <p class="mt-4 text-sm leading-6 text-gray-400">{{ $t('news_letter_subscribe_text') }}</p>

                    <form class="items-center mt-6 sm:flex sm:max-w-md" @submit.prevent="subscribe">
                        <Input
                            id="subscribe-email"
                            placeholder="Adresa de email"
                            type="email"
                            color="white"
                            v-model="form.subscriber_email"
                            :error="form.errors.subscriber_email"
                        />

                        <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                            <PrimaryButton
                                background="primary-500"
                                hover="primary-400"
                                color="white"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                {{ $t('subscribe') }}
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>

            <div class="pt-8 mt-10 border-t border-white/10 md:flex md:items-center md:justify-between lg:mt-16">
                <div class="flex gap-6 md:order-2">
                    <a href="#" class="text-gray-500 hover:text-gray-400">
                        <Icon name="social/facebook" class="w-6 h-6" />
                    </a>

                    <a href="#" class="text-gray-500 hover:text-gray-400">
                        <Icon name="social/instagram" class="w-6 h-6" />
                    </a>

                    <a href="#" class="text-gray-500 hover:text-gray-400">
                        <Icon name="social/twitter" class="w-6 h-6" />
                    </a>

                    <a href="#" class="text-gray-500 hover:text-gray-400">
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
    /** Import from inertia. */
    import { useForm } from '@inertiajs/vue3';

    /** Import componets. */
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Icon from '@/Components/Icon.vue';

    /** Form variables. */
    const form = useForm({
        subscriber_email: '',
    });

    /** Subscribe action. */
    const subscribe = () => {
        // form.post(route('need.subscribe.route'), {
        //     onFinish: () => form.reset('subscribe_email'),
        // });
    };

    /** Get current year. */
    const currentYear = new Date().getFullYear();
</script>
