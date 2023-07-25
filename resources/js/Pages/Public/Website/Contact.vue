<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('contact')" />

        <div class="relative px-6 my-14 lg:px-0">
            <div class="flex flex-col max-w-5xl gap-20 mx-auto sm:flex-row">

                <div class="w-full space-y-4 sm:w-6/12">
                    <h1 class="text-3xl font-bold text-cyan-900">{{ $t('send_message') }}</h1>
                    <p class="text-sm font-medium text-gray-500">{{ $t('send_message_info') }}</p>

                    <form @submit.prevent="contact" class="pb-20 mt-2 space-y-6">
                        <!-- Name -->
                        <Input
                            class="w-full"
                            :label="$t('name_last_name')"
                            color="gray-700"
                            id="name"
                            type="text"
                            v-model="form.name"
                            :error="form.errors.name"
                        />

                        <!-- Email -->
                        <Input
                            class="w-full"
                            :label="$t('email')"
                            color="gray-700"
                            id="email"
                            type="email"
                            v-model="form.email"
                            :error="form.errors.email"
                        />

                        <!-- Mesaj -->
                        <Textarea
                            class="w-full"
                            :label="$t('message_label')"
                            id="text"
                            color="gray-700"
                            v-model="form.text"
                            :error="form.errors.text"
                        />

                        <PrimaryButton
                            background="primary-500"
                            hover="primary-400"
                            color="white"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ $t('send') }}
                        </PrimaryButton>

                    </form>
                </div>

                <div class="w-full space-y-4 sm:w-6/12">
                    <h1 class="text-3xl font-bold text-cyan-900">{{ $t('contact') }}</h1>
                    <p class="text-sm font-medium text-gray-500">{{ $t('contact_info') }}</p>

                    <a href="mail:to=support@example.com" class="flex items-center gap-2 py-6 text-sm text-gray-500">
                        <SvgLoader class="shrink-0" name="email" />
                        support@example.com
                    </a>

                    <div class="space-y-2">
                        <p class="text-base font-semibold text-primary-500">Los Angeles</p>
                        <p class="text-sm font-medium text-gray-500">4556 Brendan Ferry</p>
                        <p class="text-sm font-medium text-gray-500">Los Angeles, CA 90210</p>
                    </div>
                </div>
            </div>

            <div class="absolute bottom-0 left-0 hidden lg:block">
                <SvgLoader class="shrink-0" name="pattern" />
            </div>

            <div class="absolute top-0 right-0 hidden lg:block">
                <SvgLoader class="shrink-0" name="pattern" />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Input from '@/Components/form/Input.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const form = useForm({
        name: '',
        email: '',
        text: ''
    })

    /** Submit action. */
    const contact = () => {
        // form.post(route('route'), {});
    };
</script>
