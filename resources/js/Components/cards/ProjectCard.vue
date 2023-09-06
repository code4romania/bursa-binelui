<template>
    <article class="flex flex-col overflow-hidden bg-white divide-y divide-gray-200 rounded-lg drop-shadow-lg">
        <Link
            :href="route('project', project.slug)"
            class="relative w-full overflow-hidden group aspect-w-5 aspect-h-3"
        >
            <img
                :src="project.image"
                class="object-cover object-center w-full transition-opacity duration-150 group-hover:opacity-75"
                :class="{
                    grayscale: !project.is_active,
                }"
                alt=""
            />

            <div class="flex flex-col items-start justify-end gap-2 p-3">
                <ProjectTag v-if="!project.is_active" :label="$t('project_closed')" />

                <div v-if="project.is_active && project.championship" class="flex flex-wrap items-center gap-1">
                    <ProjectTag
                        v-if="project.championship.troffees_count"
                        :label="project.championship.troffees_count"
                        icon="troffee"
                        accent
                    />

                    <ProjectTag v-if="project.championship.score" accent>
                        <span class="font-bold" v-text="$t('scor')" />
                        <span class="font-extrabold" v-text="project.championship.score" />
                    </ProjectTag>
                </div>

                <ProjectTag
                    v-if="project.is_active && project.is_ending_soon"
                    :label="$t('project_ending_soon')"
                    icon="clock"
                />
            </div>
        </Link>

        <div class="p-6 text-left">
            <Link
                :href="route('organization', project.organization.id)"
                class="inline-block mb-4 font-medium text-black/75 hover:underline"
            >
                {{ project.organization.name }}
            </Link>

            <h1 class="text-xl font-extrabold text-gray-700 sm:text-2xl md:text-xl 2xl:text-2xl">
                <Link :href="route('project', project.slug)">
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

            <div class="mt-8" v-if="project.donations">
                <div class="flex items-center justify-between mb-1 text-lg font-bold">
                    <p class="text-cyan-900" v-text="project.donations.total" />
                    <p class="text-primary-500" v-text="project.donations.target" />
                </div>

                <div class="w-full h-5 bg-gray-200">
                    <div
                        :class="[`h-5`, project.donations.percentage >= 100 ? 'bg-primary-500' : 'bg-cyan-900']"
                        :style="{
                            width: `${project.donations.percentage}%`,
                        }"
                    ></div>
                </div>
            </div>

            <div
                v-if="'admin' == cardType"
                class="flex mt-4 border border-gray-300 divide-x divide-gray-300 rounded-md shadow-sm"
            >
                <Link
                    :href="route('project', project.slug)"
                    class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                >
                    {{ $t('view') }}
                </Link>

                <Link
                    v-if="project.type !== 'regional'"
                    :href="route('admin.ong.project.edit', project.id)"
                    class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                >
                    {{ $t('edit') }}
                </Link>
                <Link
                    v-if="project.type === 'regional'"
                    :href="route('admin.ong.regional.project.edit', project.id)"
                    class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                >
                    {{ $t('edit') }}
                </Link>
            </div>

            <SecondaryButton
                v-if="'admin' == cardType && 'pending' == project.status"
                class="w-full mt-4 py-2.5"
                @click="changeProjectStatus(project.id, 'draft', project.type)"
            >
                {{ $t('draft') }}
            </SecondaryButton>

            <SecondaryButton
                v-if="'admin' == cardType && 'draft' == project.status"
                class="w-full mt-4 py-2.5 text-primary-500 ring-1 ring-inset ring-primary-500 hover:bg-primary-400"
                @click="changeProjectStatus(project.id, 'pending', project.type)"
            >
                {{ $t('publish') }}
            </SecondaryButton>

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
                        :href="route('projects')"
                        class="rounded-md block mt-6 text-center bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm"
                    >
                        {{ $t('see_other_projects') }}
                    </Link>
                </div>
            </Modal>
        </div>
    </article>
</template>

<script setup>
    import { computed, onMounted } from 'vue';

    /** Import from inertia. */
    import { Link, useForm } from '@inertiajs/vue3';

    /** Import components. */
    import Icon from '@/Components/Icon.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import ProjectTag from '@/Components/projects/Tag.vue';

    import { BookmarkIcon, LocationMarkerIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        project: Object,
        cardType: String,
    });

    const percentage = computed(() => {
        if (props.project.total_donations > props.project.target_budget) {
            return 100;
        }

        return (props.project.total_donations / props.project.target_budget) * 100;
    });

    /** Get days till project ends. */
    const project_end_date = computed(() => {
        const targetDate = new Date(props.project.end);
        const today = new Date();
        const timeDiff = targetDate.getTime() - today.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

        return daysDiff;
    });
    const changeProjectStatus = (id, status, type) => {
        let form = useForm({
            status: status,
            id: id,
        });
        console.log(type);
        let tmpRoute =
            type === 'regional'
                ? route('admin.ong.regional.project.change-status', id)
                : route('admin.ong.project.change-status', id);
        if (confirm('Are you sure you want to change the status of this project?')) {
            form.post(tmpRoute);
        }
    };
</script>
