<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('set_password')" />

        <!-- Auth template. -->
        <Auth :content="content">
            <Alert v-if="status" type="success" :message="status" />

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
        </Auth>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Auth from '@/Components/templates/Auth.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Input from '@/Components/form/Input.vue';
    import Alert from '@/Components/Alert.vue';

    /** Component props. */
    const props = defineProps({
        user: {
            type: Object,
            required: true,
        },
        token: {
            type: String,
            required: true,
        },
    });

    /** Page content. */
    const content = {
        title: 'Setează parola',
        description: 'Setează parola',
    };

    /** Form variables. */
    const form = useForm({
        user: props.user.id,
        token: props.token,
        password: '',
        password_confirmation: '',
    });

    /** Submit action. */
    const submit = () => {
        form.post(route('ngo.user.welcome.store', props.user.id), {});
    };
</script>
