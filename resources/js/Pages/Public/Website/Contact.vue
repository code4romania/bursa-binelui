<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('contact')" />

        <div class="relative px-6 my-14 lg:px-0">
            <div class="flex flex-col max-w-5xl gap-20 mx-auto sm:flex-row">
                <div class="w-full space-y-4 sm:w-6/12">
                    <h1 class="text-3xl font-bold text-primary-900">{{ $t('send_message') }}</h1>
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

                        <PrimaryButton type="submit" :disabled="form.processing" :label="$t('send')" />
                    </form>
                </div>

                <div class="w-full space-y-4 sm:w-6/12">
                    <h1 class="text-3xl font-bold text-primary-900">{{ $t('contact') }}</h1>
                    <p class="text-sm font-medium text-gray-500">{{ $t('contact_info') }}</p>

                    <a href="mailto:support@example.com" class="flex items-center gap-2 py-6 text-sm text-gray-500">
                        <MailIcon class="w-6 h-6 fill-primary-500" />
                        support@example.com
                    </a>

                    <div class="space-y-2">
                        <p class="text-base font-semibold text-primary-500">Los Angeles</p>
                        <p class="text-sm font-medium text-gray-500">4556 Brendan Ferry</p>
                        <p class="text-sm font-medium text-gray-500">Los Angeles, CA 90210</p>
                    </div>
                </div>
            </div>

            <LargeSquarePattern class="absolute bottom-0 hidden text-gray-200 -left-32 -ml-1/2 lg:block" />
            <LargeSquarePattern class="absolute top-0 hidden text-gray-200 -right-32 lg:block" />
        </div>
    </PageLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import route from '@/Helpers/useRoute';
    import Head from '@/Components/Head.vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Input from '@/Components/form/Input.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import { MailIcon } from '@heroicons/vue/solid';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    const form = useForm({
        name: '',
        email: '',
        text: '',
    });

    /** Submit action. */
    const contact = () => {
        // form.post(route('route'), {});
    };
</script>
