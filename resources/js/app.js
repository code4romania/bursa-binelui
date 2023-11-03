import { createSSRApp, h } from 'vue';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
// import { ZiggyVue } from 'ziggy-js/dist/vue';
import { i18nVue } from 'laravel-vue-i18n';
import { ZiggyVue } from '@/Helpers/useRoute';

import 'virtual:svg-icons-register';

import.meta.glob(['../images/**']);

createInertiaApp({
    title: (title) => `${title} - Bursa Binelui`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createSSRApp({ render: () => h(App, props) })
            .use(ZiggyVue, props.initialPage.props.ziggy)
            .use(i18nVue, {
                resolve: async lang => {
                    const langs = import.meta.glob('../../lang/*.json');
                    return await langs[`../../lang/${lang}.json`]();
                }
            })
            .use(plugin)
            .component('Head', Head)
            .component('Link', Link)
            .mount(el)
    },
    progress: {
        color: '#53BFBF',
    },
});
