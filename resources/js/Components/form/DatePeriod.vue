<template>
    <div :id="id" class="relative">
        <!-- Label -->
        <label :for="id" :class="[`block text-sm font-medium leading-6`, error ? 'text-red-500' : `${color}`]">
                <span v-if="label">{{ label }}</span>
            <span v-else><slot /></span>
        </label>

        <input
            ref="dateRangeInput"
            type="text"
            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary-500 sm:text-sm sm:leading-6"
            :value="formattedDateRange"
            @focus="openDatePicker"
        />

        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none top-1/3">
            <SvgLoader name="calendar" class="shrink-0" />
        </div>

        <div v-if="open" class="absolute mt-1 top-100% left-0 z-50 bg-white shadow-lg rounded-md p-1 w-72" @click="keepOpen">
            <div class="flex items-center justify-around">
                <button @click="goToPreviousMonth" class="col-span-1">
                    <div class="flex items-center justify-center w-8 h-8">
                    <SvgLoader name="chevron_left" class="shrink-0" />
                    </div>
                </button>

                <select v-model="selectedMonth" class="col-span-5 text-sm border-none focus:ring-0" @change="updateCalendar">
                    <option v-for="(month, index) in months" :key="index" :value="index" class="p-1 text-gray-700">
                    {{ month }}
                    </option>
                </select>

                <select v-model="selectedYear" class="col-span-3 text-sm border-none focus:ring-0" @change="updateCalendar">
                    <option v-for="year in years" :key="year" :value="year" class="p-1 text-gray-700">{{ year }}</option>
                </select>

                <button @click="goToNextMonth" class="col-span-1">
                    <div class="flex items-center justify-center w-8 h-8">
                    <SvgLoader name="chevron_right" class="shrink-0" />
                    </div>
                </button>
            </div>

            <div class="flex justify-between my-2">
                <div v-for="dayLabel in days" class="text-xs text-gray-500 flex-1 text-center font-semibold p-1.5 border-b border-gray-300">{{ dayLabel }}</div>
            </div>

            <div class="grid grid-cols-7 gap-1">
                <template v-for="(date, index) in calendar" :key="index">
                    <div
                        v-if="date"
                        class="p-2 text-center cursor-pointer hover:bg-primary-500 hover:text-white hover:rounded-md hover:shadow-md"
                        :class="{
                            'bg-red-500 text-white rounded-md shadow-md': isDateInRange(date),
                            'text-gray-400': isPrevMonth(date) || isNextMonth(date),
                            'text-primary-500': isCurrentDate(date)
                        }"
                        @click="selectDate(date)"
                    >
                        {{ date.getDate() }}
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, computed, onMounted, onBeforeUnmount, nextTick } from 'vue';
    import SvgLoader from '@/Components/SvgLoader.vue';

    /** Days */
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    /** Months */
    const months = [
        'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
        'September', 'October', 'November', 'December'
    ];

    /** Years interval */
    const years = Array.from({ length: 2100 - 1900 }, (_, index) => 1900 + index);

    /** Props */
    const { id, label, color, modelValue } = defineProps(['id', 'label', 'color', 'modelValue']);

    /** Emits */
    const emit = defineEmits(['update:modelValue']);

    /** Date range */
    const dateRangeInput = ref(null);

    /** Selected Range */
    const selectedDateRange = ref({
        start: new Date(),
        end: new Date(),
    });

    /** Format date range. */
    const formattedDateRange = computed(() => {
        const startDate = selectedDateRange.value.start ? formatDate(selectedDateRange.value.start) : '';
        const endDate = selectedDateRange.value.end ? formatDate(selectedDateRange.value.end) : '';
        return `${startDate} - ${endDate}`;
    });

    const open = ref(false);
    const isSelectingStart = ref(false);

    const selectedMonth = ref(new Date().getMonth());
    const selectedYear = ref(new Date().getFullYear());

    const calendar = computed(() => {
        if (selectedDateRange.value.start && selectedDateRange.value.end) {
            const year = selectedYear.value;
            const month = selectedMonth.value;

            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDayIndex = new Date(year, month, 1).getDay();

            const calendar = [];
            const prevMonthLastDay = new Date(year, month, 0).getDate();

            // Add empty days for previous month
            for (let i = firstDayIndex; i > 0; i--) {
                calendar.push(new Date(year, month - 1, prevMonthLastDay - (i - 1)));
            }

            // Add days for current month
            for (let i = 1; i <= daysInMonth; i++) {
                calendar.push(new Date(year, month, i));
            }

            // Add empty days for next month
            const daysAfterCurrentMonth = calendar.length % 7;
            const daysToAdd = daysAfterCurrentMonth === 0 ? 0 : 7 - daysAfterCurrentMonth;
            for (let i = 1; i <= daysToAdd; i++) {
                calendar.push(new Date(year, month + 1, i));
            }

            return calendar;
        } else {
            return [];
        }
    });

    function formatDate(date) {
        const day = date.getDate().toString().padStart(2, '0');
        const month = (date.getMonth() + 1).toString().padStart(2, '0');
        const year = date.getFullYear();
        return `${year}.${month}.${day}`;
    }

    function openDatePicker() {
        if (!open.value) {
            open.value = true;
            nextTick(() => {
                if (dateRangeInput.value) {
                dateRangeInput.value.focus();
                }
            });
        }
    }

    function keepOpen(event) {
        event.stopPropagation();
    }

    function selectDate(date) {
        if (isSelectingStart.value) {
            selectedDateRange.value.start = date;
            selectedDateRange.value.end = date;
            isSelectingStart.value = false;
        } else {
            if (date >= selectedDateRange.value.start) {
                selectedDateRange.value.end = date;
                isSelectingStart.value = true;
            } else {
                selectedDateRange.value.end = selectedDateRange.value.start;
                selectedDateRange.value.start = date;
            }
        }

        emit('update:modelValue', formatRange(selectedDateRange.value));
    }

    function isDateInRange(date) {
        return (selectedDateRange.value.start <= date && date <= selectedDateRange.value.end);
    }

    function isPrevMonth(date) {
        const prevMonth = new Date(selectedYear.value, selectedMonth.value - 1, 1);
        return (date.getMonth() === prevMonth.getMonth() && date.getFullYear() === prevMonth.getFullYear());
    }

    function isNextMonth(date) {
        const nextMonth = new Date(selectedYear.value, selectedMonth.value + 1, 1);
        return (date.getMonth() === nextMonth.getMonth() && date.getFullYear() === nextMonth.getFullYear());
    }

    function isCurrentDate(date) {
        const currentDate = new Date();
        return date.toDateString() === currentDate.toDateString();
    }

    function formatRange(range) {
        const start = range.start ? formatDate(range.start) : '';
        const end = range.end ? formatDate(range.end) : '';
        return `${start} - ${end}`;
    }

    function goToPreviousMonth() {
        if (selectedMonth.value === 0) {
            selectedYear.value--;
            selectedMonth.value = 11;
        } else {
            selectedMonth.value--;
        }

        updateCalendar();
    }

    function goToNextMonth() {
        if (selectedMonth.value === 11) {
            selectedYear.value++;
            selectedMonth.value = 0;
        } else {
            selectedMonth.value++;
        }

        updateCalendar();
    }

    function updateCalendar() {
        const start = selectedDateRange.value.start;
        const end = selectedDateRange.value.end;
        if (start > end) {
            selectedDateRange.value.end = start;
        }
    }

    function handleClickOutside(event) {
        if (!event.target.closest(`#${id}`)) {
            open.value = false;
        }
    }

    onMounted(() => {
        document.addEventListener('click', handleClickOutside);
    });

    onBeforeUnmount(() => {
        document.removeEventListener('click', handleClickOutside);
    });
  </script>
