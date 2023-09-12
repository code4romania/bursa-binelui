<template>
    <div class="space-y-6">
        <h1 v-if="'ngo-admin' == form.type" class="text-2xl font-bold text-cyan-900">{{ $t('ong_profile') }}</h1>

        <!-- Ong Name -->
        <Input
            :label="$t('ong_name')"
            id="ong_name"
            type="text"
            v-model="form.ngo.name"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="ong_name"
            :error="form.errors['ngo.name']"
        />

        <!-- Ong cif -->
        <Input
            :label="$t('ong_cif')"
            id="ong_cif"
            type="text"
            v-model="form.ngo.cif"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="ong_cif"
            :error="form.errors['ngo.cif']"
        />

        <div>
            <label class="block mb-1 text-sm font-medium leading-6 text-gray-700">{{ $t('ong_logo') }}</label>
            <Avatar
                :label="$t('upload_logo')"
                @upload="(file) => (form.ngo.logo = file)"
                :form="form"
                :recivedFile="form.ngo.logo"
                :error="form.errors['ngo.logo']"
            />
        </div>

        <!-- Descriptions -->
        <Textarea
            class="w-full"
            :label="$t('about_ong')"
            id="about-ong"
            color="gray-700"
            v-model="form.ngo.description"
            :error="form.errors['ngo.description']"
        >
            <p class="text-xs font-normal text-gray-500">{{ $t('about_ong_description') }}</p>
        </Textarea>

        <!-- Activity domains -->
        <Select
            class="w-full z-101"
            :label="$t('domains')"
            type="object"
            :options="$page.props.domains"
            v-model="form.ngo.domains"
            :error="form.errors['ngo.domains']"
            multiple
        />

        <!-- Statut -->
        <div>
            <p class="block mb-1 text-sm font-medium leading-6 text-gray-700">{{ $t('ong_statut') }}</p>
            <ButtonFile
                :label="$t('upload_file')"
                @upload="(file) => (form.ngo.statute = file)"
                v-model="form.ngo.statute"
                :recivedFile="form.ngo.statute"
                :error="form.errors['ngo.statute']"
            />
            <p class="block mt-1 text-xs font-medium leading-6 text-gray-500">{{ $t('file_description') }}</p>
        </div>

        <div v-if="'ngo-admin' == form.type" class="flex items-center justify-between mt-6 gap-x-4">
            <SecondaryButton @click="$emit('prev', $event.target)">
                {{ $t('back') }}
            </SecondaryButton>

            <PrimaryButton
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
    import Input from '@/Components/form/Input.vue';
    import Avatar from '@/Components/form/Avatar.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import ButtonFile from '@/Components/form/ButtonFile.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import Select from '@/Components/form/Select.vue';

    /** Component props. */
    const props = defineProps({
        form: Object,
    });
</script>
