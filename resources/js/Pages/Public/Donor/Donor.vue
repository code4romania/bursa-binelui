<template>
    <PageLayout>
        <!-- Inertia page head -->
        <Head :title="$t('thank_you')" />

        <div class="p-9 mx-auto max-w-7xl mb-10">
            <form :action="props.data.payment_url" method="post" id="paymentForm">
                <div v-for="(value, key) in props.data">
                    <input type="hidden" :name="key" :value="value">
                </div>
            </form>

        </div>
    </PageLayout>
</template>

<script setup>

    /** Import from inertia. */
    import {Head, Link, useForm} from '@inertiajs/vue3';
    const  props = defineProps({
        data: Object,
    });
    onMounted(() => {
        // console.log(props.data);
        document.getElementById('paymentForm').submit();

    });


    /** Import components. */
    import PageLayout from '@/Layouts/PageLayout.vue';
    import {onMounted} from "vue";
</script>
