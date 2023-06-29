<template>
    <div class="space-y-6">

        <h1 v-if="'ong' == form.type" class="text-2xl font-bold text-cyan-900">{{ $t('contact_ong') }}</h1>

        <!-- County -->
        <div class="w-full">
            <MultiSelectObjectFilter
                class="w-full"
                :label="$t('county')"
                v-model="form.ong.counties_ids"
                :options="counties"
            />
            <p v-show="form.errors['ong.counties_ids']" class="mt-2 text-sm text-red-600">{{ form.errors['ong.counties_ids'] }}</p>
        </div>

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
                :error="form.errors['ong.street_address']"
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
                :error="form.errors['ong.contact_person']"
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
            :error="form.errors['ong.contact_phone']"
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
            :error="form.errors['ong.contact_email']"
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
            :error="form.errors['ong.webiste']"
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
                background="primary-500"
                hover="primary-400"
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
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import MultiSelectObjectFilter from "@/Components/filters/MultiSelectObjectFilter.vue";

    const props = defineProps({
        form: Object,
        counties: Array,
    })
</script>
