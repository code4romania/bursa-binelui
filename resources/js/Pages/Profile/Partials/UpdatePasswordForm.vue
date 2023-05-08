<template>
    <section>
        <header>
            <h2 class="text-2xl mt-8 font-bold text-gray-900">Schimbă parola</h2>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6 mb-16">

            <!-- Current password. -->
            <Input
                label="Parola curentă"
                id="current_password"
                ref="currentPasswordInput"
                type="password"
                v-model="form.current_password"
                :error="form.errors.current_password"
            />

            <!-- New password. -->
            <Input
                label="Parola nouă"
                id="new_password"
                ref="passwordInput"
                type="password"
                v-model="form.password"
                :error="form.errors.password"
            />

            <!-- Confirm password. -->
            <Input
                label="Reintroduceți parola nouă"
                id="password_confirmation"
                type="password"
                v-model="form.password_confirmation"
                :error="form.errors.password_confirmation"
            />

            <!-- Actions. -->
            <div class="flex items-center justify-end gap-4">

                <!-- Cancel button -->
                <SecondaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Anulează
                </SecondaryButton>

                <!-- Save button -->
                <PrimaryButton
                    background="turqoise-500"
                    hover="turqoise-400"
                    color="white"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Salvează
                </PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
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
