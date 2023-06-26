<template>
    <div>
        <div v-if="'soon' === show" class="space-y-6 text-center">
            <p class="text-2xl font-bold text-primary-50">Vom deschide procesul de înscriere proiecte</p>
            <h2 class="text-6xl font-bold text-white">în curând!</h2>
            <p class="text-2xl font-bold text-primary-50">Vă mulțumim pentru răbdare!</p>
        </div>

        <div v-if="'now' === show" class="space-y-6 text-center">
            <p class="text-2xl font-bold text-primary-50">Au mai rămas</p>
            <div class="grid grid-cols-3 gap-6">
                <div class="text-center text-white">
                    <p class="text-6xl font-bold">{{ countdown.days }}</p>
                    <p class="text-2xl font-bold">zile</p>
                </div>
                <div class="text-center text-white">
                    <p class="text-6xl font-bold">{{ countdown.days }}</p>
                    <p class="text-2xl font-bold">ore</p>
                </div>
                <div class="text-center text-white">
                    <p class="text-6xl font-bold">{{ countdown.minutes }}</p>
                    <p class="text-2xl font-bold">min</p>
                </div>
            </div>
            <p class="text-2xl font-bold text-primary-50">până la termenul de depunere</p>
        </div>

        <div v-if="'ended' === show" class="space-y-6 text-center">
            <p class="text-2xl font-bold text-primary-50">Perioada de înscriere a luat sfârșit. Gala va avea loc pe</p>
            <h2 class="text-6xl font-bold text-white">{{ dates.end }}</h2>
        </div>
    </div>
</template>

<script setup>
/** Import from vue. */
import { computed, ref, watchEffect} from 'vue'

const props = defineProps({
    dates: Object
});

const current = new Date();
const start = new Date(props.dates.start);
const end = new Date(props.dates.end);

const show = computed(() => {
    if (current < start) {
        return 'soon';
    } else if (end < current) {
        return 'ended';
    } else if ((current >= start) && (current <= end)) {
        return 'now';
    }
});

const countdown = ref({
    days: 0,
    hours: 0,
    minutes: 0
});

const startCountdown = () => {
    const countdownInterval = setInterval(() => {
        const remainingTime = end - current;

        if (remainingTime <= 0) {
            clearInterval(countdownInterval);
            countdown.value.days = 0;
            countdown.value.hours = 0;
            countdown.value.minutes = 0;
        } else {
            countdown.value.days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
            countdown.value.hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            countdown.value.minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        }
    }, 1000);
};

watchEffect(() => {
    startCountdown();
});
</script>
