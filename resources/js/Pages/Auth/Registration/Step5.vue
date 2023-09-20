<template>
    <div class="space-y-6">
        <h1 v-if="'organization' == form.type" class="text-2xl font-bold text-cyan-900">
            {{ $t('register_volunteer') }}
        </h1>

        <p class="text-sm text-gray-700">{{ $t('register_volunteer') }}</p>

        <label class="flex items-center">
            <Checkbox name="confirm" v-model:checked="form.ngo.volunteer" />
            <span class="ml-2 mr-1 text-sm text-gray-700">{{ $t('organization_accepts_volunteers') }}</span>
        </label>
        <p v-show="form.errors['ngo.volunteer']" class="mt-2 text-sm text-red-600">
            {{ form.errors['ngo.volunteer'] }}
        </p>

        <!-- Descriptions -->
        <Textarea
            class="w-full"
            :label="$t('organization_why_volunteer_label')"
            id="organization_why_volunteer_label"
            color="gray-700"
            v-model="form.ngo.why_volunteer"
            :error="form.errors['ngo.why_volunteer']"
        >
            <p class="text-xs font-normal text-gray-500">{{ $t('why_volunteer_info') }}</p>
        </Textarea>

        <div v-if="'organization' == form.type" class="flex items-center justify-between mt-6 gap-x-4">
            <SecondaryButton @click="$emit('prev', $event.target)">
                {{ $t('back') }}
            </SecondaryButton>

            <PrimaryButton @click="$emit('next', $event.target)" :label="$t('finish')" />
        </div>
    </div>
</template>

<script setup>
    import Textarea from '@/Components/form/Textarea.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';

    const props = defineProps({
        form: Object,
    });
</script>
