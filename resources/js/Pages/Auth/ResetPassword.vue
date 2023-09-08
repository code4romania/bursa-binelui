<template>
    <AuthLayout :title="$t('password_reset')">
        <form class="mt-4 space-y-6 lg:mb-28" @submit.prevent="submit">
            <!-- Password -->
            <Input
                :label="$t('password')"
                id="password"
                type="password"
                v-model="form.password"
                :isRequired="true"
                :error="form.errors.password"
            />

            <!-- Confirm password -->
            <Input
                :label="$t('password_confirmation')"
                id="password-confirmation"
                type="password"
                v-model="form.password_confirmation"
                :isRequired="true"
                :error="form.errors.password_confirmation"
            />

            <!-- Action -->
            <div class="grid grid-cols-1">
                <PrimaryButton
                    background="primary-500"
                    hover="primary-400"
                    color="white"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('save') }}
                </PrimaryButton>
            </div>
        </form>
    </AuthLayout>
</template>

<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Input from '@/Components/form/Input.vue';

    /** Component props. */
    const props = defineProps({
        token: {
            type: String,
            default: null,
        },
        email: {
            type: String,
            default: null,
        },
    });

    /** Form variables. */
    const form = useForm({
        email: props.email,
        password: '',
        password_confirmation: '',
        token: props.token,
    });

    /** Submit action. */
    const submit = () => {
        form.post(route('password.store'));
    };
</script>
