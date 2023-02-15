<script setup>
import Card from "@/Components/Card.vue";
import Chart from "primevue/chart";
import ChartDataLabels from "chartjs-plugin-datalabels";
import { ref, watch } from "vue";
import { useColorMode } from "@vueuse/core";
import { useMediaQuery } from "@vueuse/core";

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
    textColor = newColor === "dark" ? "#ccc" : "#444";
    // re-render Table-Component
    key.value += 1;

    // Chart Options
    basicOptions = ref({
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
        },
        y: {
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
      <Chart
        :key="key"
        type="bar"
        :data="basicData"
        :options="basicOptions"
        :plugins="plugins"
      />
    </template>
  </Card>
</template>
