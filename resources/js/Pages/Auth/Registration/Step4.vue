<template>
    <div class="space-y-6">
        <h1 v-if="'organization' == form.type" class="text-2xl font-bold text-cyan-900" v-text="$t('contact_ong')" />

        <!-- County -->

        <Select
            class="w-full"
            :label="$t('county')"
            type="object"
            v-model="form.ngo.counties"
            :options="$page.props.counties"
            :error="form.errors['ngo.counties']"
            multiple
        />

        <!-- Address -->
        <div>
            <Input
                :label="$t('ong_address')"
                id="ong_address"
                type="text"
                v-model="form.ngo.street_address"
                :isRequired="true"
                color="gray-700"
                hasAutocomplete="ong_address"
                :error="form.errors['ngo.street_address']"
            />
            <p class="text-xs text-gray-500">{{ $t('complete_address') }}</p>
        </div>

        <!-- Contact person -->
        <div>
            <Input
                :label="$t('contact_person')"
                id="contact_person"
                type="text"
                v-model="form.ngo.contact_person"
                :isRequired="true"
                color="gray-700"
                hasAutocomplete="contact_person"
                :error="form.errors['ngo.contact_person']"
            />
            <p class="text-xs text-gray-500">{{ $t('contact_person_info') }}</p>
        </div>

        <!-- Contact phone -->
        <Input
            :label="$t('contact_phone')"
            id="contact_phone"
            type="number"
            v-model="form.ngo.contact_phone"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="contact_phone"
            :error="form.errors['ngo.contact_phone']"
        />

        <!-- Contact email -->
        <Input
            :label="$t('contact_email')"
            id="contact_email"
            type="email"
            v-model="form.ngo.contact_email"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="contact_email"
            :error="form.errors['ngo.contact_email']"
        />

        <!-- Webisite -->
        <Input
            :label="$t('organization_website_label')"
            id="organization_website_label"
            type="text"
            v-model="form.ngo.website"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="organization_website_label"
            :error="form.errors['ngo.website']"
        />

        <div v-if="'organization' == form.type" class="flex items-center justify-between mt-6 gap-x-4">
            <SecondaryButton @click="$emit('prev', $event.target)">
                {{ $t('back') }}
            </SecondaryButton>

            <PrimaryButton @click="$emit('next', $event.target)" :label="$t('continue')" />
        </div>
    </div>
</template>

<script setup>
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Select from '@/Components/form/Select.vue';

    const props = defineProps({
        form: Object,
    });
</script>
