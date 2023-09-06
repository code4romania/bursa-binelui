<template>
    <PageLayout>
        <Head title="Verify Email" />

        <Auth
            :content="{
                title: $t('verify_email_title'),
                description: $t('verify_email_description'),
            }"
        >
            <Alert type="warning" :message="$t('verify_email_warning')" />
        </Auth>
    </PageLayout>
</template>
<script setup>
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Alert from '@/Components/Alert.vue';
    import Auth from '@/Components/templates/Auth.vue';
</script>
