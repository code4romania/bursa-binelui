<template>
    <DashboardLayout>
        <!-- Inertia page head -->
        <Title :title="$t('regional.project.edit_page_title')" />

        <dl class="mt-6 border-t border-gray-100 divide-y divide-gray-100">
            <!-- Edit project name -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.title')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.name"
                />
            </div>
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.description')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.description"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.counties')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.counties?.map((item) => item.name).join(', ')"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.start_date')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.start_date"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.end_date')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.end_date"
                />
            </div>

            <!-- Edit project category -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.categories')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.categories?.map((item) => item.name).join(', ')"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.youth')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.youth ? 'da' : 'nu'"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.organization_type')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.organization_type"
                />
            </div>

            <!-- Edit project scope -->
            <div class="grid grid-cols-12 px-4 py-6 bg-gray-100">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.identified_need')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.reason"
                />
            </div>

            <!-- Edit project beneficiary -->
            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.proposed_solution')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.solution"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.project_progress')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.project_details"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.what_is_special')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.special"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.key_results')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.results"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.pride_success')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.proud"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.had_partners')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.partnership ? 'da' : 'nu'"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white" v-if="form.partnership">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.partners')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.partnership_details"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.project_budget')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.budget_details"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.participant_count_no')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.participants"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.project_team')"
                />
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6"
                    v-text="form.team_details"
                />
            </div>

            <div class="grid grid-cols-12 px-4 py-6 bg-white">
                <dt
                    class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-5"
                    v-text="$t('regional.project.contact_info')"
                />
                <dt class="col-span-12 text-base font-medium leading-6 text-gray-700 md:col-span-6">
                    <div class="flex items center">
                        <div class="flex flex-col">
                            <span v-text="form.contact?.name" />
                            <span v-text="form.contact?.email" />
                            <span v-text="form.contact?.phone" />
                        </div>
                    </div>
                </dt>
            </div>
        </dl>
    </DashboardLayout>
</template>

<script setup>
/** Import from inertia. */
import { useForm } from '@inertiajs/vue3';

/** Import components. */
import DashboardLayout from '@/Layouts/DashboardLayout.vue';
import { ref } from 'vue';

const props = defineProps({
    project: Object,
    errors: Object,
    counties: Array,
    projectCategories: Array,
    success_message: String,
    error_message: String,
});

let project = ref(props.project);
let form = useForm(project.value);
</script>
