<template>
    <DashboardLayout>
        <!-- Inertia page head -->
        <Title :title="$t('add_project_title')" />

        <form @submit.prevent="createProject">
            <div class="w-full space-y-6 max-w-7xl mt-9">
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

                <SelectMultiple
                    class="w-full xl:w-1/2"
                    :label="$t('project_category_label')"
                    use-translation="true"
                    :options="projectCategories"
                    v-model="selectedCategories"
                    type="singleValue"
                    :error="form.errors.categories"
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
                    <Checkbox name="remember" v-model:checked="form.is_national" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('is_national') }}</span>

                    <!-- Error -->
                    <p v-show="form.errors.is_national" class="mt-2 text-sm text-red-600">
                        {{ form.errors.is_national }}
                    </p>
                </label>

                <!-- County -->
                <SelectMultiple
                    class="w-full xl:w-1/2"
                    :label="$t('counties_label')"
                    :options="counties"
                    type="object"
                    v-model="selectedCounties"
                    v-if="!form.is_national"
                    :error="form.errors.counties"
                />

                <!-- Project description -->
                <Textarea
                    class="w-full"
                    :label="$t('project_description_label')"
                    id="about-project"
                    color="gray-700"
                    numberOfCharacters=800
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
                    <Checkbox name="remember" v-model:checked="form.accepting_volunteers" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('has_volunteers_label') }}</span>

                    <!-- Error -->
                    <p v-show="form.errors.accepting_volunteers" class="mt-2 text-sm text-red-600">
                        {{ form.errors.accepting_volunteers }}
                    </p>
                </label>

                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.accepting_comments" />
                    <span class="ml-2 text-sm text-gray-700">{{ $t('has_comments_label') }}</span>

                    <!-- Error -->
                    <p v-show="form.errors.accepting_comments" class="mt-2 text-sm text-red-600">
                        {{ form.errors.accepting_comments }}
                    </p>
                </label>

                <!-- File group -->
                <FileGroup v-model="form.file_group" />

                <div class="flex w-full border-t border-gray-300" v-for="(item, index) in projectLinks" :key="index">
                    <InputWithIcon
                        class="w-1/2"
                        :label="$t('video_link_label')"
                        color="gray-700"
                        icon="https://"
                        type="text"
                        v-model="item.url"
                    />
                    <DangerButton
                        v-if="index > 0"
                        class="mt-8 ml-4"
                        background="red-500"
                        hover="red-400"
                        color="white"
                        @click="
                            () => {
                                projectLinks.pop();
                            }
                        "
                    >
                        {{ $t('remove') }}
                    </DangerButton>
                    <SecondaryButton
                        class="mt-8 ml-4"
                        background="primary-500"
                        hover="primary-400"
                        color="white"
                        @click="
                            () => {
                                projectLinks.push({ url: '' });
                            }
                        "
                    >
                        {{ $t('add') }}
                    </SecondaryButton>
                </div>

                <div class="w-full border-t border-gray-300"></div>

                <div>
                    <p class="text-lg font-medium leading-5 text-gray-900">{{ $t('external_links_title') }}</p>
                    <p class="text-sm leading-5 text-gray-700">{{ $t('external_links_text') }}</p>
                </div>
                <div class="flex w-full border-t border-gray-300" v-for="(item, index) in projectArticles" :key="index">
                    <InputWithIcon
                        class="w-1/2"
                        :label="$t('video_link_label')"
                        color="gray-700"
                        icon="https://"
                        type="text"
                        v-model="item.url"
                    />
                    <DangerButton
                        v-if="index > 0"
                        class="mt-8 ml-4"
                        background="red-500"
                        hover="red-400"
                        color="white"
                        @click="() => projectArticles.pop()"
                    >
                        {{ $t('remove') }}
                    </DangerButton>
                    <SecondaryButton
                        class="mt-8 ml-4"
                        background="primary-500"
                        hover="primary-400"
                        color="white"
                        @click="() => projectArticles.push({ url: '' })"
                    >
                        {{ $t('add') }}
                    </SecondaryButton>
                </div>

                <div class="w-full border-t border-gray-300" />

                <div class="flex items-center justify-end gap-6">
                    <SecondaryButton class="py-2.5">
                        {{ $t('cancel') }}
                    </SecondaryButton>

                    <SecondaryButton class="py-2.5" @click="createProject">
                        {{ $t('preview') }}
                    </SecondaryButton>

                    <PrimaryButton @click="createProject" :label="$t('save')" />
                </div>
            </div>
        </form>
    </DashboardLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { useForm } from '@inertiajs/vue3';

    /** Import components. */
    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
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
    import DangerButton from '@/Components/buttons/DangerButton.vue';
    import { ref } from 'vue';
    import SelectMultiple from '@/Components/form/SelectMultiple.vue';

    /** Initialize inertia from Object. */
    const form = useForm({
        name: '',
        target_budget: '',
        categories: [],
        start: '',
        end: '',
        counties: [],
        description: '',
        scope: '',
        beneficiaries: '',
        reason_to_donate: '',
        is_national: false,
        accepting_comments: false,
        accepting_volunteers: false,
        file_group: [],
        project_links: [{ url: '' }],
        project_articles: [{ url: '' }],
    });
    let selectedCounties = ref([]);
    let selectedCategories = ref([]);
    const props = defineProps(['projectCategories', 'counties']);
    let projectLinks = ref(form.project_links);
    let projectArticles = ref(form.project_articles);

    function prepareProjectLinks() {
        form.project_links = projectLinks.value.filter((item) => item.url !== '').map((item) => item.url);
    }
    function prepareExternalLinks() {
        form.project_articles = projectArticles.value.filter((item) => item.url !== '').map((item) => item.url);
    }

    /** Create project. */
    const createProject = () => {
        form.counties = selectedCounties.value.map((item) => item.id);
        form.categories = selectedCategories.value.map((item) => item.id);

        prepareProjectLinks();
        prepareExternalLinks();
        form.post(route('dashboard.projects.store'), {
            preserveScroll: true,
            onError: () => {},
        });
    };
</script>
