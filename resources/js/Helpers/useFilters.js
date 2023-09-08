import { router } from '@inertiajs/vue3';

export default function (props, url) {
    const applyFilters = () => router.get(url, {
        filter: props.value
    }, {
        preserveScroll: true
    });

    const clearFilters = () => {
        router.visit(url);
    };

    return {
        applyFilters,
        clearFilters,
    }
}
