import { router } from '@inertiajs/vue3';
import pickBy from '@/Helpers/pickBy.js';
import useSort from '@/Helpers/useSort.js';

export default function (props, sort, url) {
    const { sortValue } = useSort(sort);

    const applyFilters = () => {
        return router.get(url, pickBy({
            filter: pickBy(props.value),
            sort: sortValue.value,
        }), {
            preserveScroll: true
        })
    };

    const clearFilters = () => {
        router.visit(url);
    };

    return {
        applyFilters,
        clearFilters,
    }
}
