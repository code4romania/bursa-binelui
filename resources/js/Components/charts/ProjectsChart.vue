<template>
    <!-- Time evolution -->
    <div class="space-y-6">
        <h1 class="text-4xl font-extrabold text-center text-gray-900">
            <span>{{ projects ? projects : 0 }} {{ $t('registered_projects') }}</span>
        </h1>
        <div class="flex items-center justify-center gap-6">
            <PrimaryButton
                :background="['time_evolution' === time_evolution_2 ? 'red-500' : 'gray-100']"
                :hover="['time_evolution' === time_evolution_2 ? 'red-400' : 'gray-200']"
                :color="['time_evolution' === time_evolution_2 ? 'white' : 'gray-700']"
                class="px-6 py-1.5"
                @click="time_evolution_2='time_evolution'"
            >
                {{ $t('time_evolution') }}
            </PrimaryButton>

            <PrimaryButton
                :background="['projects_per_domain' === time_evolution_2 ? 'red-500' : 'gray-100']"
                :hover="['projects_per_domain' === time_evolution_2 ? 'red-400' : 'gray-200']"
                :color="['projects_per_domain' === time_evolution_2 ? 'white' : 'gray-700']"
                class="px-6 py-1.5"
                @click="time_evolution_2='projects_per_domain'"
            >
                {{ $t('projects_per_domain') }}
            </PrimaryButton>
        </div>

        <div v-if="'time_evolution' === time_evolution_2" class="border border-gray-200 rounded">
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">{{ $t('time_evolution') }}</h3>

                <div class="flex items-center justify-center w-1/2 gap-6">
                    <MultiSelectObjectFilter
                        class="w-full"
                        :label="$t('county')"
                        :options="counties"
                        @callback="updateChart"
                    />
                    <MultiSelectObjectFilter
                        class="w-full"
                        :label="$t('domains')"
                        :options="domains"
                        @callback="updateChart"
                    />
                </div>
            </div>

            <LineChart
                v-if="'time_evolution' === time_evolution_2"
                :data="projects_number"
                :xAxe="xAxe"
                :yAxeId="projectsNumberY"
                class="p-4"
            />
        </div>

        <div v-if="'projects_per_domain' === time_evolution_2" class="grid grid-cols-12 gap-10 border border-gray-200 rounded">

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
                :data="projects_number"
                :xAxe="xAxe"
                :yAxeId="projectsNumberY"
                class="col-span-12 p-4 md:col-span-6"
            />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import LineChart from '@/Components/charts/LineChart.vue';
import MultiSelectObjectFilter from '@/Components/filters/MultiSelectObjectFilter.vue';
import DonutChart from '@/Components/charts/DonutChart.vue';
import Table from '@/Components/tables/Table.vue';

const props = defineProps({
    projects: Number,
    projects_number: Array,
    counties: Array,
    domains: Array,
    table_data:Array
});

const time_evolution_2 = ref('time_evolution');

const xAxe = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'];

const projectsNumberY = "number"

const updateChart = () => {}
</script>
