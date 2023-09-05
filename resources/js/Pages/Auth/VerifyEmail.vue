<template>
    <PageLayout>
        <div class="grid min-h-full grid-cols-12">
            <div class="flex flex-col col-span-12 px-4 mt-20 lg:col-span-6 sm:px-6 lg:flex-none lg:px-16 xl:px-24 xl:mx-10 2xl:mx-20">
                <div class="w-full mx-auto mb-64">
                    <div>
                        <h1 class=" font-extrabold tracking-tight text-cyan-900">{{ $t("verify_email_title") }}</h1>

                        <p class="mt-6 leading-6 text-gray-600">
                            {{ $t("verify_email_description") }}
                        </p>
                        <p class="mt-2 leading-6 text-danger-700">
                            {{ $t("verify_email_warning") }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="sticky top-0 left-0 hidden h-screen lg:col-span-6 lg:block">
                <img class="absolute inset-0 object-cover w-full h-full" src="/images/auth_image.jpg" alt="Auth image" />
            </div>
        </div>
    </PageLayout>

</template>
<script setup>
import PageLayout from "@/Layouts/PageLayout.vue";
</script>
