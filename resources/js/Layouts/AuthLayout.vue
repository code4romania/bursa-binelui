<template>
    <PageLayout>
        <Head :title="title" />

        <div class="flex flex-1 min-h-full -mb-32">
            <div class="flex flex-col flex-1 px-4 py-20 lg:flex-none lg:px-20 sm:px-6 xl:px-24">
                <div class="w-full max-w-sm mx-auto lg:w-96 xl:w-128 xl:max-w-xl">
                    <div>
                        <h1
                            class="mb-6 text-4xl font-extrabold tracking-tight text-cyan-900 sm:text-4xl"
                            v-text="title"
                        />

                        <div class="flex flex-wrap gap-1 text-sm leading-6 text-gray-600 sm:text-base">
                            <span v-if="description" v-text="description" />

                            <Link
                                v-if="actionUrl && actionUrl"
                                :href="actionUrl"
                                class="text-primary-600 hover:text-primary-500 hover:underline"
                            >
                                {{ actionText }}
                            </Link>
                        </div>
                    </div>

                    <Alert v-if="$page.props.status" type="success" :message="$page.props.status" />

                    <slot />
                </div>
            </div>

            <div class="relative flex-1 hidden w-0 min-h-screen lg:block">
                <img
                    class="absolute inset-0 object-cover w-full h-full"
                    src="../../../resources/images/login.jpg"
                    alt=""
                />
            </div>
        </div>
    </PageLayout>
</template>

<script setup>
    import PageLayout from '@/Layouts/PageLayout.vue';
    import Alert from '@/Components/Alert.vue';
    import Head from '@/Components/Head.vue';

    defineProps({
        title: {
            type: String,
            required: true,
        },
        description: {
            type: String,
            default: null,
        },
        actionText: {
            type: String,
            default: null,
        },
        actionUrl: {
            type: String,
            default: null,
        },
    });
</script>

