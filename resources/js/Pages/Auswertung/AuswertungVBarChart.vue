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
  indexAxis: "y",
  plugins: {
    legend: {
      display: false,
    },
    datalabels: {
      color: "#888",
      font: {
        // weight: "bold",
        size: 22,
      },
      formatter: function (value, context) {
        let nf = new Intl.NumberFormat("de-DE");
        return nf.format(value);
      },
    },
  },
  scales: {
    x: {
      ticks: {
        color: "#888",
        font: {
          size: 16,
          weight: "bold",
        },
      },
      grid: {
        color: "#888",
      },
    },
    y: {
      ticks: {
        color: "#888",
        font: {
          size: 16,
          weight: "bold",
        },
      },
    },
  },
});
</script>

<template>
  <div class="card">
    <h5 class="text-xl font-bold">{{ props.title }}</h5>
    <Chart
      type="bar"
      :data="basicData"
      :options="basicOptions"
      :plugins="plugins"
    />
  </div>
</template>
