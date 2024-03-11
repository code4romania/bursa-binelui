<template>
  <div class="mx-auto my-10 space-y-12">
    <div>
      <h3 class="text-4xl font-extrabold text-center">{{title}}</h3>
    </div>
    <div class="flex items-center justify-center gap-6">

      <PrimaryButton
          :color="selectedLayout==='time_evolution' ? 'danger' : 'gray'"
          class="px-6 py-1.5"
          @click="selectedLayout = 'time_evolution'"
          :label="$t('time_evolution')"
      />

      <PrimaryButton
          :color="selectedLayout==='table' ? 'danger' : 'gray'"
          class="px-6 py-1.5"
          @click="selectedLayout = 'table'"
          :label="$t('projects_per_domain')"
      />
    </div>
    <div v-if="selectedLayout==='time_evolution'" class="border border-gray-200 rounded">
      <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <h3 class="text-lg font-bold text-gray-900">{{$t('time_evolution')}}</h3>
        <div class="flex items w-1/2 justify-around ">
            <Select
                class="col-span-12 sm:col-span-6 lg:col-span-4 w-1/3"
                :label="$t('county')"
                v-model="filter.county"
                multiple
                :options="counties"
                @update:modelValue="applyFilters"
            />
            <Select
                class="col-span-12 sm:col-span-6 lg:col-span-4 w-1/3"
                :label="$t('project_category')"
                v-model="filter.category"
                :options="projectCategoriesList"
                @update:modelValue="applyFilters"
            />
        </div>
      </div>
      <div class="p-4">
        <LineChart
            :data="data"
            :xAxeId="'date'"
            :use-month-label="true"
            :label="$t('projects_registered')"
            :yAxeId="'number'"
        />
      </div>
    </div>

      <div v-if="selectedLayout==='table'" class="border border-gray-200 rounded">
          <div class="flex items-center justify-between p-4 border-b border-gray-200">
              <h3 class="text-lg font-bold text-gray-900">{{$t('time_evolution')}}</h3>
              <div class="flex items">
                  <PrimaryButton
                      :color="selectedData==='projects_number' ? 'primary' : 'gray'"
                      class="px-6 py-1.5"
                      @click="selectedData = 'projects_number'"
                      :label="$t('projects_number')"
                  />
                  <PrimaryButton
                      :color="selectedData ==='projects_target' ? 'primary' : 'gray'"
                      class="px-6 py-1.5"
                      @click="selectedData = 'projects_target'"
                      :label="$t('projects_target')"
                  />
              </div>
          </div>
          <div class="grid grid-cols-2">
              <div>
                  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                      <table class="w-full text-left p-2" :aria-label="$t('donations_table_description')">
                          <thead class="bg-primary-500 text-white">
                          <tr class="border-b-2 ">
                              <th scope="col" class="pr-3 px-2 py-2 text-sm font-semibold" v-text="$t('project_category_label')" />
                              <th scope="col" class="hidden  px-2 py-2 text-sm font-semibold  sm:table-cell" v-text="$t('projects_number')"/>
                              <th scope="col" class="hidden  px-2 py-2 text-sm font-semibold  md:table-cell" v-text="$t('projects_target')"/>
                          </tr>
                          </thead>
                          <tbody>
                          <tr v-for="category in projectCategories" :key="category.id">
                              <td class=" pr-3 px-2 py-2text-sm font-medium" v-text="category.name"/>
                              <td class=" px-2 py-2 text-sm" v-text="category.projects_count"/>
                              <td class=" px-2 py-2 text-sm" v-text="category.projects_sum_target_budget"/>
                          </tr>
                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="p-4" >
                  <DonutChart
                      v-if="selectedData==='projects_number'"
                      :data="projectCategories"
                      :label="$t('projects_number')"
                      :x-axe-id="'name'"
                      :y-axe-id="'projects_count'"
                  />
                  <DonutChart
                      v-else
                      :data="projectCategories"
                      :label="$t('projects_target')"
                      :x-axe-id="'name'"
                      :y-axe-id="'projects_sum_target_budget'"
                  />
              </div>
          </div>


      </div>

  </div>
</template>
<script setup>
import PrimaryButton from "@/Components/buttons/PrimaryButton.vue";
import LineChart from "@/Components/charts/LineChart.vue";
import {ref} from "vue";
import DonutChart from "@/Components/charts/DonutChart.vue";
import SelectMultiple from "@/Components/form/SelectMultiple.vue";
import Select from "@/Components/form/Select.vue";
import useFilters from "@/Helpers/useFilters.js";
import route from "@/Helpers/useRoute.js";

let selectedLayout = ref('time_evolution');


const props = defineProps({
    title:{
        type: String,
        required: true
    },
    data: {
        type: Array,
        required: true
    },
    projectCategories: {
        type: Array,
        required: true
    },

    counties: {
        type: Array,
        required: true
    },
    filter: {
        type: Object,
        required: true
    },
    projectCategoriesList: {
        type: Array,
        required: true
    }
})

const filter = ref({
    county: props.filter?.county || null,
    category: props.filter?.category || null,
});

const sort = ref(null);

const selectedData = ref('projects_number');



const { applyFilters, clearFilters } = useFilters(filter, sort, route('evolution'));

</script>
