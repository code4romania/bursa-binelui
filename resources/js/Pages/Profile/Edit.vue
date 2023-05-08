<template>
    <PageLayout>
        <Head title="Profile" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-12 space-y-6">

            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />

            <div class="w-full border-t border-gray-300 my-4"></div>

            <UpdatePasswordForm class="max-w-xl" />

        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
    import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

    /** Component props. */
    defineProps({
        mustVerifyEmail: { type: Boolean },
        status: { type: String },
    });
</script>
