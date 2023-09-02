<template>
    <div class="flex flex-col min-h-screen">
        <Navbar />

        <div class="grid flex-1 gap-y-10">
            <slot />
        </div>

        <Footer />
    </div>
</template>

<script setup>
    import Navbar from '@/Components/Navbar.vue';
    import Footer from '@/Components/Footer.vue';
</script>
