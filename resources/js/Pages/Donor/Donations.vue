<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('my_donations')" />

        <div class="mx-auto my-10 space-y-10 max-w-7xl">
            <!-- Header -->
            <header class="flex items-center gap-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-primary-500">
                    <SvgLoader class="fill-primary-500 shrink-0" name="brand_icon" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $t('my_donations') }}</h2>
            </header>

            <Table
                class="mb-24"
                :columns="[$t('organization'), $t('project'), $t('date'), $t('amount')]"
                :currentPage="donations.current_page"
                :prev="donations.prev_page_url"
                :next="donations.next_page_url"
                :links="donations.links"
            >
                <tr v-for="donation in donations.data" :key="donation.id">
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ donation.organization }}</td>
                    <td class="px-3 py-4 text-sm text-gray-900 whitespace-nowrap">{{ donation.project }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ donation.created_at }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ donation.amount }}</td>
                </tr>
            </Table>
        </div>
    </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
    import { Head, Link } from '@inertiajs/vue3';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import SvgLoader from '@/Components/SvgLoader.vue';
    import Table from '@/Components/Table.vue';

    const props = defineProps({
        donations: Array,
    });
</script>
