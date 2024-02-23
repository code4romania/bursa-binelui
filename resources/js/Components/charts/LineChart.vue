<template>
    <div>
        <canvas ref="chartCanvas" class="w-full"></canvas>
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import Chart from 'chart.js/auto';
    import 'chartjs-adapter-moment';

    const chartCanvas = ref(null);

    const props = defineProps({
        data: Array,
        yAxeId: String,
        xAxeId: String,
        label: String,
        useMonthLabel: Boolean,
    });

    const reactiveChartData = (labels, data) => {
        return {
            labels: labels,
            datasets: [
                {
                    label: '',
                    data: data,
                    borderWidth: 0,
                    tension: 0.4,
                    fill: {
                        target: 'origin',
                        above: '#C1E8E8',
                        below: 'green',
                    },
                    pointRadius: 0,
                    hoverRadius: 5,
                    hoverBackgroundColor: 'white',
                    hoverBorderColor: '#53BFBF',
                    hoverBorderWidth: 2,
                },
            ],
        };
    };

    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                top: 10,
                bottom: 10,
            },
        },
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'month',
                },
                adapters: {
                    date: {
                        locale: 'roRo',
                    },
                }
            },
            y: {

                grid: {
                    display: false,
                },
            },
        },
        plugins: {
            tooltip: {
                intersect: false,
                callbacks: {
                    title: (tooltipItems) => {
                        const date = new Date(tooltipItems[0].label);
                        return  date.toLocaleDateString('ro-Ro');
                    },
                    label: (context) => {
                        const yAxe = context.parsed.y;
                        return `${props.label}: ${yAxe}`;
                    },
                },
            },
        },
        interaction: {
            intersect: false,
        },
    };

    const renderChart = () => {
        const yAxe = props.data.map((entry) => entry[props.yAxeId]);
        const xAxe = props.data.map((entry) =>entry[props.xAxeId]);



        const chartData = reactiveChartData(xAxe, yAxe);

        const ctx = chartCanvas.value.getContext('2d');
        return new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: chartOptions,
        });
    };
    function getMonthName(date) {
        const d = new Date(date);
        const monthNumber = d.getMonth();
        console.log('monthNumber', monthNumber)
        const tmpDate = new Date();
        tmpDate.setMonth(monthNumber);

        return tmpDate.toLocaleString('ro-Ro', { month: 'long' });
    }

    onMounted(() => {
        renderChart();
    });
</script>
