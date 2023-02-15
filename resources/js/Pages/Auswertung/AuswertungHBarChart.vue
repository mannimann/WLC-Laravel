<script setup>
import Chart from "primevue/chart";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { ref } from "vue";

const props = defineProps(["title", "data", "labels"]);

const plugins = [ChartDataLabels];
const basicData = ref({
  labels: props.labels,
  datasets: [
    {
      label: props.title,
      backgroundColor: "rgba(54, 162, 235, 0.2)",
      borderColor: "rgb(54, 162, 235)",
      borderWidth: 2,
      borderRadius: 4,
      data: props.data,
    },
  ],
});

const basicOptions = ref({
  plugins: {
    legend: {
      display: false,
    },
    datalabels: {
      color: "#888",
      font: {
        weight: "bold",
        size: 24,
      },
    },
  },
  scales: {
    x: {
      ticks: {
        color: "#888",
      },
    },
    y: {
      ticks: {
        color: "#888",
      },
      grid: {
        color: "#888",
      },
    },
  },
});
</script>

<template>
  <div class="card">
    <h5>{{ props.title }}</h5>
    <Chart
      type="bar"
      :data="basicData"
      :options="basicOptions"
      :plugins="plugins"
    />
  </div>
</template>
