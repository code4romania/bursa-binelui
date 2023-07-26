<template>
    <PageLayout>
        <Head title="Profile" />
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="px-6 mx-auto space-y-6 max-w-7xl lg:px-12">

            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />

            <div class="w-full my-4 border-t border-gray-300"></div>

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
