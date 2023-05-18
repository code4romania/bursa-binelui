<template>
    <div class="relative">
        <div class="bg-turqoise-500 pt-12 pb-20 mt-16 px-9 lg:px-0">
            <div class="mx-auto max-w-7xl flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-turqoise-100">
                    <SvgLoader class="shrink-0 stroke-white fill-turqoise-100" name="sound" />
                </div>
                <h3 class="text-white font-bold text-2xl">{{ $t('how_can_you_help') }}</h3>
            </div>
        </div>

        <div class="bg-white px-9">
            <ul role="list" class="mx-auto max-w-7xl grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3">
                <li class="col-span-1 -mt-12 p-6 flex flex-col rounded-md bg-white shadow-lg relative z-50">
                    <SvgLoader name="share" />
                    <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('social_media_share') }}</h3>
                    <div class="text-sm text-gray-500">
                        {{  $t('share')  }}
                        <a class="text-blue-500 underline" :href="`https://www.facebook.com/sharer/sharer.php?u=${route(pageRoute, id)}`" target="_blank" rel="noopener">{{ $t('facebook') }}</a>,
                        <a class="text-blue-500 underline" :href="`https://www.instagram.com/create/story/?text=${route(pageRoute, id)}`" target="_blank" rel="noopener">{{ $t('instagram') }}</a>,
                        <a class="text-blue-500 underline" :href="`https://www.facebook.com/sharer/sharer.php?u=${route(pageRoute, id)}`" target="_blank" rel="noopener">{{ $t('linkedin') }}</a>,
                        {{ $t('send_to_friend') }}
                        <a class="text-blue-500 underline" :href="`https://api.whatsapp.com/send?text=${route(pageRoute, id)}`" data-action="share/whatsapp/share"   target="_blank" rel="noopener">{{ $t('whatsapp') }}</a>
                        {{ $t('or') }}
                        <a class="text-blue-500 underline" :href="`https://www.facebook.com/dialog/send?app_id=APP_ID&link=${route(pageRoute, id)}`" target="_blank" rel="noopener">{{ $t('messenger') }}</a>
                        {{ $t('tell_about') }}
                    </div>
                </li>

                <li class="col-span-1 sm:-mt-12 p-6 flex flex-col rounded-md bg-white shadow-lg relative z-50">
                    <SvgLoader name="heart" />
                    <h3 class="mt-6 mb-2 text-lg font-medium text-gray-900">{{ $t('donate_or_volunteer') }}</h3>
                    <div class="text-sm text-gray-500">
                        {{ $t('interested_in_ong') }}
                        <span @click="$emit('donate')" class="cursor-pointer text-blue-500 underline">{{ $t('donate') }}</span>
                        {{ $t('help_them') }}
                        <span @click="$emit('volunteer')" class="cursor-pointer text-blue-500 underline">{{ $t('register_to_volunteer') }}</span>
                        {{ $t('for_ong') }}
                    </div>
                </li>

                <li class="col-span-1 sm:-mt-12 p-6 flex flex-col rounded-md bg-white shadow-lg relative z-50">
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

        <div class="hidden lg:block absolute top-10 right-0 z-10">
            <SvgLoader class="shrink-0" name="squer_half_color" />
        </div>
    </div>
</template>

<script setup>
    /** Import components */
    import SvgLoader from '@/Components/SvgLoader.vue';

    /** Component props. */
    const props = defineProps({
        id: [Number, String],
        pageRoute: String
    });

    /** Component emits. */
    defineEmits(['copyCode', 'donate', 'volunteer']);
</script>
