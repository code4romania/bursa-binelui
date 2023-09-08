<template>
    <div>
        <RadioGroup :options="options" v-model="form.type" :error="form.errors?.type" />

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
</template>

<script setup>
    /** Import from vue. */
    import { ref } from 'vue';

    /** Import components. */
    import RadioGroup from '@/Components/form/RadioGroup.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';

    const props = defineProps({
        form: Object,
    });

    /** Default radio options. */
    const options = ref([
        {
            label: 'Creează cont donator',
            value: 'donor',
            description: 'Dorești să donezi? Creează acum un cont și începe să faci fapte bune.',
        },
        {
            label: 'Creează cont organizație',
            value: 'ngo-admin',
            description: 'Vrei ca ONG-ul din care faci parte să apară pe Bursa Binelui? Înscrie organizația acum.',
        },
    ]);
</script>
