<template>
    <div class="space-y-6">
        <h1
            v-if="'organization' === form.type"
            class="text-2xl font-bold text-primary-900"
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
        <div class="mt-6">
            <label class="flex items-center space-x-2">
                <Checkbox name="terms" v-model:checked="form.terms" required />
                <div class="flex items-center space-x-1 text-sm">
                    <span class="text-gray-700">{{ $t('i_agree') }}</span>
                    <Link :href="route('terms')" target="_blank" class="text-primary-500"> {{ $t('terms_link') }} </Link
                    >.
                </div>
            </label>

            <p v-show="form.errors.terms" class="mb-2 text-sm text-red-600" v-text="form.errors.terms" />
        </div>

        <!-- Subscribe -->
        <label class="flex items-center space-x-2">
            <Checkbox name="subscribe" v-model:checked="form.subscribe" required />
            <span class="text-sm text-gray-700">{{ $t('register_subscribe') }}</span>
        </label>

        <div v-if="'organization' === form.type" class="flex items-center justify-between mt-6 gap-x-4">
            <SecondaryButton @click="$emit('prev', $event.target)">
                {{ $t('back') }}
            </SecondaryButton>

            <PrimaryButton @click="$emit('next', $event.target)" :label="$t('continue')" />
        </div>

        <div v-if="'user' === form.type" :class="['flex flex-col md:flex-row items-center gap-4 justify-between mt-6']">
            <PrimaryButton class="flex-1 w-full" @click="$emit('next', $event.target)" :label="$t('register_link')" />
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import Input from '@/Components/form/Input.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import Checkbox from '@/Components/form/Checkbox.vue';

const props = defineProps({
    form: Object,
});
</script>
