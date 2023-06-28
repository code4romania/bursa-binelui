<template>
    <li
        class="flex flex-col col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow"
    >
        <div class="flex flex-col flex-1">
            <Link
                :href="route('project', data.slug)"
                class="relative bg-gray-200 group-hover:opacity-75 sm:h-52"
            >

                <img
                    :src="data.cover_image!=='' ?data.cover_image: 'https://images.unsplash.com/photo-1508779544523-dd1b27685be3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80'"
                    alt="imagine proiect"
                    class="object-cover object-center w-full h-full rounded-t-lg sm:h-full sm:w-full"
                />

                <div class="absolute z-10 flex flex-wrap gap-2 bottom-3 left-3">
                    <div
                        v-if="data.troffes && data.active"
                        class="inline-flex items-center px-3 py-1 text-base font-bold text-white bg-red-500 rounded-full gap-x-2"
                    >
                        <SvgLoader class="shrink-0" name="troffe" />
                        {{ data.troffes }}
                    </div>

                    <div
                        v-if="data.scor && 'closed' && data.active"
                        class="inline-flex items-center px-3 py-1 text-base text-white bg-red-500 rounded-full gap-x-1"
                    >
                        <p class="font-bold">{{ $t("scor") }}</p>
                        <p class="font-bold">{{ data.scor }}</p>
                    </div>

                    <div
                        v-if="!data.active"
                        class="inline-flex items-center px-3 py-1 text-base text-white rounded-full gap-x-1 bg-primary-500"
                    >
                        <p class="font-bold">{{ $t("project_closed") }}</p>
                    </div>
                </div>

                <!-- Overlay -->
                <div
                    v-if="!data.active"
                    class="absolute top-0 left-0 z-40 w-full h-full bg-gray-500 rounded-t-lg opacity-40"
                ></div>
            </Link>

            <div class="p-6">
                <div class="pb-4 text-base font-medium text-gray-700">{{ data.organization?.name }}</div>

                <Link
                    :href="route('project', data.slug)"
                    class="mt-4 text-2xl font-bold text-gray-700"
                >
                    {{ data.name }}
                </Link>

                <div class="flex items-center gap-5 mt-1 text-base font-medium text-gray-700">
                    <div v-if="data.county" class="flex items-center gap-1">
                        <SvgLoader class="shrink-0" name="location" />
                        {{ data.county.name }}
                    </div>

                    <div v-if="data.activity_domains" class="flex items-center gap-1">
                        <SvgLoader class="shrink-0" name="activity" />
                        <span class="w-20 truncate lg:w-40">{{ data.activity_domains.join(',') }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <div
                        class="flex items-center justify-between mb-1 text-xl font-bold"
                    >
                        <p class="text-cyan-900">
                            {{ data.total_donations }} {{ $t("currency") }}
                        </p>
                        <p class="text-primary-500">
                            {{ data.target_budget }} {{ $t("currency") }}
                        </p>
                    </div>

                    <div class="w-full h-5 bg-gray-200">
                        <div
                            :class="[
                                `h-5`,
                                data.total_donations >= data.target_budget
                                    ? 'bg-primary-500'
                                    : 'bg-cyan-900',
                            ]"
                            :style="`width: ${percentage}%`"
                        ></div>
                    </div>
                </div>

                <div
                    v-if="'admin' == cardType"
                    class="flex mt-4 border border-gray-300 divide-x divide-gray-300 rounded-md shadow-sm"
                >
                    <Link
                        :href="route('project', data.id)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t("view") }}
                    </Link>

                    <Link
                        :href="route('admin.ong.project.edit', data.id)"
                        class="w-1/2 text-center px-3.5 py-2.5 text-sm font-semibold text-gray-900 bg-white hover:bg-gray-50"
                    >
                        {{ $t("edit") }}
                    </Link>
                </div>

                <SecondaryButton
                    v-if="'admin' == cardType && 'active' == data.status"
                    class="w-full mt-4 py-2.5"
                >
                    {{ $t("draft") }}
                </SecondaryButton>

                <SecondaryButton
                    v-if="'admin' == cardType && 'draft' == data.status"
                    class="w-full mt-4 py-2.5 text-primary-500 ring-1 ring-inset ring-primary-500 hover:bg-primary-400"
                >
                    {{ $t("publish") }}
                </SecondaryButton>

                <!-- Donate modal -->
                <DonateModal
                    v-if="('client' == cardType) && (0 < project_end_date)"
                    triggerModalClasses="bg-primary-500 w-full mt-8 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    :triggerModalText="$t('donate_btn')"
                    :data="data"
                />

                <!-- Donate Error modal -->
                <Modal
                    v-if="('client' == cardType) && (0 > project_end_date)"
                    triggerModalClasses="bg-primary-500 w-full mt-8 hover:bg-primary-400 text-white focus-visible:outline-primary-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    :triggerModalText="$t('donate_btn')"
                    id="project-donation-expired"
                >
                    <div class="w-full mt-6">
                        <h3 class="text-xl font-semibold text-center text-gray-800">{{ $t('donation_period_ended') }}</h3>
                        <h3 class="text-xl font-semibold text-center text-primary-500">{{ $t('donate_to_other_projects') }}</h3>
                        <Link
                            :href="route('projects')"
                            class="rounded-md block mt-6 text-center bg-primary-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm"
                        >
                            {{ $t('see_other_projects') }}
                        </Link>
                    </div>
                </Modal>
            </div>
        </div>
    </li>
</template>

<script setup>
import {computed, onMounted} from "vue";

    /** Import from inertia. */
    import { Link } from "@inertiajs/vue3";

    /** Import components. */
    import SvgLoader from "@/Components/SvgLoader.vue";
    import SecondaryButton from "@/Components/buttons/SecondaryButton.vue";
    import DonateModal from '@/Components/modals/DonateModal.vue';
    import Modal from '@/Components/modals/Modal.vue';

    /** Component props. */
    const props = defineProps({
        data: Object,
        cardType: String,
    });

    onMounted(() => {

    });

    const percentage = computed(() => {
        if (props.data.total_donations > props.data.target_budget) {
            return 100;
        }

        return (props.data.total_donations / props.data.target_budget) * 100;
    });

    /** Get days till project ends. */
    const project_end_date = computed(() => {
        const targetDate = new Date(props.data.period_end);
        const today = new Date();
        const timeDiff = targetDate.getTime() - today.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

        return daysDiff;
    })
</script>
