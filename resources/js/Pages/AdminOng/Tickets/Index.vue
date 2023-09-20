<template>
    <DashboardLayout>
        <div class="flex flex-wrap">
            <Link
                :href="route('dashboard.tickets.index', { status: 'open' })"
                :class="[
                    'py-2.5 px-3.5 text-sm font-semibold',
                    route().current('dashboard.tickets.index', {
                        status: 'open',
                    })
                        ? 'bg-primary-500 text-white'
                        : 'bg-primary-50 text-primary-500',
                ]"
            >
                {{ $t('open_tickets') }}
            </Link>

            <Link
                :href="
                    route('dashboard.tickets.index', {
                        status: 'closed',
                    })
                "
                :class="[
                    'py-2.5 px-3.5 text-sm font-semibold',
                    route().current('dashboard.tickets.index', {
                        status: 'closed',
                    })
                        ? 'bg-primary-500 text-white'
                        : 'bg-primary-50 text-primary-500',
                ]"
            >
                {{ $t('closed_tickets') }}
            </Link>
        </div>

        <div v-if="isOpen">
            <Modal :title="$t('add_ticket')" :form="form" :formUrl="route('dashboard.tickets.store')">
                <template #trigger="{ open }">
                    <SecondaryButton @click="open" :label="$t('add_ticket')" />
                </template>

                <Input
                    class="w-full"
                    :label="$t('subject')"
                    color="gray-700"
                    id="subject"
                    type="text"
                    v-model="form.subject"
                    :error="form.errors.subject"
                    is-required
                />

                <Textarea
                    class="w-full"
                    :label="$t('message')"
                    id="content"
                    color="gray-700"
                    v-model="form.content"
                    :error="form.errors.content"
                    is-required
                />

                <template #actions="{ close }">
                    <PrimaryButton type="submit" :label="$t('send')" />

                    <SecondaryButton @click="close" class="py-2.5" :label="$t('cancel')" />
                </template>
            </Modal>
        </div>

        <Title :title="isOpen ? $t('open_tickets') : $t('closed_tickets')" :icon="AnnotationIcon" />

        <Table :collection="collection">
            <template #id="{ id }"> #{{ id }} </template>

            <template #actions="{ row }">
                <Link class="text-sm font-medium text-primary-600" :href="route('dashboard.tickets.view', row.id)">
                    {{ $t('view') }}
                </Link>
            </template>
        </Table>
    </DashboardLayout>
</template>

<script setup>
    import { computed } from 'vue';

    /** Import from inertia. */
    import { useForm } from '@inertiajs/vue3';

    import DashboardLayout from '@/Layouts/DashboardLayout.vue';
    import Title from '@/Components/Title.vue';
    import Table from '@/Components/tables/Table.vue';
    import Modal from '@/Components/modals/Modal.vue';
    import SecondaryButton from '@/Components/buttons/SecondaryButton.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import Textarea from '@/Components/form/Textarea.vue';
    import Input from '@/Components/form/Input.vue';

    import { AnnotationIcon } from '@heroicons/vue/outline';

    const props = defineProps({
        status: {
            type: String,
        },
        collection: {
            type: Object,
        },
    });

    const form = useForm({
        subject: '',
        content: '',
    });

    const isOpen = computed(() => props.status === 'open');
</script>
