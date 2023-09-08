<template>
    <AuthLayout :title="$t('verify_email_title')" :description="$t('verify_email_description')">
        <Alert type="warning" :message="$t('verify_email_warning')" />
    </AuthLayout>
</template>

<script setup>
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    import Alert from '@/Components/Alert.vue';
    import Auth from '@/Components/templates/Auth.vue';
</script>
