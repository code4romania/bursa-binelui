<template>
    <div>
        <h3 class="text-sm font-semibold leading-5 text-gray-400" v-text="$t('newsletter_subscribe_title')" />

        <p class="mt-4 mb-6 text-sm leading-6 text-gray-400" v-text="$t('newsletter_subscribe_text')" />

        <div v-if="hasSubscribed" class="w-full p-3 overflow-hidden bg-white rounded">
            <div class="flex items-center gap-3">
                <CheckCircleIcon class="w-5 h-5 text-green-500 shrink-0" aria-hidden="true" />

                <div class="flex-1 w-0">
                    <p class="text-sm text-gray-900" v-text="$t('newsletter_subscribed')" />
                </div>
            </div>
        </div>

        <form v-else class="items-start sm:flex sm:max-w-md" @submit.prevent="subscribe">
            <Input
                placeholder="Adresa de email"
                type="text"
                color="white"
                v-model="form.email"
                :error="form?.errors?.email"
                is-required
                class="flex-1"
            />

            <div class="mt-4 sm:ml-4 sm:mt-0 sm:flex-shrink-0">
                <PrimaryButton type="submit" :disabled="form.processing" :label="$t('subscribe')" />
            </div>
        </form>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    /** Import componets. */
    import Input from '@/Components/form/Input.vue';
    import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
    import route from '@/Helpers/useRoute.js';
    import { CheckCircleIcon } from '@heroicons/vue/solid';

    const hasSubscribed = ref(false);

    /** Form variables. */
    const form = useForm({
        email: null,
    });

    /** Subscribe action. */
    const subscribe = () => {
        form.post(route('newsletter'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset('email');
                hasSubscribed.value = true;
            },
        });
    };
</script>
