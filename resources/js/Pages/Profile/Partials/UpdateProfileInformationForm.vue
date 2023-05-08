<template>
    <section>

        <header class="mt-12 flex items-center gap-4">
            <SvgLoader name="list"/>
            <h2 class="text-2xl font-bold text-gray-900">Setări cont</h2>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-11 space-y-6">

            <!-- Name -->
            <Input
                label="Nume și prenume"
                id="name"
                type="text"
                v-model="form.name"
                :isRequired="true"
                :error="form.errors.name"
            />

            <!-- Email -->
            <Input
                label="Email"
                id="email"
                type="email"
                v-model="form.email"
                :isRequired="true"
                :error="form.errors.email"
            />

            <!-- Phone -->
            <Input
                label="Telefon"
                id="phone"
                type="number"
                v-model="form.phone"
                :isRequired="true"
                :error="form.errors.phone"
            >
                <p class="text-gray-500 text-sm pt-1">*Numarul de telefon nu va fi facut public.</p>
            </Input>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <!-- Actions -->
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
    /** Import from inertia. */
    import { Link, useForm, usePage } from '@inertiajs/vue3';

    /** Import components. */
    import Input from '@/Components/form/Input.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

    /** Component props. */
    defineProps({
        mustVerifyEmail: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    });

    /** Get user. */
    const user = usePage().props.auth.user;

    /** Form variables. */
    const form = useForm({
        name: user.name,
        email: user.email,
    });
</script>
