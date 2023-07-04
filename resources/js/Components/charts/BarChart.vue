Bar chart


<template>
    <div>
      <canvas ref="chartCanvas" style="height: 400px;"></canvas>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, onUnmounted, defineProps } from 'vue';
  import Chart from 'chart.js/auto';

  const chartCanvas = ref(null);

  const props = defineProps({
    data: Array,
    xAxe: Array,
    yAxeId: String
  });

  const generateRandomColor = () => {
    return '#' + Math.floor(Math.random() * 16777215).toString(16);
  };

  const reactiveChartData = (labels, data) => {
    const colors = labels.map(() => generateRandomColor());

    return {
      labels: labels,
      datasets: [
        {
          data: data,
          backgroundColor: colors,
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
        callbacks: {
          title: (tooltipItems) => {
            const month = tooltipItems[0].label;
            return month;
          },
          label: (context) => {
            const index = context.dataIndex;
            const yAxe = context.dataset.data[index];
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
      type: 'bar',
      data: chartData,
      options: chartOptions,
    });
  };

  onMounted(() => {
    renderChart();
  });
  </script>
