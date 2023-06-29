<template>
    <PageLayout>
        <!-- Inertia page head -->
       <Head title="Forgot Password" />

       <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
           {{ status }}
       </div>

       <!-- Auth template. -->
       <Auth :content="content">
           <form class="space-y-6 mt-4 lg:mb-28" @submit.prevent="submit">
                <!-- Email -->
                <Input
                    :label="$t('email')"
                    id="email"
                    type="email"
                    v-model="form.email"
                    :isRequired="true"
                    hasAutocomplete="username"
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
           href: "#"
       }
   }

   /** Form variables. */
   const form = useForm({
       email: '',
   });

   /** Submit action. */
   const submit = () => {
       form.post(route('password.email'));
   };
</script>
