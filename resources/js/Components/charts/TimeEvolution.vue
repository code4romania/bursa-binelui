<template>
    <!-- Time evolution -->
    <div class="space-y-6">
        <h1 class="text-4xl font-extrabold text-center text-gray-900">
            <span>{{ donations ? donations : 0 }} {{ $t('donations') }},&nbsp;</span>
            <span>{{ amount ? amount : 0 }} {{ $t('currency') }}</span>
        </h1>
        <div class="flex items-center justify-center gap-6">
            <PrimaryButton
                :color="'time_evolution' === time_evolution_1 ? 'danger' : 'gray'"
                class="px-6 py-1.5"
                @click="time_evolution_1 = 'time_evolution'"
                :label="$t('time_evolution')"
            />

            <PrimaryButton
                :color="'donations_per_domain' === time_evolution_1 ? 'danger' : 'gray'"
                class="px-6 py-1.5"
                @click="time_evolution_1 = 'donations_per_domain'"
                :label="$t('donations_per_domain')"
            />
        </div>

        <div v-if="'time_evolution' === time_evolution_1" class="border border-gray-200 rounded">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">{{ $t('time_evolution') }}</h3>

                <div class="flex items-center justify-center gap-6">
                    <PrimaryButton
                        :color="'nr_donations' === time_evolution_2 ? 'primary' : 'gray'"
                        class="px-6 py-1.5"
                        @click="time_evolution_2 = 'nr_donations'"
                        :label="$t('donation_number')"
                    />

                    <PrimaryButton
                        :color="'amount_donations' === time_evolution_2 ? 'primary' : 'gray'"
                        class="px-6 py-1.5"
                        @click="time_evolution_2 = 'amount_donations'"
                        :label="$t('donation_amount')"
                    />
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

        <div
            v-if="'donations_per_domain' === time_evolution_1"
            class="grid grid-cols-12 gap-10 border border-gray-200 rounded"
        >
            <div class="flex items-center justify-between col-span-12 p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">{{ $t('time_evolution') }}</h3>

                <div class="flex items-center justify-center gap-6">
                    <PrimaryButton
                        :color="'nr_donations' === time_evolution_2 ? 'primary' : 'gray'"
                        class="px-6 py-1.5"
                        @click="time_evolution_2 = 'nr_donations'"
                        :label="$t('donation_number')"
                    />

                    <PrimaryButton
                        :color="'amount_donations' === time_evolution_2 ? 'primary' : 'gray'"
                        class="px-6 py-1.5"
                        @click="time_evolution_2 = 'amount_donations'"
                        :label="$t('donation_amount')"
                    />
                </div>
            </div>

            <div class="col-span-12 p-4 md:col-span-6">
                <Table
                    class=""
                    :columns="['Categorie', 'Numar donatii', 'Suma']"
                    :currentPage="table_data.current_page"
                    :prev="table_data.prev_page_url"
                    :next="table_data.next_page_url"
                    :links="table_data.links"
                >
                    <tr v-for="donation in table_data.data" :key="donation.id">
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ donation.domain }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ donation.number }}</td>
                        <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ donation.amount }}</td>
                    </tr>
                </Table>
            </div>

            <DonutChart
                :data="donations_amount"
                :xAxe="xAxe"
                :yAxeId="donationsAmountY"
                class="col-span-12 p-4 md:col-span-6"
            />
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import LineChart from '@/Components/charts/LineChart.vue';
    import DonutChart from '@/Components/charts/DonutChart.vue';
    import Table from '@/Components/Table.vue';

    const props = defineProps({
       total
    });

    const time_evolution_1 = ref('time_evolution');
    const time_evolution_2 = ref('nr_donations');
    const time_evolution_3 = ref('categories');
    const time_evolution_4 = ref('amount');

    const xAxe = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'];

    const donationsNumberY = 'number';
    const donationsAmountY = 'amount';
</script>
