<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div class="mx-auto mb-10 p-9 max-w-7xl">
            <form :action="props.data.payment_url" method="post" id="paymentForm">
                <div v-for="(value, key) in props.data" :key="key">
                    <input type="hidden" :name="key" :value="value" />
                </div>
            </form>
        </div>
    </PageLayout>
</template>

<script setup>
    import Head from '@/Components/Head.vue';
    import PageLayout from '@/Layouts/PageLayout.vue';
    import { onMounted } from 'vue';

    const props = defineProps({
        data: Object,
    });
    onMounted(() => {
        document.getElementById('paymentForm').submit();
    });
</script>
