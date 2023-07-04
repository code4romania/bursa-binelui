<template>
    <div>
      <canvas ref="chartCanvas" style="height: 400px;"></canvas>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, defineProps } from 'vue';
  import Chart from 'chart.js/auto';

  const chartCanvas = ref(null);

  const props = defineProps({
    data: Array,
    xAxe: Array,
    yAxeId: String
  });

  const staffColors = [
    '#FF6384',
    '#36A2EB',
    '#FFCE56',
    '#8ED16D',
    '#FF9F40',
    '#607D8B',
    '#FFC0CB',
    '#7B68EE',
    '#FFD700',
    '#32CD32',
    '#FFA500',
    '#4682B4',
    '#FF7F50',
    '#800080',
    '#008080',
    '#FF4500',
  ];

  const reactiveChartData = (data) => {
    const staffNames = data.map((entry) => entry.staff);
    const taskCounts = data.map((entry) => entry.tasks);
    const colors = staffColors.slice(0, staffNames.length);

    return {
      labels: staffNames,
      datasets: [
        {
          data: taskCounts,
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
    plugins: {
      tooltip: {
        callbacks: {
          label: (context) => {
            const index = context.dataIndex;
            const staff = props.data[index].staff;
            const tasks = props.data[index].tasks;

            return `${staff}: ${tasks} tasks`;
          },
        },
      },
    },
    interaction: {
      intersect: false,
    },
  };

  const renderChart = () => {
    const chartData = reactiveChartData(props.data);

    const ctx = chartCanvas.value.getContext('2d');
    new Chart(ctx, {
      type: 'radialPie', // Use 'radialPie' for a radial pie chart
      data: chartData,
      options: chartOptions,
    });
  };

  onMounted(() => {
    renderChart();
  });
  </script>
