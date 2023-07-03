<template>
    <div>
        <canvas ref="chartCanvas" style="height: 400px;"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import Chart from 'chart.js/auto';

const chartCanvas = ref(null);

const props = defineProps({
    data:Array,
    xAxe:Array,
    yAxeId: String
})

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
            grid: {
                display: true,
            },
        },
        y: {
            grid: {
                display: false
            },
        },
    },
    plugins: {
        tooltip: {
            intersect: false,
            callbacks: {
                title: (tooltipItems) => {
                    const month = tooltipItems[0].label;
                    return month;
                },
                label: (context) => {
                    const index = context.dataIndex;
                    const yAxe = context.parsed.y;
                    const { sales, expenses } = props.data[index];
                    return `Amount: ${yAxe}, Sales: ${sales}, Expenses: ${expenses}`;
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

    const chartData = reactiveChartData(props.xAxe, yAxe);

    const ctx = chartCanvas.value.getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: chartOptions,
    });
}

onMounted(() => {
    renderChart()
});
  </script>
