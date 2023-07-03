<template>
    <!-- Time evolution -->
    <div class="space-y-6">
                <h1 class="text-4xl font-extrabold text-center text-gray-900">
                    <span>{{ donations ? donations : 0 }} {{ $t('donations') }},&nbsp;</span>
                    <span>{{ amount ? amount : 0 }} {{ $t('currency') }}</span>
                </h1>
                <div class="flex items-center justify-center gap-6">
                    <PrimaryButton
                        :background="['time_evolution' === time_evolution_1 ? 'red-500' : 'gray-100']"
                        :hover="['time_evolution' === time_evolution_1 ? 'red-400' : 'gray-200']"
                        :color="['time_evolution' === time_evolution_1 ? 'white' : 'gray-700']"
                        class="px-6 py-1.5"
                        @click="time_evolution_1='time_evolution'"
                    >
                        {{ $t('time_evolution') }}
                    </PrimaryButton>

                    <PrimaryButton
                        :background="['donations_per_domain' === time_evolution_1 ? 'red-500' : 'gray-100']"
                        :hover="['donations_per_domain' === time_evolution_1 ? 'red-400' : 'gray-200']"
                        :color="['donations_per_domain' === time_evolution_1 ? 'white' : 'gray-700']"
                        class="px-6 py-1.5"
                        @click="time_evolution_1='donations_per_domain'"
                    >
                        {{ $t('Donații per domenii') }}
                    </PrimaryButton>
                </div>

                <div v-if="'time_evolution' === time_evolution_1" class="border border-gray-200 rounded">
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">{{ $t('time_evolution') }}</h3>

                        <div class="flex items-center justify-center gap-6">
                            <PrimaryButton
                                :background="['nr_donations' === time_evolution_2 ? 'primary-500' : 'gray-100']"
                                :hover="['nr_donations' === time_evolution_2 ? 'primary-400' : 'gray-200']"
                                :color="['nr_donations' === time_evolution_2 ? 'white' : 'gray-700']"
                                class="px-6 py-1.5"
                                @click="time_evolution_2='nr_donations'"
                            >
                                {{ $t('donation_number') }}
                            </PrimaryButton>

                            <PrimaryButton
                                :background="['amount_donations' === time_evolution_2 ? 'primary-500' : 'gray-100']"
                                :hover="['amount_donations' === time_evolution_2 ? 'primary-400' : 'gray-200']"
                                :color="['amount_donations' === time_evolution_2 ? 'white' : 'gray-700']"
                                class="px-6 py-1.5"
                                @click="time_evolution_2='amount_donations'"
                            >
                                {{ $t('donation_amount') }}
                            </PrimaryButton>
                        </div>
                    </div>

                    <LineChart
                        v-if="'nr_donations' === time_evolution_2"
                        :data="donations_number"
                        :xAxe="xAxe"
                        :yAxeId="donationsNumberY"
                        class="p-4"
                    />

                    <LineChart
                        v-if="'amount_donations' === time_evolution_2"
                        :data="donations_amount"
                        :xAxe="xAxe"
                        :yAxeId="donationsAmountY"
                        class="p-4"
                    />
                </div>
            </div>
</template>

<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import LineChart from '@/Components/charts/LineChart.vue';

const props = defineProps({
    donations: Number,
    amount: Number,
    donations_number: Array,
    donations_amount: Array
});

const time_evolution_1 = ref('time_evolution');
const time_evolution_2 = ref('nr_donations');

const xAxe = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'];

const donationsNumberY = "number"
const donationsAmountY = "amount"

</script>
