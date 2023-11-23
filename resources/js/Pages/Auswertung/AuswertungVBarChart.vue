<script setup>
import Card from "@/Components/Card.vue";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { Bar } from "vue-chartjs";
import { ref, watch } from "vue";
import { useColorMode, useMediaQuery } from "@vueuse/core";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale
);

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

// Chart Theme
const key = ref(0);
const color = useColorMode();
const isLargeScreen = useMediaQuery("(min-width: 768px)");
let textColor, basicOptions;
watch(
  [color, isLargeScreen],
  ([newColor, newScreen]) => {
    // textColor = newColor === "dark" ? "#ccc" : "#444";
    textColor = newColor === "dark" ? "#ccc" : "#d4d5d5";
    // re-render Table-Component
    key.value += 1;

    // Chart Options
    basicOptions = ref({
      indexAxis: "y",
      plugins: {
        legend: {
          display: false,
        },
        datalabels: {
          color: textColor,
          font: {
            // weight: "bold",
            size: newScreen ? 18 : 14,
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
            color: textColor,
            font: {
              size: newScreen ? 16 : 12,
              // weight: "bold",
            },
          },
          grid: {
            color: "#888",
          },
        },
        y: {
          ticks: {
            color: textColor,
            font: {
              size: newScreen ? 16 : 12,
              // weight: "bold",
            },
          },
        },
      },
    });
  },
  {
    immediate: true, // Not lazy anymore
  }
);
</script>

<template>
  <Card>
    <template v-slot:header>
      <h3>{{ props.title }}</h3>
    </template>
    <template v-slot:body>
      <Bar
        :key="key"
        :data="basicData"
        :options="basicOptions"
        :plugins="plugins"
      />
    </template>
  </Card>
</template>
