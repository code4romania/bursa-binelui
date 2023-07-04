<template>
    <section>
        <header>
            <h2 class="mt-8 text-2xl font-bold text-gray-900">{{ $t('change_password') }}</h2>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 mb-16 space-y-6">

            <!-- Current password. -->
            <Input
                :label="$t('current_password')"
                id="current_password"
                ref="currentPasswordInput"
                type="password"
                v-model="form.current_password"
                :error="form.errors.current_password"
            />

            <!-- New password. -->
            <Input
                :label="$t('new_password')"
                id="new_password"
                ref="passwordInput"
                type="password"
                v-model="form.password"
                :error="form.errors.password"
            />

            <!-- Confirm password. -->
            <Input
                :label="$t('retype_password')"
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                :error="form.errors.password_confirmation"
            />

            <!-- Actions. -->
            <div class="flex items-center justify-end gap-4">

                <!-- Cancel button -->
                <SecondaryButton
                    class="py-2.5"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('cancel') }}
                </SecondaryButton>

                <!-- Save button -->
                <PrimaryButton
                    background="primary-500"
                    hover="primary-400"
                    color="white"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t('save') }}
                </PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">{{ $t('saved') }}</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<script setup>
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import form inertia. */
    import { useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Input from '@/Components/form/Input.vue';

    /** Componet variables. */
    const passwordInput = ref(null);
    const currentPasswordInput = ref(null);

    /** Form variables. */
    const form = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    /** Update pasword method. */
    const updatePassword = () => {
        form.put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.password) {
                    form.reset('password', 'password_confirmation');
                    passwordInput.value.focus();
                }
                if (form.errors.current_password) {
                    form.reset('current_password');
                    currentPasswordInput.value.focus();
                }
            },
        });
    };
</script>
