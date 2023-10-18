<template>
    <PageLayout>
        <Head title="Profile" />
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <div class="container">
            <div class="flex justify-center">
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="w-1/2"
            />
            </div>

            <div class="w-full my-4 border-t border-gray-300"></div>

            <div class="flex justify-center">

                <UpdatePasswordForm class="w-1/2" />
            </div>
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
