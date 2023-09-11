import { router } from '@inertiajs/vue3';

export default function (props, sort, url) {
    const applyFilters = () => router.get(url, {
        filter: props.value,
        sort: sort.value,
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
