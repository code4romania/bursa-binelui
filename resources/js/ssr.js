import { createSSRApp, h } from 'vue';
import { renderToString } from '@vue/server-renderer';
import { createInertiaApp, Head, Link } from '@inertiajs/vue3';
import createServer from '@inertiajs/vue3/server';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { i18nVue } from 'laravel-vue-i18n';
import { ZiggyVue } from '@/Helpers/useRoute';

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - Bursa Binelui`,
        resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue', { eager: true })),
        setup({ App, props, plugin }) {
            return createSSRApp({ render: () => h(App, props) })
                .use(ZiggyVue, {
                    // Pull the Ziggy config off of the props.
                    ...props.initialPage.props.ziggy,
                    // Build the location, since there is
                    // no window.location in Node.
                    location: new URL(props.initialPage.props.ziggy.url)
                })
                .use(i18nVue, {
                    lang: props.initialPage.props.locales.current,
                    resolve: lang => {
                        const langs = import.meta.glob('../../lang/*.json', { eager: true });
                        return langs[`../../lang/${lang}.json`].default;
                    }
                })
                .use(plugin)
                .component('Head', Head)
                .component('Link', Link)
        },
    })
);
