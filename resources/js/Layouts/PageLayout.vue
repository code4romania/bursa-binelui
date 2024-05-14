<template>
    <div class="flex flex-col min-h-screen">
        <Navbar />
        <PontBanner />

        <Notification />

        <div class="grid flex-1 gap-y-10">
            <header v-if="title" class="container flex items-center gap-4 mt-10">
                <Icon
                    v-if="typeof icon === 'string'"
                    class="flex items-center justify-center w-10 h-10 p-2 text-white rounded-lg bg-primary-500 shrink-0"
                    :name="icon"
                />

                <component
                    v-else-if="typeof icon === 'function'"
                    :is="icon"
                    class="flex items-center justify-center w-10 h-10 p-2 text-white rounded-lg bg-primary-500 shrink-0"
                />

                <h1 class="text-2xl font-bold leading-none text-gray-900 md:text-3xl" v-text="title" />

                <Head v-if="title" :title="title" />
            </header>

            <slot />
        </div>

        <Footer class="mt-32" />
    </div>
</template>

<script setup>
    import Head from '@/Components/Head.vue';
    import Navbar from '@/Components/Navbar.vue';
    import Footer from '@/Components/Footer.vue';
    import PontBanner from '@/Components/PontBanner.vue';
    import Notification from '@/Components/Notification.vue';
    import Icon from '@/Components/Icon.vue';

    const props = defineProps({
        title: {
            type: String,
            default: null,
        },
        icon: {
            type: [String, Function],
            default: null,
        },
    });
</script>
