<template>
    <div class="space-y-6">

        <h1 v-if="'ong' == form.type" class="text-2xl font-bold text-cyan-900">{{ $t('ong_profile') }}</h1>

        <!-- Ong Name -->
        <Input
            :label="$t('ong_name')"
            id="ong_name"
            type="text"
            v-model="form.ong.name"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="ong_name"
            :error="form.errors['ong.name']"
        />

        <!-- Ong cif -->
        <Input
            :label="$t('ong_cif')"
            id="ong_cif"
            type="text"
            v-model="form.ong.cif"
            :isRequired="true"
            color="gray-700"
            hasAutocomplete="ong_cif"
            :error="form.errors['ong.cif']"
        />

        <div>
            <label class="block mb-1 text-sm font-medium leading-6 text-gray-700">{{ $t('ong_logo') }}</label>
            <Avatar
                :label="$t('upload_logo')"
                @upload="ongLogo"
                :form="form"
            />
        </div>

        <!-- Descriptions -->
        <Textarea
            class="w-full"
            :label="$t('about_ong')"
            id="about-ong"
            color="gray-700"
            v-model="form.ong.description"
            :error="form.errors['ong.description']"
        >
            <p class="text-xs font-normal text-gray-500">{{ $t('about_ong_description') }}</p>
        </Textarea>

        <!-- Activity domains -->
        <div>
            <MultiSelectObjectFilter
                class="w-full"
                :label="$t('domains')"
                v-model="form.ong.activity_domains_ids"
                :options="activity_domains"
                id="activity-domains"
                ref="activityDomains"
            />
            <p v-show="form.errors['ong.activity_domains_ids']" class="mt-2 text-sm text-red-600">{{ form.errors['ong.activity_domains_ids'] }}</p>
        </div>

        <!-- Statut -->
        <div>
            <p class="block mb-1 text-sm font-medium leading-6 text-gray-700">{{ $t('ong_statut') }}</p>
            <ButtonFile
                :label="$t('upload_file')"
                @upload="ongStatute"
                v-model="form.ong.statute"
            />
            <p class="block mt-1 text-xs font-medium leading-6 text-gray-500">{{ $t('file_description') }}</p>
        </div>

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
    import Avatar from '@/Components/form/Avatar.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import ButtonFile from '@/Components/form/ButtonFile.vue';
    import MultiSelectFilter from '@/Components/filters/MultiSelectFilter.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import {onMounted} from "vue";
    import MultiSelectObjectFilter from "@/Components/filters/MultiSelectObjectFilter.vue";

    /** Component props. */
    const props = defineProps({
        form: Object,
        activity_domains: {
            type: Array,
            default: () => []
        },
    });
    onMounted(() => {
        console.log(props.form)
        console.log(props.activity_domains);
    })

    /** Update form ong logo. */
    const ongLogo = ((file) => props.form.ong.logo = file);
    const ongStatute = ((file => props.form.ong.statute = file));
</script>
