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

  const monthColors = {
    Ian: '#FF6384',
    Feb: '#36A2EB',
    Mar: '#FFCE56',
    Apr: '#8ED16D',
    Mai: '#FF9F40',
    Iun: '#607D8B',
    Iul: '#FFC0CB',
    Aug: '#7B68EE',
    Sep: '#FFD700',
    Oct: '#32CD32',
    Noi: '#FFA500',
    Dec: '#4682B4',
  };

  const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
  };

  const formatLabel = (key) => {
    const label = key.replace(/[-_]/g, ' ');
    return capitalizeFirstLetter(label);
  };

  const reactiveChartData = (labels, data) => {
    const colors = labels.map((month) => monthColors[month]);

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
            const dataEntry = props.data[index];
            const tooltipLabelParts = [];

            const amountKey = formatLabel(props.yAxeId);
            tooltipLabelParts.push(`${amountKey}: ${yAxe}`);

            for (const key in dataEntry) {
              if (key !== props.yAxeId) {
                const formattedKey = formatLabel(key);
                const value = dataEntry[key];
                tooltipLabelParts.push(`${formattedKey}: ${value}`);
              }
            }

            return tooltipLabelParts.join(', ');
          },
        },
      },
      legend: {
        position: 'bottom',
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
      type: 'pie',
      data: chartData,
      options: chartOptions,
    });
  };

  onMounted(() => {
    renderChart();
  });
  </script>
