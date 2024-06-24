import { createSSRApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { i18nVue } from 'laravel-vue-i18n';
import { ZiggyVue } from '@/Helpers/useRoute';

import 'virtual:svg-icons-register';

import.meta.glob(['../images/**']);

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createSSRApp({ render: () => h(App, props) })
            .use(ZiggyVue, props.initialPage.props.ziggy)
            .use(plugin)
            .component('Link', Link);

        return app.use(i18nVue, {
            lang: props.initialPage.props.locales.current,
            resolve: async (lang) => {
                const langs = import.meta.glob('../../lang/*.json');
                return await langs[`../../lang/${lang}.json`]();
            },
            onLoad: () => {
                app.mount(el);
            },
        });
    },
    progress: {
        color: '#65B7FF',
    },
});
