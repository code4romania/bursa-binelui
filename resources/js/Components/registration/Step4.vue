<template>
    <div class="space-y-6">

        <h1 v-if="'ong' == form.type" class="text-2xl font-bold text-cyan-900">{{ $t('contact_ong') }}</h1>

        <!-- County -->
        <MultiSelectObjectFilter
            class="w-full"
            :label="$t('county')"
            v-model="form.ong.counties_ids"
            :options="counties"
        />

        <!-- Address -->
        <div>
            <Input
                :label="$t('ong_address')"
                id="ong_address"
                type="text"
                v-model="form.ong.street_address"
                :isRequired="true"
                color="gray-700"
                hasAutocomplete="ong_address"
                :error="form.errors?.ong?.street_address"
            />
            <p class="text-xs text-gray-500">{{ $t('complete_address') }}</p>
        </div>

        <!-- Contact person -->
        <div>
            <Input
                :label="$t('contact_person')"
                id="contact_person"
                type="text"
                v-model="form.ong.contact_person"
                :isRequired="true"
                color="gray-700"
                hasAutocomplete="contact_person"
                :error="form.errors?.ong?.contact_person"
            />
            <p class="text-xs text-gray-500">{{ $t('contact_person_info') }}</p>
        </div>

         <!-- Contact phone -->
         <Input
            :label="$t('contact_phone')"
            id="contact_phone"
            type="number"
            v-model="form.ong.contact_phone"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="contact_phone"
            :error="form.errors?.ong?.contact_phone"
        />

         <!-- Contact email -->
         <Input
            :label="$t('contact_email')"
            id="contact_email"
            type="email"
            v-model="form.ong.contact_email"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="contact_email"
            :error="form.errors?.ong?.contact_email"
        />

         <!-- Webisite -->
         <Input
            :label="$t('organization_website_label')"
            id="organization_website_label"
            type="text"
            v-model="form.ong.website"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="organization_website_label"
            :error="form.errors.webiste"
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
    </div>
</template>

<script setup>
    /** Import components. */
    import Input from '@/Components/form/Input.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import FileInput from '@/Components/form/FileInput.vue';
    import ButtonFile from '@/Components/form/ButtonFile.vue';
    import Avatar from '@/Components/form/Avatar.vue';
    import MultiSelectFilter from '@/Components/filters/MultiSelectFilter.vue';
    import Select from '@/Components/form/Select.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import MultiSelectObjectFilter from "@/Components/filters/MultiSelectObjectFilter.vue";

    const props = defineProps({
        form: Object,
        counties: Array,
    })
</script>
