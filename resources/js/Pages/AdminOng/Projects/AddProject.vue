<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('add_project_title')" />

        <!-- Dashboard template -->
        <Dashboard>
           <div class="p-9 mb-24 w-full">

                <!-- Header -->
                <header class="flex items-center gap-4">
                    <div class="bg-turqoise-500 w-8 h-8 rounded-lg flex items-center justify-center">
                        <SvgLoader class="shrink-0" name="list"/>
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
                            v-model="form.project_name"
                            :error="form.errors.project_name"
                        />

                        <!-- Project main image -->

                        <!-- Project amount target -->
                        <Input
                            class="w-full xl:w-1/2"
                            :label="$t('amount_target_label')"
                            color="gray-700"
                            id="amount-target"
                            type="number"
                            v-model="form.amount_target"
                            :error="form.errors.amount_target"
                        />

                        <!-- Project category -->
                        <Select
                            class="w-full xl:w-1/2"
                            :label="$t('project_category_label')"
                            :options="project_categories"
                            v-model="form.project_category"
                            :error="form.errors.project_category"
                        />

                        <!-- Date period. -->
                        <div class="flex gap-6">

                            <!-- Date start -->
                            <Input
                                class="w-full xl:w-1/2"
                                :label="$t('project_date_start_label')"
                                color="gray-700"
                                type="date"
                                v-model="form.date_start"
                                :error="form.errors.date_start"
                            />

                            <!-- Date end -->
                            <Input
                                class="w-full xl:w-1/2"
                                :label="$t('project_date_end_label')"
                                color="gray-700"
                                type="date"
                                v-model="form.date_end"
                                :error="form.errors.date_end"
                            />
                        </div>

                        <!-- County -->
                        <Select
                            class="w-full xl:w-1/2"
                            :label="$t('counties_label')"
                            :options="counties"
                            v-model="form.county"
                            :error="form.errors.county"
                        />

                        <!-- Project description -->
                        <Textarea
                            class="w-full"
                            :label="$t('project_description_label')"
                            id="about-project"
                            color="gray-700"
                            v-model="form.project_description"
                            :error="form.errors.project_description"
                        >
                            <p class="text-sm font-normal text-gray-500">{{ $t('project_description_extra') }}</p>
                        </Textarea>

                        <!-- Project scope -->
                        <Textarea
                            class="w-full"
                            :label="$t('project_scope_label')"
                            id="project-scope"
                            color="gray-700"
                            v-model="form.project_scope"
                            :error="form.errors.project_scope"
                        >
                            <p class="text-sm font-normal text-gray-500">{{ $t('project_scope_extra') }}</p>
                        </Textarea>

                        <!-- Project beneficiary -->
                        <Textarea
                            class="w-full"
                            :label="$t('project_beneficiary_label')"
                            id="project-beneficiary"
                            color="gray-700"
                            v-model="form.project_beneficiary"
                            :error="form.errors.project_beneficiary"
                        >
                            <p class="text-sm font-normal text-gray-500">{{ $t('project_beneficiary_extra') }}</p>
                        </Textarea>

                        <!-- Why to donate -->
                        <Textarea
                            class="w-full"
                            :label="$t('why_to_donate')"
                            id="why-to-donate"
                            color="gray-700"
                            v-model="form.why_to_donate"
                            :error="form.errors.why_to_donate"
                        >
                            <p class="text-sm font-normal text-gray-500">{{ $t('why_to_donate_extra') }}</p>
                        </Textarea>

                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.has_voluntiers"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('has_voluntiers_label') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.has_voluntiers" class="mt-2 text-sm text-red-600">{{ form.errors.has_voluntiers }}</p>
                        </label>

                        <label class="flex items-center">
                            <Checkbox
                                name="remember"
                                v-model:checked="form.has_comments"
                            />
                            <span class="ml-2 text-sm text-gray-700">{{ $t('has_comments_label') }}</span>

                            <!-- Error -->
                            <p v-show="form.errors.has_comments" class="mt-2 text-sm text-red-600">{{ form.errors.has_comments }}</p>
                        </label>

                        <!-- File group -->
                        <FileGroup
                            v-model="form.file_group"
                        />

                        <!-- Project video links -->
                        <Repeater class="w-full xl:w-1/2">
                            <InputWithIcon
                                class="w-full"
                                :label="$t('video_link_label')"
                                color="gray-700"
                                icon="htpp://"
                                type="text"
                                v-model="form.project_links"
                            />
                        </Repeater>

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
    import { Head, useForm } from '@inertiajs/vue3';

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


    /** Initialize inertia from Object. */
    const form = useForm({
        project_name: '',
        amount_target: '',
        project_category: '',
        date_start: '',
        date_end: '',
        county: '',
        project_description: '',
        project_scope: '',
        project_beneficiary: '',
        why_to_donate: '',
        has_comments: true,
        has_voluntiers: true,
        file_group: [],
        project_links: [],
        project_articles: []
    });

    const project_categories = [
        "Protecția mediului",
        "Educație",
        "Sănătate",
        "Drepturile omului",
        "Dezvoltare rurală",
        "Sprijin dizabilități",
        "Egalitate de gen",
        "Reducerea sărăciei",
        "Integrarea minorităților",
        "Sprijin tineret",
        "Asistență vârstnici",
        "Patrimoniu cultural",
        "Artă și cultură",
        "Sport și recreere",
        "Dezvoltare comunitară",
        "Prevenire violență domestică",
        "Ajutor imigranți/refugiați",
        "Combatere trafic uman",
        "Bună guvernare",
        "Protecția animalelor",
        "Prevenire dependență droguri",
        "Advocacy politici publice",
        "Anti-discriminare",
        "Îmbunătățire infrastructură",
        "Antreprenoriat social",
        "Gestionare dezastre",
        "Drepturile consumatorilor",
        "Sprijin familie",
        "Promovare voluntariat",
        "Asistență juridică",
        "Protecția vieții private",
        "Combatere corupție",
        "Sănătate mintală",
        "Drepturile animalelor",
        "Cercetare științifică",
        "Dezvoltare durabilă",
        "Securitate alimentară",
        "Control boli infecțioase",
        "Sprijin veterani",
        "Dezvoltare regională/internațională"
    ];

    const counties = [];

    /** Create project. */
    const createProject = () => {
        // form.post(route('admin.ong.project.store'), {
        //     preserveScroll: true,
        //     onSuccess: () => {},
        //     onError: () => {},
        // });
    };
</script>
