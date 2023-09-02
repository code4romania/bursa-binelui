import { createApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from 'ziggy-js/dist/vue';
import i18n from './plugins/i18n.js';

import 'virtual:svg-icons-register';

import.meta.glob(['../images/**']);

createInertiaApp({
    title: (title) => `${title} - Bursa Binelui`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),

    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(ZiggyVue)
            .use(i18n)
            .use(plugin)
            .component('Head', Head)
            .component('Link', Link)
            .mount(el);
    },
    progress: {
        color: '#53BFBF',
    },
});
