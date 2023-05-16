<template>
    <li
        class="flex flex-col col-span-1 bg-white divide-y divide-gray-200 rounded-lg shadow"
    >
        <div class="flex flex-col flex-1">
            <div
                class="relative bg-gray-200 aspect-h-3 aspect-w-3 sm:aspect-none group-hover:opacity-75 sm:h-52"
            >
                <img
                    :src="data.imageUrl"
                    alt=""
                    class="object-cover object-center w-full h-full rounded-t-lg sm:h-full sm:w-full"
                />

                <div class="absolute z-40 flex flex-wrap gap-2 bottom-3 left-3">
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
                    class="absolute top-0 left-0 w-full h-full bg-gray-500 rounded-t-lg z-100 opacity-40"
                ></div>
            </div>

            <div class="p-6">
                <p class="text-base font-medium text-gray-700">
                    {{ data.name }}
                </p>

                <h3 class="mt-4 text-2xl font-bold text-gray-700">
                    {{ data.title }}
                </h3>

                <div
                    class="flex flex-wrap items-center gap-5 mt-1 text-base font-medium text-gray-700"
                >
                    <div v-if="data.county" class="flex items-center gap-1">
                        <SvgLoader class="shrink-0" name="location" />
                        {{ data.county }}
                    </div>

                    <div v-if="data.activity" class="flex items-center gap-1">
                        <SvgLoader class="shrink-0" name="activity" />
                        {{ data.activity }}
                    </div>
                </div>

                <div class="mt-5">
                    <div
                        class="flex items-center justify-between mb-1 text-xl font-bold"
                    >
                        <p class="text-cyan-900">
                            {{ data.currentAmount }} {{ $t("currency") }}
                        </p>
                        <p class="text-turqoise-500">
                            {{ data.maxAmount }} {{ $t("currency") }}
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

                <Link
                    v-if="'client' == cardType"
                    :href="route('project', data.id)"
                    class="w-full block rounded-md mt-4 text-center px-3.5 py-2.5 text-sm font-semibold text-white bg-turqoise-500 hover:bg-turqoise-400"
                >
                    {{ $t("donate_btn") }}
                </Link>
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

    /** Component props. */
    const props = defineProps({
        data: Object,
        cardType: String,
    });

    const percentage = computed(
        () => (props.data.currentAmount / props.data.maxAmount) * 100
    );
</script>
