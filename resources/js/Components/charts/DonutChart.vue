<template>
    <div>
      <canvas ref="chartCanvas" class="w-full"></canvas>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, defineProps } from 'vue';
  import Chart from 'chart.js/auto';

  const chartCanvas = ref(null);

  const props = defineProps({
    data: Array,
    yAxeId: String,
    xAxeId: String,
      label: String,
  });


  const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  const formatLabel = (key) => {
    const label = key.replace(/[-_]/g, ' ');
    return capitalizeFirstLetter(label);
  };

  const reactiveChartData = (labels, data) => {

    return {
      labels: labels,
      datasets: [
        {
          data: data,
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
          title: (tooltipItems) => {
                return tooltipItems[0].label;
          },
          label: (context) => {
              return `${props.label}: ${context.parsed}`;
          },
        },
      },
      legend: {
        position: 'bottom', // Set the legend position to 'bottom'
      },
    },
    interaction: {
      intersect: false,
    },
  };

  const renderChart = () => {
    const yAxe = props.data.map((entry) => entry[props.yAxeId]);
    const xAxe = props.data.map((entry) => entry[props.xAxeId]);

    const chartData = reactiveChartData(xAxe, yAxe);

    const ctx = chartCanvas.value.getContext('2d');
      return  new Chart(ctx, {
      type: 'doughnut', // Use 'doughnut' for a donut chart
      data: chartData,
      options: chartOptions,
    });
  };

  onMounted(() => {
    renderChart();
  });
  </script>
