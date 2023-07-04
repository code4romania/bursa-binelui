<template>
    <div class="space-y-6">

        <h1 v-if="'ong' == form.type" class="text-2xl font-bold text-cyan-900">{{ $t('register_volunteer') }}</h1>

        <p class="text-sm text-gray-700">{{ $t('register_volunteer') }}</p>

        <label class="flex items-center">
            <Checkbox
                name="confirm"
                v-model:checked="form.ong.volunteer"
            />
            <span class="ml-2 mr-1 text-sm text-gray-700">{{ $t('organization_accepts_volunteers_label') }}</span>
        </label>
        <p v-show="form.errors['ong.volunteer']" class="mt-2 text-sm text-red-600">{{ form.errors['ong.volunteer'] }}</p>

       <!-- Descriptions -->
       <Textarea
            class="w-full"
            :label="$t('organization_why_volunteer_label')"
            id="organization_why_volunteer_label"
            color="gray-700"
            v-model="form.ong.why_volunteer"
            :error="form.errors['ong.why_volunteer']"
        >
            <p class="text-xs font-normal text-gray-500">{{ $t('why_volunteer_info') }}</p>
        </Textarea>

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
                background="primary-500"
                hover="primary-400"
                color="white"
                type="button"
                @click="$emit('next', $event.target)"
            >
                {{ $t('finish') }}
            </PrimaryButton>
        </div>
    </div>
</template>

<script setup>
    /** Import components. */
    import Textarea from '@/Components/form/Textarea.vue';
    import Checkbox from '@/Components/form/Checkbox.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const props = defineProps({
        form: Object
    })
</script>
