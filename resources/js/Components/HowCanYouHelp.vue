<template>
    <div class="relative">
        <div class="pt-12 pb-20 mt-16 bg-primary-500 px-9 lg:px-0">
            <div class="flex items-center gap-4 mx-auto max-w-7xl">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-100">
                    <SvgLoader class="shrink-0 stroke-white fill-primary-100" name="sound" />
                </div>
                <h3 class="text-2xl font-bold text-white">{{ $t('how_can_you_help') }}</h3>
            </div>
        </div>

        <div class="bg-white px-9">
            <ul role="list" class="grid grid-cols-1 gap-8 mx-auto max-w-7xl sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                <li class="relative z-50 flex flex-col col-span-1 p-6 -mt-12 bg-white rounded-md shadow-lg">
                    <SvgLoader name="share" />
                    <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('social_media_share') }}</h3>
                    <div class="text-sm text-gray-500">
                        {{  $t('share')  }}
                        <a class="text-blue-500 underline" :href="`https://www.facebook.com/sharer/sharer.php?u=${pageRoute}`" target="_blank" rel="noopener">{{ $t('facebook') }}</a>,
                        <a class="text-blue-500 underline" :href="`https://www.instagram.com/create/story/?text=${pageRoute}`" target="_blank" rel="noopener">{{ $t('instagram') }}</a>,
                        <a class="text-blue-500 underline" :href="`https://www.linkedin.com/sharing/share-offsite/?url=${pageRoute}`" target="_blank" rel="noopener">{{ $t('linkedin') }}</a>,
                        {{ $t('send_to_friend') }}
                        <a class="text-blue-500 underline" :href="`https://api.whatsapp.com/send?text=${pageRoute}`" data-action="share/whatsapp/share"   target="_blank" rel="noopener">{{ $t('whatsapp') }}</a>
                        {{ $t('or') }}
                        <a class="text-blue-500 underline" :href="`https://www.facebook.com/dialog/send?app_id=APP_ID&link=${pageRoute}`" target="_blank" rel="noopener">{{ $t('messenger') }}</a>
                        {{ $t('tell_about') }}
                    </div>
                </li>

                <li class="relative z-50 flex flex-col col-span-1 p-6 bg-white rounded-md shadow-lg sm:-mt-12">
                    <SvgLoader name="heart" />
                    <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('donate_or_volunteer') }}</h3>
                    <div class="text-sm text-gray-500">
                        {{ $t('interested_in_ong') }}
                        <span @click="$emit('donate')" class="text-blue-500 underline cursor-pointer">{{ $t('donate') }}</span>
                        {{ $t('help_them') }}
                        <span v-if="acceptsVolunteers" @click="$emit('volunteer')" class="text-blue-500 underline cursor-pointer">{{ $t('register_to_volunteer') }}</span>
                        {{ $t('for_ong') }}
                    </div>
                </li>

                <li class="relative z-50 flex flex-col col-span-1 p-6 bg-white rounded-md shadow-lg sm:-mt-12">
                    <SvgLoader name="glob" />
                    <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('your_blog') }}</h3>
                    <div class="text-sm text-gray-500">
                        {{ $t('you_have_blog') }}
                        <p @click="$emit('copyCode')" class="text-blue-500 underline cursor-pointer">{{ $t('embed_code') }}</p>
                        {{ $t('copy_code') }}
                    </div>
                </li>
            </ul>
        </div>

        <div class="absolute right-0 z-10 hidden lg:block top-10">
            <SvgLoader class="shrink-0" name="squer_half_color" />
        </div>
    </div>
</template>

<script setup>
    /** Import components */
    import SvgLoader from '@/Components/SvgLoader.vue';

    /** Component props. */
    const props = defineProps({
        pageRoute: String,
        acceptsVolunteers: Boolean
    });

    /** Component emits. */
    defineEmits(['copyCode', 'donate', 'volunteer']);
</script>
