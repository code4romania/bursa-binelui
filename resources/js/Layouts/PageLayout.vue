<template>
    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        <Navbar />

        <!-- Page content -->
        <div class="flex-grow">
            <slot />
        </div>

        <!-- Footer -->
        <Footer />
    </div>
</template>

<script setup>
    /** Import components */
    import Navbar  from '@/Components/Navbar.vue';
    import Footer from '@/Components/Footer.vue';
</script>
