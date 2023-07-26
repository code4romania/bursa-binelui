<template>
    <PageLayout>
        <!-- Inertia page head -->
       <Head :title="$t('password_reset')" />

       <Alert
            v-if="status"
            class="fixed right-10 top-10 w-96 z-103"
            type="success"
            :message="status"
        />

       <!-- Auth template. -->
       <Auth :content="content">
           <form class="mt-4 space-y-6 lg:mb-28" @submit.prevent="submit">
                <!-- Email -->
                <Input
                    :label="$t('email')"
                    id="email"
                    type="email"
                    v-model="form.email"
                    :isRequired="true"
                    :error="form.errors.email"
                />

                <!-- Action -->
               <div class="grid grid-cols-1">
                   <PrimaryButton
                       background="primary-500"
                       hover="primary-400"
                       color="white"
                       :class="{ 'opacity-25': form.processing }"
                       :disabled="form.processing"
                   >
                       {{ $t('password_reset') }}
                   </PrimaryButton>
               </div>
           </form>
       </Auth>
   </PageLayout>
</template>

<script setup>
    /** Import from inertia. */
   import { Head, useForm } from '@inertiajs/vue3';

   /** Import components. */
   import PageLayout from '@/Layouts/PageLayout.vue';
   import Auth from '@/Components/templates/Auth.vue';
   import PrimaryButton from '@/Components/buttons/PrimaryButton.vue';
   import Input from '@/Components/form/Input.vue';
   import Alert from '@/Components/Alert.vue';

    /** Component props. */
   defineProps({
       status: { type: String }
   });

   /** Page content. */
   const content = {
       title: "Ai uitat parola",
       description: "Nu ai cont pe Bursa Binelui?",
       link: {
           text: "Creează cont nou",
           href: "register"
       }
   }

   /** Form variables. */
   const form = useForm({
       email: '',
   });

   /** Submit action. */
   const submit = () => {
        form.post(route('password.email'), {
            onError: (error) => {
                form.reset('email')
            },
            onSuccess: () => {
                form.reset('email')
            },
        });
   };
</script>
