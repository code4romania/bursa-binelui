<template>
    <div class="space-y-6">
        <h1
            v-if="'organization' === form.type"
            class="text-2xl font-bold text-cyan-900"
            v-text="$t('account_details')"
        />

        <!-- Name -->
        <Input
            :label="'organization' === form.type ? $t('name_last_name_ong') : $t('name_last_name')"
            id="name"
            type="text"
            v-model="form.user.name"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="name"
            :error="form.errors['user.name']"
        />

        <!-- Email -->
        <Input
            :label="$t('email')"
            id="email"
            type="email"
            v-model="form.user.email"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="email"
            :error="form.errors['user.email']"
        />

        <Input
            :label="$t('password')"
            id="password"
            type="password"
            v-model="form.user.password"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="password"
            :error="form.errors['user.password']"
        />

        <Input
            :label="$t('password_confirmation')"
            id="password_confirmation"
            type="password"
            v-model="form.user.password_confirmation"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="password"
            :error="form.errors['user.password_confirmation']"
        />

        <!-- Terms -->
        <label v-if="'user' === form.type" class="flex items-center space-x-2">
            <Checkbox name="terms" v-model:checked="form.terms" />
            <div class="flex items-center space-x-2 text-sm">
                <span class="text-gray-700">{{ $t('i_agree') }}</span>
                <Link :href="route('terms')" class="text-primary-500">
                    {{ $t('terms_link') }}
                </Link>
                <span class="text-red-500">*</span>
            </div>
        </label>

        <!-- Subscribe -->
        <label v-if="'user' === form.type" class="flex items-center space-x-2">
            <Checkbox name="subscribe" v-model:checked="form.subscribe" />
            <span class="text-sm text-gray-700">{{ $t('register_subscribe') }}</span>
        </label>

        <div v-if="'organization' === form.type" class="flex items-center justify-between mt-6 gap-x-4">
            <SecondaryButton @click="$emit('prev', $event.target)">
                {{ $t('back') }}
            </SecondaryButton>

            <PrimaryButton @click="$emit('next', $event.target)" :label="$t('continue')" />
        </div>

        <div
            v-if="'user' === form.type"
            :class="['flex flex-col md:flex-row items-center gap-4 justify-between mt-6']"
        >
            <PrimaryButton class="flex-1 w-full" @click="$emit('next', $event.target)" :label="$t('register_link')" />

            <SecondaryButton
                class="w-full flex items-center justify-center flex-1 gap-x-2 py-2.5"
                @click="$emit('google', $event.target)"
            >
                <SvgLoader name="google" />
                {{ $t('google_login') }}
            </SecondaryButton>
        </div>
    </div>
</template>

<script setup>
    import { Link } from '@inertiajs/vue3';
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';

    const props = defineProps({
        form: Object,
    });
</script>
