<template>
    <article class="flex flex-col overflow-hidden bg-white rounded-lg drop-shadow-lg">
        <Link
            :href="project.type === 'project' ? route('projects.show', project) : route('bcr.show', project)"
            class="relative w-full overflow-hidden group aspect-w-5 aspect-h-3 drop-shadow-sm"
        >
            <img
                :src="project.image"
                class="object-cover object-center w-full transition-opacity duration-150 group-hover:opacity-75"
                :class="{
                    grayscale: !project.is_active && project.type !== 'bcr_project',
                }"
                alt=""
            />

            <div class="flex flex-col items-start justify-end gap-2 p-3" v-show="project.type === 'project'">
                <ProjectTag v-if="project.is_pending" :label="$t('project_waiting_for_approval')" />
                <ProjectTag v-else-if="project.is_draft" :label="$t('project_draft')" />

                <ProjectTag
                    v-else-if="project.is_starting_soon"
                    :label="$t('project_starting_soon')"
                    :icon="ClockIcon"
                />
                <ProjectTag
                    v-else-if="project.is_active && project.is_ending_soon"
                    :label="$t('project_ending_soon')"
                    :icon="ClockIcon"
                />

                <ProjectTag v-else-if="project.is_active" :label="$t('project_active')" :icon="ClockIcon" />
                <ProjectTag v-else-if="project.is_archived" :label="$t('projects.status.archived')" :icon="ClockIcon" />
                <ProjectTag v-else-if="!project.is_active && !project.is_rejected" :label="$t('project_closed')" />
                <ProjectTag v-if="project.is_rejected" :label="$t('project_rejected')" />

                <!--                <div v-if="project.is_active && project.championship" class="flex flex-wrap items-center gap-1">-->
                <!--                    <ProjectTag-->
                <!--                        v-if="project.championship.troffees_count"-->
                <!--                        :label="project.championship.troffees_count"-->
                <!--                        icon="troffee"-->
                <!--                        accent-->
                <!--                    />-->

                <!--                    <ProjectTag v-if="project.championship.score" accent>-->
                <!--                        <span class="font-bold" v-text="$t('scor')" />-->
                <!--                        <span class="font-extrabold" v-text="project.championship.score" />-->
                <!--                    </ProjectTag>-->
                <!--                </div>-->
            </div>
        </Link>

        <div class="flex-1 p-6 text-left">
            <Link
                v-if="project.type === 'project'"
                :href="route('organizations.show', project.organization)"
                class="inline-block mb-4 font-medium text-black/75 hover:underline"
            >
                {{ project.organization.name }}
            </Link>

            <h1 class="text-xl font-extrabold text-gray-700 sm:text-2xl md:text-xl 2xl:text-2xl line-clamp-2">
                <Link :href="project.type === 'project' ? route('projects.show', project) : route('bcr.show', project)">
                    {{ project.name }}
                </Link>
            </h1>

            <div class="flex items-center gap-5 text-sm font-medium">
                <div v-if="project.county" class="flex items-center gap-1 truncate">
                    <LocationMarkerIcon class="w-4 h-4 text-gray-500 shrink-0" />
                    <span class="text-gray-700" v-text="project.county" />
                </div>

                <div v-if="project.categories" class="flex items-center gap-1 truncate">
                    <BookmarkIcon class="w-4 h-4 text-gray-500 shrink-0" />
                    <span class="text-gray-700 truncate">{{ project.categories }}</span>
                </div>
            </div>

            <template v-if="!project.is_archived">
                <div
                    v-if="'admin' == cardType"
                    class="flex mt-4 overflow-hidden border border-gray-300 divide-x divide-gray-300 rounded-md shadow-sm"
                >
                    <Link
                        :href="route('projects.show', project)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t('view') }}
                    </Link>

                    <Link
                        v-if="project.type !== 'regional'"
                        :href="route('dashboard.projects.edit', project.id)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t('edit') }}
                    </Link>
                    <Link
                        v-if="project.type === 'regional'"
                        :href="route('dashboard.projects.gala.edit', project.id)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t('edit') }}
                    </Link>
                </div>
            </template>

            <SecondaryButton
                v-if="'admin' == cardType && project.can_be_archived"
                class="w-full mt-4 py-2.5"
                @click="changeProjectStatus(project.id, 'archived', project.type)"
                :label="$t('can.be.archived')"
            />
            <!-- Donate modal -->
            <DonateModal
                v-if="'client' == cardType && 0 < project_end_date"
                triggerModalClasses="bg-primary-500 w-full mt-8 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                :triggerModalText="$t('donate_btn')"
                :data="project"
            />

            <!-- Donate Error modal -->
            <Modal
                v-if="'client' == cardType && 0 > project_end_date"
                triggerModalClasses="bg-primary-500 w-full mt-8 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                :triggerModalText="$t('donate_btn')"
                id="project-donation-expired"
            >
                <div class="w-full mt-6">
                    <h3 class="text-xl font-semibold text-center text-gray-800">
                        {{ $t('donation_period_ended') }}
                    </h3>
                    <h3 class="text-xl font-semibold text-center text-primary-500">
                        {{ $t('donate_to_other_projects') }}
                    </h3>
                    <Link
                        :href="route('projects.index')"
                        class="rounded-md block mt-6 text-center bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm"
                    >
                        {{ $t('see_other_projects') }}
                    </Link>
                </div>
            </Modal>
        </div>

        <div class="px-6 pb-6" v-if="project.donations">
            <div class="flex items-center justify-between mb-1 text-lg font-bold">
                <p class="text-primary-900" v-text="project.donations.total" />
                <p class="text-primary-500" v-text="project.donations.target" />
            </div>

            <progress
                class="w-full h-5 progress-unfilled:bg-gray-200"
                :class="[
                    project.donations.percentage >= 100
                        ? 'progress-filled:bg-primary-500'
                        : 'progress-filled:bg-primary-900',
                ]"
                :value="project.donations.percentage"
                max="100"
            >
                {{ project.donations.percentage }}%
            </progress>
        </div>
    </article>
</template>

<script setup>
import { computed, onMounted } from 'vue';
import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
import DonateModal from '@/Components/modals/DonateModal.vue';
import Modal from '@/Components/modals/Modal.vue';
import ProjectTag from '@/Components/projects/Tag.vue';

import { BookmarkIcon, LocationMarkerIcon, ClockIcon } from '@heroicons/vue/solid';
import { trans } from 'laravel-vue-i18n';
import { useForm } from '@inertiajs/vue3';
import route from '@/Helpers/useRoute.js';

/** Component props. */
const props = defineProps({
    project: Object,
    cardType: String,
});
const form = useForm({
    status: null,
});

const changeProjectStatus = (id, status, type) => {
    let tmpRoute =
        type === 'regional' ? route('dashboard.projects.gala.status', id) : route('dashboard.projects.status', id);
    form.status = status;
    console.log(form);
    if (confirm(trans('project_change_status_' + status))) {
        form.post(tmpRoute, {
            preserveScroll: true,
            onSuccess: (response) => {
                //
            },
        });
    }
};

/** Get days till project ends. */
const project_end_date = computed(() => {
    const targetDate = new Date(props.project.end);
    const today = new Date();
    const timeDiff = targetDate.getTime() - today.getTime();
    const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

    return daysDiff;
});
</script>
