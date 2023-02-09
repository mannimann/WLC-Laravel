<script setup>
import Chart from "primevue/chart";

const basicData = {
  labels: ["January", "February", "March", "April", "May", "June", "July"],
  datasets: [
    {
      label: "My First dataset",
      backgroundColor: "#42A5F5",
      data: [65, 59, 80, 81, 56, 55, 40],
    },
    {
      label: "My Second dataset",
      backgroundColor: "#FFA726",
      data: [28, 48, 40, 19, 86, 27, 90],
    },
  ],
};

const basicOptions = {
  plugins: {
    legend: {
      labels: {
        color: "#495057",
      },
    },
  },
  scales: {
    x: {
      ticks: {
        color: "#495057",
      },
      grid: {
        color: "#ebedef",
      },
    },
    y: {
      ticks: {
        color: "#495057",
      },
      grid: {
        color: "#ebedef",
      },
    },
  },
};
</script>

<template>
  <div class="card">
    <h5>Top 10 Läufer</h5>
    <Chart type="bar" :data="basicData" :options="basicOptions" />
  </div>
</template>
