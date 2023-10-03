import { computed } from 'vue';
import route from 'ziggy-js';

export default function (sort) {
    const isSortingBy = (column, direction = null) => {
        if (direction) {
            return sort.column === column && sort.direction === direction;
        }

        return sort.column === column;
    };

    const currentUrlWithoutSort = computed(() => {
        const { sort, ...params } = route().params;

        return route(route().current(), params);
    });

    const sortData = (column) => {
        if (!isSortingBy(column)) {
            return { sort: `-${column}` };
        }

        if (isSortingBy(column, 'desc')) {
            return { sort: column };
        }

        return {};
    };

    const sortValue = computed(() => {
        if (!sort?.column || !sort?.direction) {
            return null;
        }

        if (sort.direction === 'desc') {
            return `-${sort.column}`;
        }

        return sort.column;
    });

    return {
        currentUrlWithoutSort,
        sortData,
        sortValue,
        isSortingBy,
    }
}
