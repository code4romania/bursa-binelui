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

                <Select
                    class="w-full z-101"
                    :label="$t('project_category_label')"
                    type="object"
                    :options="projectCategories"
                    v-model="form.categories"
                    :error="form.errors['categories']"
                    multiple
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
                    <Checkbox name="remember" v-model:checked="form.is_national"  />
                    <span class="ml-2 text-sm text-gray-700" v-html="$t('is_national') "/>
                    <p v-show="form.errors.is_national" class="mt-2 text-sm text-red-600" v-html="form.errors.is_national"/>
                </label>

                <!-- County -->
                <Select
                    class="w-full z-101"
                    :label="$t('counties_label')"
                    type="object"
                    v-if="!form.is_national"
                    :options="counties"
                    v-model="form.counties"
                    :error="form.errors['counties']"
                    multiple
                />

                <Textarea
                    class="w-full"
                    :label="$t('project_description_label')"
                    id="about-project"
                    color="gray-700"
                    numberOfCharacters=800
                    v-model="form.description"
                    :error="form.errors.description"
                    :more-info="$t('project_description_extra')"
                />

                <Textarea
                    class="w-full"
                    :label="$t('project_scope_label')"
                    id="project-scope"
                    color="gray-700"
                    v-model="form.scope"
                    :error="form.errors.scope"
                    :more-info="$t('project_scope_extra')"
                />

                <!-- Project beneficiary -->
                <Textarea
                    class="w-full"
                    :label="$t('project_beneficiary_label')"
                    id="project-beneficiary"
                    color="gray-700"
                    v-model="form.beneficiaries"
                    :error="form.errors.beneficiaries"
                    :more-info="$t('project_beneficiary_extra')"
                />

                <!-- Why to donate -->
                <Textarea
                    class="w-full"
                    :label="$t('why_to_donate')"
                    id="why-to-donate"
                    color="gray-700"
                    v-model="form.reason_to_donate"
                    :error="form.errors.reason_to_donate"
                    :more-info="$t('why_to_donate_extra')"
                />

                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.accepting_volunteers" />
                    <span class="ml-2 text-sm text-gray-700" v-html="$t('has_volunteers_label')"/>
                    <p v-show="form.errors.accepting_volunteers" class="mt-2 text-sm text-red-600" v-html="form.errors.accepting_volunteers"/>
                </label>

                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.accepting_comments" />
                    <span class="ml-2 text-sm text-gray-700" v-html="$t('has_comments_label')"/>
                    <p v-show="form.errors.accepting_comments" class="mt-2 text-sm text-red-600" v-html="form.errors.accepting_comments"/>
                </label>

                <label class="flex items-center">
                    <FileInput  v-model="form.preview"  :label="$t('project.labels.preview_image')" accept=""
                                @upload="(file)=>form.preview=file"
                                previewable
                    />
                    <p v-show="form.errors.preview" class="mt-2 text-sm text-red-600" v-html="form.errors.preview"/>

                </label>

                <FileGroup v-model="form.gallery" :label="$t('photo_gallery')" />
                <div>
                    <p class="text-lg font-medium leading-5 text-gray-900">{{ $t('project.labels.videos') }}</p>
                    <p class="text-sm leading-5 text-gray-700">{{ $t('project.labels.videos_extra') }}</p>
                </div>
                <div>
                    <div class="flex w-full border-t border-gray-300 pb-1.5" v-for="(item, index) in videos" :key="index">
                        <Input
                            class="w-1/2"
                            :label="$t('video_link_label')"
                            color="gray-700"
                            type="text"
                            v-model="item.url"
                            :error = "arrayError('videos.'+index+'.url')"
                        />
                        <DangerButton
                            class="mt-8 ml-4"
                            type="button"
                            hover="red-400"
                            color="white"
                            @click="() => {videos.pop();}"
                            v-text="$t('remove')"
                        />
                    </div>
                    <SecondaryButton
                        class="mt-8 ml-4"
                        hover="primary-400"
                        color="white"
                        @click="() => {videos.push({ url: '' });}"
                        v-text="$t('add')"
                    />

                </div>
                <div class="w-full border-t border-gray-300"></div>


                <div>
                    <p class="text-lg font-medium leading-5 text-gray-900">{{ $t('external_links_title') }}</p>
                    <p class="text-sm leading-5 text-gray-700">{{ $t('external_links_text') }}</p>
                </div>
                <div>
                    <div class="flex w-full border-t border-gray-300" v-for="(item, index) in external_links" :key="index">
                        <Input
                            class="w-1/3"
                            :label="$t('project.labels.external_links_title')"
                            color="gray-700"
                            type="text"
                            :error = "arrayError('external_links.'+index+'.title')"
                            v-model="item.title"
                        />
                        <Input
                            class="w-1/3 ml-1.5"
                            :label="$t('project.labels.external_links_url')"
                            color="gray-700"
                            icon="https://"
                            type="text"
                            :error = "arrayError('external_links.'+index+'.url')"
                            v-model="item.url"
                        />
                        <DangerButton
                            class="mt-8 ml-4"
                            background="red-500"
                            hover="red-400"
                            color="white"
                            @click="() => external_links.pop()"
                            v-text="$t('remove')"
                        />
                    </div>
                    <SecondaryButton
                        class="mt-8 ml-4"
                        hover="primary-400"
                        color="white"
                        @click="() => external_links.push({ url: '',title:'' })"
                        v-text="$t('add')"
                    />
                    <div class="w-full border-t border-gray-300" />
                </div>



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
import FileInput from "@/Components/form/FileInput.vue";

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
    preview: null,
    gallery: [],
    videos: [],
    external_links: [],
});
const props = defineProps(['projectCategories', 'counties']);
const  external_links = ref(form.external_links)
const  videos = ref(form.videos)

/** Create project. */
const createProject = () => {

    form.post(route('dashboard.projects.store'), {
        preserveScroll: true,
        onError: () => {},
    });
};
function arrayError(key) {
    if (form.errors[key]) {
        return form.errors[key];
    }
    return null;
}
</script>
