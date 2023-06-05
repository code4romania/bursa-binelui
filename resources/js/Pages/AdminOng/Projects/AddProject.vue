<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('add_project_title')"/>

        <!-- Dashboard template -->
        <Dashboard>
            <div class="p-9 mb-24 w-full">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0 fill-turqoise-500" name="list"/>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $t('add_project_title') }}</h2>
                </header>

                <form @submit.prevent="createProject">
                    <div class="w-full max-w-7xl space-y-6 mt-9">
                        <!-- Project name -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('project_name_label')"
                            color="gray-700"
                            id="project-name"
                            type="text"
                            v-model="form.name"
                            :error="form.errors.name"
                        />

                        <!-- Project main image -->

                        <!-- Project amount target -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('amount_target_label')"
                            color="gray-700"
                            id="amount-target"
                            type="number"
                            v-model="form.target_budget"
                            :error="form.errors.target_budget"
                        />

                        <!-- Project category -->
                        <Select
                            class="w-full xl:w-1/2"
                            :label="$t('project_category_label')"
                            :options="projectCategories"
                            v-model="form.category"
                            :error="form.errors.category"
                        />

                        <!-- Date period. -->
                        <div class="flex gap-6">

                            <!-- Date start -->
                            <Input
                                class="w-full xl:w-1/2"
                                :label="$t('project_date_start_label')"
                                color="gray-700"
                                type="date"
                                v-model="form.start"
                                :error="form.errors.start"
                            />

                            <!-- Date end -->
                            <Input
                                class="w-full xl:w-1/2"
                                :label="$t('project_date_end_label')"
                                color="gray-700"
                                type="date"
                                v-model="form.end"
                                :error="form.errors.end"
                            />
                        </div>
                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.is_national"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('is_national') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.is_national" class="mt-2 text-sm text-red-600">
                                {{ form.errors.is_national }}</p>
                        </label>

                        <!-- County -->
                        <Select
                            class="w-full xl:w-1/2"
                            :label="$t('counties_label')"
                            :options="countries"
                            v-model="selectedCountry"
                            v-if="!form.is_national"
                            :error="form.errors.county"
                        />

                        <!-- Project description -->
                        <Textarea
                            class="w-full"
                            :label="$t('project_description_label')"
                            id="about-project"
                            color="gray-700"
                            v-model="form.description"
                            :error="form.errors.description"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('project_description_extra') }}</p>

                        <!-- Project scope -->
                        <Textarea
                            class="w-full"
                            :label="$t('project_scope_label')"
                            id="project-scope"
                            color="gray-700"
                            v-model="form.scope"
                            :error="form.errors.scope"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('project_scope_extra') }}</p>

                        <!-- Project beneficiary -->
                        <Textarea
                            class="w-full"
                            :label="$t('project_beneficiary_label')"
                            id="project-beneficiary"
                            color="gray-700"
                            v-model="form.beneficiaries"
                            :error="form.errors.beneficiaries"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('project_beneficiary_extra') }}</p>

                        <!-- Why to donate -->
                        <Textarea
                            class="w-full"
                            :label="$t('why_to_donate')"
                            id="why-to-donate"
                            color="gray-700"
                            v-model="form.reason_to_donate"
                            :error="form.errors.reason_to_donate"
                        >
                        </Textarea>
                        <p class="text-sm font-normal text-gray-500">{{ $t('why_to_donate_extra') }}</p>

                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.accepting_volunteers"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('has_voluntiers_label') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.accepting_volunteers" class="mt-2 text-sm text-red-600">
                                {{ form.errors.accepting_volunteers }}</p>
                        </label>

                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.accepting_comments"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('has_comments_label') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.accepting_comments" class="mt-2 text-sm text-red-600">
                                {{ form.errors.accepting_comments }}</p>
                        </label>

                        <!-- File group -->
                        <FileGroup
                            v-model="form.file_group"
                        />

                        <div class="w-full border-t border-gray-300 flex" v-for="item in form.project_links">
                            <InputWithIcon
                                class="w-1/2"
                                :label="$t('video_link_label')"
                                color="gray-700"
                                icon="htpp://"
                                type="text"
                                v-model="item.url"
                            />
                            <PrimaryButton
                                class="ml-4 mt-8"
                                background="turqoise-500"
                                hover="turqoise-400"
                                color="white"
                                @click="()=>{form.project_links.push({url:''})}">
                                {{ $t('add_link') }}
                            </PrimaryButton>
                        </div>

                        <div class="w-full border-t border-gray-300"></div>

                        <div>
                            <p class="text-gray-900 leading-5 font-medium text-lg">{{ $t('external_links_title') }}</p>
                            <p class="text-gray-700 leading-5 text-sm">{{ $t('external_links_text') }}</p>
                        </div>

                        <!-- Project articles links -->
                        <Repeater class="w-full xl:w-1/2">
                            <InputWithIcon
                                class="w-full"
                                :label="$t('articles_link_label')"
                                color="gray-700"
                                icon="htpp://"
                                type="text"
                                v-model="form.project_articles"
                            />
                        </Repeater>


                        <div class="w-full border-t border-gray-300"></div>

                        <div class="flex items-center justify-end gap-6">

                            <SecondaryButton class="py-2.5">
                                {{ $t('cancel') }}
                            </SecondaryButton>

                            <SecondaryButton class="py-2.5">
                                {{ $t('preview') }}
                            </SecondaryButton>

                            <PrimaryButton
                                background="turqoise-500"
                                hover="turqoise-400"
                                color="white"
                                @click="createProject"
                            >
                                {{ $t('save') }}
                            </PrimaryButton>

                        </div>
                    </div>
                </form>
            </div>
        </Dashboard>
    </PageLayout>
</template>

<script setup>
/** Import from inertia. */
import {Head, useForm} from '@inertiajs/vue3';

/** Import components. */
import PageLayout from '@/Layouts/PageLayout.vue';
import Dashboard from '@/Components/templates/Dashboard.vue';
import SvgLoader from '@/Components/SvgLoader.vue';
import Input from '@/Components/form/Input.vue';
import Select from '@/Components/form/Select.vue';
import Textarea from '@/Components/form/Textarea.vue';
import Checkbox from '@/Components/form/Checkbox.vue';
import FileGroup from '@/Components/form/FileGroup.vue';
import Repeater from '@/Components/form/Repeater.vue';
import InputWithIcon from '@/Components/form/InputWithIcon.vue';
import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import {onMounted} from "vue";


/** Initialize inertia from Object. */
const form = useForm({
    name: '',
    target_budget: '',
    category: '',
    start: '',
    end: '',
    county: '',
    description: '',
    scope: '',
    beneficiaries: '',
    reason_to_donate: '',
    is_national: false,
    accepting_comments: false,
    accepting_volunteers: false,
    file_group: [],
    project_links: [{url: ''}],
    project_articles: []
});
let selectedCountry = null;
const props = defineProps(['projectCategories', 'countries']);


/** Create project. */
const createProject = () => {
    form.county = selectedCountry?.id;
    form.post(route('admin.ong.project.store'), {
        preserveScroll: true,
        onError: () => {
        },
    });
};
</script>
