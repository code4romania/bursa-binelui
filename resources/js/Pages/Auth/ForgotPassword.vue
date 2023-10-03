<template>
    <AuthLayout :title="$t('password_reset')">
        <form class="mt-4 space-y-6 lg:mb-28" @submit.prevent="submit">
            <!-- Email -->
            <Input
                :label="$t('email')"
                id="email"
                type="email"
                v-model="form.email"
                :isRequired="true"
                :error="form.errors.email"
            />

            <!-- Action -->
            <div class="grid grid-cols-1">
                <PrimaryButton type="submit" :disabled="form.processing" :label="$t('password_reset')" />
            </div>
        </form>
    </AuthLayout>
</template>

<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Input from '@/Components/form/Input.vue';

    /** Form variables. */
    const form = useForm({
        email: '',
    });

    /** Submit action. */
    const submit = () => {
        form.post(route('password.email'), {
            onFinish: () => form.reset('email'),
        });
    };
</script>
