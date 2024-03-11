<template>
  <div class="mx-auto my-10 space-y-12 ">
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
          :label="$t('donations_per_domain')"
      />
    </div>
    <div v-if="selectedLayout==='time_evolution'" class="border border-gray-200 rounded">
      <div class="flex items-center justify-between p-4 border-b border-gray-200">
        <h3 class="text-lg font-bold text-gray-900">{{$t('time_evolution')}}</h3>
        <div class="flex items">
          <PrimaryButton
              :color="selectedData==='donation_number' ? 'primary' : 'gray'"
              class="px-6 py-1.5"
              @click="selectedData = 'donation_number'"
              :label="$t('donation_number')"
          />
          <PrimaryButton
              :color="selectedData ==='donation_amount' ? 'primary' : 'gray'"
              class="px-6 py-1.5"
              @click="selectedData = 'donation_amount'"
              :label="$t('donation_amount')"
          />
        </div>
      </div>
      <div v-if="selectedData==='donation_number'" class="p-4">
        <LineChart
            :data="data"
            :xAxeId="'date'"
            :use-month-label="true"
            :label="$t('donation_number')"
            :yAxeId="'number'"
        />
      </div>
      <div v-if="selectedData==='donation_amount'" class="p-4">
        <LineChart
            :data="data"
            :xAxeId="'date'"
            :use-month-label="true"
            :label="$t('donation_amount')"
            :yAxeId="'amount'"
        />
      </div>
    </div>

      <div v-if="selectedLayout==='table'" class="border border-gray-200 rounded">
          <div class="flex items-center justify-between p-4 border-b border-gray-200">
              <h3 class="text-lg font-bold text-gray-900">{{$t('time_evolution')}}</h3>
              <div class="flex items">
                  <PrimaryButton
                      :color="selectedData==='donation_number' ? 'primary' : 'gray'"
                      class="px-6 py-1.5"
                      @click="selectedData = 'donation_number'"
                      :label="$t('donation_number')"
                  />
                  <PrimaryButton
                      :color="selectedData ==='donation_amount' ? 'primary' : 'gray'"
                      class="px-6 py-1.5"
                      @click="selectedData = 'donation_amount'"
                      :label="$t('donation_amount')"
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
                              <th scope="col" class="hidden  px-2 py-2 text-sm font-semibold  sm:table-cell" v-text="$t('donation_number')"/>
                              <th scope="col" class="hidden  px-2 py-2 text-sm font-semibold  md:table-cell" v-text="$t('donation_amount')"/>
                          </tr>
                          </thead>
                          <tbody>
                          <tr v-for="category in projectCategories" :key="category.id">
                              <td class=" pr-3 px-2 py-2text-sm font-medium" v-text="category.name"/>
                              <td class=" px-2 py-2 text-sm" v-text="category.donations_count"/>
                              <td class=" px-2 py-2 text-sm" v-text="category.donations_sum_amount"/>
                          </tr>

                          </tbody>
                      </table>
                  </div>
              </div>
              <div class="p-4">
                  <DonutChart v-if="selectedData==='donation_number'"
                      :data="projectCategories"
                      :label="$t('donation_number')"
                      :x-axe-id="'name'"
                      :y-axe-id="'donations_count'"
                  />
                  <DonutChart
                      v-else
                      :data="projectCategories"
                      :label="$t('donation_amount')"
                      :x-axe-id="'name'"
                      :y-axe-id="'donations_sum_amount'"
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

let selectedLayout = ref('time_evolution');

let selectedData = ref('donation_number');

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
    }
})

</script>
