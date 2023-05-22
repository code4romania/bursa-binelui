<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('contact')" />

        <div class="my-14 relative">
            <div class="flex flex-col sm:flex-row gap-20 mx-auto max-w-5xl">

                <div class="w-full sm:w-6/12 space-y-4">
                    <h1 class="text-cyan-900 text-3xl font-bold">{{ $t('send_message') }}</h1>
                    <p class="text-gray-500 font-medium text-sm">{{ $t('send_message_info') }}</p>

                    <form @submit.prevent="contact" class="mt-2 space-y-6 pb-20">
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
                            :label="$t('project_name_label')"
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
                            background="turqoise-500"
                            hover="turqoise-400"
                            color="white"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ $t('send') }}
                        </PrimaryButton>

                    </form>
                </div>

                <div class="w-full sm:w-6/12 space-y-4">
                    <h1 class="text-cyan-900 text-3xl font-bold">{{ $t('contact') }}</h1>
                    <p class="text-gray-500 font-medium text-sm">{{ $t('contact_info') }}</p>

                    <a href="mail:to" class="flex items-center gap-2 py-6 text-sm text-gray-500">
                        <SvgLoader class="shrink-0" name="email" />
                        support@example.com
                    </a>

                    <div class="space-y-2">
                        <p class="text-base text-turqoise-500 font-semibold">Los Angeles</p>
                        <p class="text-gray-500 font-medium text-sm">4556 Brendan Ferry</p>
                        <p class="text-gray-500 font-medium text-sm">Los Angeles, CA 90210</p>
                    </div>
                </div>
            </div>

            <div class="hidden lg:block absolute bottom-0 left-0">
                <SvgLoader class="shrink-0" name="pattern" />
            </div>

            <div class="hidden lg:block absolute top-0 right-0">
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
        // form.post(route('route'), {
        //     onFinish: () => form.reset('password'),
        // });
    };
</script>
