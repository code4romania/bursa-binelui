<template>
    <footer class="bg-gray-800" aria-labelledby="footer-heading">

        <!-- Alert -->
        <Alert
            class="fixed right-10 top-10 w-96 z-50"
            :type="flash.error_message ? 'error' : flash.success_message ? 'success' : false"
            :message="flash.success_message || flash.error_message"
            @emptyFlash="Object.assign(flash, { success_message:'', error_message:'' });"
        />

        <!-- Code4 info -->
        <div class="bg-gray-100">
            <div class="mx-auto container max-w-7xl flex items-center gap-x-6 px-6 py-4 sm:pr-3.5 lg:pl-8">
                <SvgLoader name="code4_logo"/>
                <div class="flex flex-col md:flex-row text-sm font-semibold leading-5 gap-1">
                    <p class="text-gray-700">{{ $t('code4_solution') }}</p>
                    <a class="text-blue-500" href="https://code4.ro/ro">{{ $t('find_more') }}</a>
                </div>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6 pb-8 lg:px-8 mt-10 lg:mt-16">
            <div class="xl:grid xl:grid-cols-3 xl:gap-8">
                <div class="grid grid-cols-2 gap-8 xl:col-span-2">

                    <div class="md:grid md:grid-cols-2 md:gap-4">

                        <div>
                            <h3 class="text-sm font-semibold leading-5 text-gray-400">{{ $t('util_links') }}</h3>
                            <ul role="list" class="mt-6 space-y-4">
                                <li>
                                    <Link
                                        :href="route('about')"
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
                    <h3 class="text-sm font-semibold leading-5 text-gray-400">{{ $t('news_letter_subscribe_title') }}</h3>
                    <p class="mt-4 text-sm leading-6 text-gray-400">{{ $t('news_letter_subscribe_text') }}</p>

                    <form
                        class="mt-6 sm:flex items-center sm:max-w-md"
                        @submit.prevent="subscribe"
                    >
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

            <div class="border-t border-white/10 pt-8 md:flex md:items-center md:justify-between mt-10 lg:mt-16">
                <div class="flex space-x-6 md:order-2">
                    <a href="#">
                        <SvgLoader name="facebook"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="instagram"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="twitter"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="github"/>
                    </a>

                    <a href="#">
                        <SvgLoader name="drible"/>
                    </a>
                </div>
                <p class="mt-8 text-sm leading-5 text-gray-400 md:order-1 md:mt-0">&copy; {{ currentYear }} {{ $t('footer_info') }}</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
    /** Import from inertia. */
    import { Link, useForm } from '@inertiajs/vue3';

    /** Import componets. */
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Alert from './Alert.vue';

    const flash = {
        success_message:'',
        error_message:''
    }

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
