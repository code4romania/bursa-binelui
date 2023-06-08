<template>
    <div class="space-y-6">

        <h1 v-if="'ong' == form.type" class="text-2xl font-bold text-cyan-900">{{ $t('account_details') }}</h1>

        <!-- Name -->
        <Input
            :label="'ong' == form.type ? $t('name_last_name_ong') : $t('name_last_name')"
            id="name"
            type="text"
            v-model="form.name"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="name"
            :error="form.errors.name"
        />

        <!-- Email -->
        <Input
            :label="$t('email')"
            id="email"
            type="email"
            v-model="form.email"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="email"
            :error="form.errors.email"
        />

        <!-- Name -->
        <Input
            :label="$t('password')"
            id="password"
            type="password"
            v-model="form.password"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="password"
            :error="form.errors.password"
        />

        <div v-if="'ong' == form.type" class="flex items-center justify-between mt-6 gap-x-4">
            <PrimaryButton
                background="white"
                hover="white"
                color="gray-900"
                @click="$emit('prev', $event.target)"
            >
                {{ $t('back') }}
            </PrimaryButton>

            <PrimaryButton
                class="mt-6"
                background="turqoise-500"
                hover="turqoise-400"
                color="white"
                type="button"
                @click="$emit('next', $event.target)"
            >
                {{ $t('continue') }}
            </PrimaryButton>
        </div>

        <div v-if="'donor' == form.type" :class="['flex items-center gap-x-4 justify-between mt-6']">
            <PrimaryButton
                class="flex-1"
                background="turqoise-500"
                hover="turqoise-400"
                color="white"
                @click="$emit('next', $event.target)"
            >
                {{ 'Step1' == current.__name ? $t('continue') : $t('register_link') }}
            </PrimaryButton>

            <SecondaryButton
                class="flex items-center flex-1 gap-x-2 py-2.5"
                @click="$emit('google', $event.target)"
            >
                <SvgLoader name="google" />
                {{ $t("google_login") }}
            </SecondaryButton>
        </div>
    </div>
</template>

<script setup>
    /** Import components. */
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';

    const props = defineProps({
        form: Object,
        current: Object
    });
</script>
