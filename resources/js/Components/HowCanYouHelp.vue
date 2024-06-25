<template>
    <div class="relative">
        <div class="pt-12 pb-20 mt-16 bg-primary-500 px-9 lg:px-0">
            <div class="flex items-center gap-4 mx-auto max-w-7xl">
                <div class="flex items-center justify-center w-10 h-10 p-2 text-white rounded-lg bg-primary-100">
                    <SpeakerphoneIcon />
                </div>
                <h3 class="text-2xl font-bold text-white">{{ $t('how_can_you_help') }}</h3>
            </div>
        </div>

        <div class="px-9">
            <ul class="grid grid-cols-1 gap-8 mx-auto -mt-12 max-w-7xl lg:grid-cols-3">
                <li
                    class="relative z-50 flex flex-col col-span-1 p-6 bg-white rounded-md shadow-lg ring-1 ring-gray-100"
                >
                    <ShareIcon
                        class="flex items-center justify-center w-10 h-10 p-2 mb-6 rounded-lg text-primary-600 bg-primary-50"
                    />

                    <h3 class="font-semibold leading-7 text-gray-900" v-text="$t('social_media_share')" />

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        {{ $t('share') }}
                        <a
                            class="text-blue-500 underline"
                            :href="`https://www.facebook.com/sharer/sharer.php?u=${pageRoute}`"
                            target="_blank"
                            rel="noopener"
                            >{{ $t('facebook') }}</a
                        >,
                        <a
                            class="text-blue-500 underline"
                            :href="`https://www.instagram.com/create/story/?text=${pageRoute}`"
                            target="_blank"
                            rel="noopener"
                            >{{ $t('instagram') }}</a
                        >,
                        <a
                            class="text-blue-500 underline"
                            :href="`https://www.linkedin.com/sharing/share-offsite/?url=${pageRoute}`"
                            target="_blank"
                            rel="noopener"
                            >{{ $t('linkedin') }}</a
                        >,
                        {{ $t('send_to_friend') }}
                        <a
                            class="text-blue-500 underline"
                            :href="`https://api.whatsapp.com/send?text=${pageRoute}`"
                            data-action="share/whatsapp/share"
                            target="_blank"
                            rel="noopener"
                            >{{ $t('whatsapp') }}</a
                        >
                        {{ $t('or') }}
                        <a
                            class="text-blue-500 underline"
                            :href="`https://www.facebook.com/dialog/send?app_id=APP_ID&link=${pageRoute}`"
                            target="_blank"
                            rel="noopener"
                            >{{ $t('messenger') }}</a
                        >
                        {{ $t('tell_about') }}
                    </p>
                </li>

                <li
                    class="relative z-50 flex flex-col col-span-1 p-6 bg-white rounded-md shadow-lg ring-1 ring-gray-100"
                >
                    <HeartIcon
                        class="flex items-center justify-center w-10 h-10 p-2 mb-6 rounded-lg text-primary-600 bg-primary-50"
                    />

                    <h3 class="font-semibold leading-7 text-gray-900" v-text="$t('donate_or_volunteer')" />

                    <p class="mt-1 text-sm leading-relaxed text-gray-600">
                        {{ $t('interested_in_ong') }}
                        <a
                            :href="pageRoute + '#projects'"
                            class="text-blue-500 underline cursor-pointer"
                            v-text="$t('donate')"
                        />
                        {{ $t('help_them') }}
                        <button
                            type="button"
                            v-if="acceptsVolunteers"
                            @click="triggerVolunteer"
                            class="text-blue-500 underline cursor-pointer"
                            v-text="$t('register_to_volunteer')"
                        />
                        {{ $t('for_ong') }}
                    </p>
                </li>

                <li
                    class="relative z-50 flex flex-col col-span-1 p-6 bg-white rounded-md shadow-lg ring-1 ring-gray-100"
                >
                    <GlobeAltIcon
                        class="flex items-center justify-center w-10 h-10 p-2 mb-6 rounded-lg text-primary-600 bg-primary-50"
                    />

                    <h3 class="font-semibold leading-7 text-gray-900" v-text="$t('your_blog')" />

                    <div class="relative mt-1">
                        <p class="text-sm leading-relaxed text-gray-600">
                            {{ $t('you_have_blog') }}
                            <button
                                type="button"
                                @click="copy(embedCode)"
                                class="text-blue-500 underline"
                                v-text="$t('embed_code')"
                            />
                            {{ $t('copy_code') }}
                        </p>

                        <div
                            v-if="copied && text === embedCode"
                            class="absolute inset-0 z-50 flex items-center py-4 overflow-hidden transition-opacity duration-150 bg-white"
                        >
                            <div class="flex gap-x-2">
                                <CheckCircleIcon class="w-5 h-5 text-green-400 shrink-0" aria-hidden="true" />

                                <span
                                    class="text-sm font-medium text-green-800 max-w-64"
                                    v-text="$t('embed_code_copied')"
                                />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <LargeSquarePattern class="absolute right-0 z-10 hidden lg:block top-10 fill-primary-200" />
    </div>
</template>

<script setup>
    import { computed } from 'vue';
    import { useClipboard } from '@vueuse/core';

    import LargeSquarePattern from '@/Components/patterns/LargeSquarePattern.vue';

    import { SpeakerphoneIcon } from '@heroicons/vue/outline';
    import { CheckCircleIcon, ShareIcon, HeartIcon, GlobeAltIcon } from '@heroicons/vue/solid';

    /** Component props. */
    const props = defineProps({
        pageRoute: String,
        acceptsVolunteers: {
            type: Boolean,
            default: false,
        },
    });

    const embedCode = computed(() => `<iframe src="${window.location.href}" width="800" height="600"></iframe>`);

    const { text, copy, copied } = useClipboard({ legacy: true });

    const triggerVolunteer = () => {
        document.getElementById('volunteer-active-modal').click();
    };
</script>
