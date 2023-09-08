<template>
    <div v-if="!finalize">
        <!-- Label -->
        <label class="text-sm font-semibold text-gray-700">{{ $t('where_did_you_find') }}</label>

        <!-- Radio group -->
        <fieldset class="mt-4">
            <div class="space-y-4" v-if="!finalize">
                <div v-for="option in options" :key="option.value" class="flex items-center">
                    <input
                        @change="optionChanged(option.value)"
                        :id="option.value"
                        name="info"
                        type="radio"
                        v-model="social.source_of_information"
                        :value="option.value"
                        class="w-4 h-4 border-gray-300 text-primary-500 focus:ring-primary-500"
                    />
                    <label :for="option.value" class="block ml-3 text-sm font-medium leading-6 text-gray-900">{{
                        option.label
                    }}</label>
                </div>

                <!-- Other -->
                <Input
                    @input="update"
                    v-show="show && social.source_of_information"
                    id="other"
                    type="text"
                    v-model="other"
                    :isRequired="true"
                    color="gray-700"
                />
            </div>
        </fieldset>

        <PrimaryButton
            background="primary-500"
            hover="primary-400"
            color="white"
            type="button"
            class="mt-6"
            @click="$emit('success', $event.target)"
        >
            {{ $t('send') }}
        </PrimaryButton>
    </div>
</template>

<script setup>
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import components. */
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const props = defineProps({
        social: Object,
        finalize: Boolean,
    });

    const other = ref('');
    const show = ref(false);

    const options = [
        {
            label: 'De la o altă organizație',
            value: 'other_organization',
        },
        {
            label: 'Dintr-un motor de căutare (ex. Google)',
            value: 'web',
        },
        {
            label: 'Din social media',
            value: 'media',
        },
        {
            label: 'Din presă (scrisă, online, radio, TV)',
            value: 'press',
        },
        {
            label: 'De la un reprezentant BCR',
            value: 'bcr',
        },
        {
            label: 'Altul',
            value: 'other',
        },
    ];

    /** Options changed. */
    const optionChanged = (value) => {
        if ('other' === value) {
            show.value = true;
        } else {
            show.value = false;
            other.value = '';
        }
    };

    const update = () => (props.social.source_of_information = other.value);
</script>
