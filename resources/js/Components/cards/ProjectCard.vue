<template>
    <li
        class="flex flex-col col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow"
    >
        <div class="flex flex-col flex-1">
            <Link
                :href="route('project', data.id)"
                class="relative bg-gray-200 group-hover:opacity-75 sm:h-52"
            >

                <img
                    :src="data.image_url"
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
                        class="inline-flex items-center px-3 py-1 text-base text-white rounded-full gap-x-1 bg-turqoise-500"
                    >
                        <p class="font-bold">{{ $t("project_closed") }}</p>
                    </div>
                </div>

                <!-- Overlay -->
                <div
                    v-if="!data.active"
                    class="absolute top-0 left-0 w-full h-full bg-gray-500 rounded-t-lg z-40 opacity-40"
                ></div>
            </Link>

            <div class="p-6">
                <div class="text-base font-medium text-gray-700 pb-4">{{ data.ong.name }}</div>

                <Link
                    :href="route('project', data.id)"
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
                        <span class="truncate w-20 lg:w-40">{{ data.activity_domains.join(',') }}</span>
                    </div>
                </div>

                <div class="mt-8">
                    <div
                        class="flex items-center justify-between mb-1 text-xl font-bold"
                    >
                        <p class="text-cyan-900">
                            {{ data.current_amount }} {{ $t("currency") }}
                        </p>
                        <p class="text-turqoise-500">
                            {{ data.max_amount }} {{ $t("currency") }}
                        </p>
                    </div>

                    <div class="w-full h-5 bg-gray-200 dark:bg-gray-700">
                        <div
                            :class="[
                                `h-5`,
                                data.currentAmount == data.maxAmount
                                    ? 'bg-turqoise-500'
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
                    v-if="'admin' == cardType && 'published' == data.status"
                    class="w-full mt-4 py-2.5"
                >
                    {{ $t("draft") }}
                </SecondaryButton>

                <SecondaryButton
                    v-if="'admin' == cardType && 'draft' == data.status"
                    class="w-full mt-4 py-2.5 text-turqoise-500 ring-1 ring-inset ring-turqoise-500 hover:bg-turqoise-400"
                >
                    {{ $t("publish") }}
                </SecondaryButton>

                <!-- Donate modal -->
                <DonateModal
                    v-if="('client' == cardType) && (0 < project_end_date)"
                    triggerModalClasses="bg-turqoise-500 w-full mt-8 hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    :triggerModalText="$t('donate_btn')"
                    :data="data"
                />

                <!-- Donate Error modal -->
                <Modal
                    v-if="('client' == cardType) && (0 > project_end_date)"
                    triggerModalClasses="bg-turqoise-500 w-full mt-8 hover:bg-turqoise-400 text-white focus-visible:outline-turqoise-500 rounded-md px-3.5 py-2.5 text-sm font-semibold shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    :triggerModalText="$t('donate_btn')"
                    id="project-donation-expired"
                >
                    <div class="mt-6 w-full">
                        <h3 class="text-center text-xl font-semibold text-gray-800">{{ $t('donation_period_ended') }}</h3>
                        <h3 class="text-center text-xl font-semibold text-turqoise-500">{{ $t('donate_to_other_projects') }}</h3>
                        <Link
                            :href="route('projects')"
                            class="rounded-md block mt-6 text-center bg-turqoise-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm"
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
    import { computed } from "vue";

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

    const percentage = computed(() => (props.data.current_amount / props.data.max_amount) * 100);

    /** Get days till project ends. */
    const project_end_date = computed(() => {
        const targetDate = new Date(props.data.period_end);
        const today = new Date();
        const timeDiff = targetDate.getTime() - today.getTime();
        const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

        return daysDiff;
    })
</script>
