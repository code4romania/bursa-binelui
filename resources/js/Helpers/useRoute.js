import { ref } from 'vue'
import ZiggyRoute from 'ziggy-js';

const Ziggy = ref(null);

export default function route(name, params, absolute, config = Ziggy.value) {
    return ZiggyRoute(name, params, absolute, config);
}

export const ZiggyVue = {
    install(app, options) {
        Ziggy.value = options;

        app.mixin({
            methods: {
                route,
            },
        });

        if (parseInt(app.version) > 2) {
            app.provide('route', route);
        }
    },
}
