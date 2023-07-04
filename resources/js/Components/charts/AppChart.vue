<template>
    <!-- Time evolution -->
    <div class="space-y-6">
                <h1 class="text-4xl font-extrabold text-center text-gray-900">{{ $t('good_deeds') }}</h1>

                <div class="border border-gray-200 rounded">
                    <div class="flex items-center justify-between p-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900">{{ $t('good_deeds_evolution') }}</h3>

                        <div class="flex items-center justify-center w-3/12 gap-6">
                            <Input
                                class="w-full"
                                :label="$t('project_date_start_label')"
                                color="gray-700"
                                type="date"
                            />
                        </div>
                    </div>

                    <LineChart
                        :data="projects_number"
                        :xAxe="xAxe"
                        :yAxeId="projectsNumberY"
                        class="p-4"
                    />
                </div>
            </div>
</template>

<script setup>
import { ref } from 'vue';
import LineChart from '@/Components/charts/LineChart.vue';
import Input from '@/Components/form/Input.vue';

const props = defineProps({
    projects: Number,
    projects_number: Array
});
const xAxe = ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'];
const projectsNumberY = "number"
</script>
