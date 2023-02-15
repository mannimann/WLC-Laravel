<script setup>
import { VueGoodTable } from "vue-good-table-next";
import { useColorMode } from "@vueuse/core";
import { ref, watch } from "vue";
import Card from "@/Components/Card.vue";
import dayjs from "dayjs";

const props = defineProps(["data", "zeiträume"]);

const isActive = ref(false);
function setActive() {
  isActive.value = !isActive.value;
}

const key = ref(0);
const color = useColorMode();
let theme = color.value === "dark" ? "nocturnal" : "";
watch(color, (newColor) => {
  theme = newColor === "dark" ? "nocturnal" : "";
  // re-render Table-Component
  key.value += 1;
});

const methods = {
  formatNumber: (number) => {
    let nf = new Intl.NumberFormat("de-DE");
    return nf.format(number);
  },
};

const columns = [
  {
    label: "#",
    field: "ranking",
    type: "number",
    tdClass: "font-bold",
  },
  {
    label: "Vorname",
    field: "vorname",
  },
  {
    label: "Name",
    field: "name",
  },
  {
    label: "Klasse",
    field: "klasse",
    type: "number",
  },
  {
    label: "Schritte Gesamt",
    field: "schritte_sum",
    type: "number",
    formatFn: methods.formatNumber,
  },
];

let i = 0;
props.zeiträume.forEach((zeitraum) => {
  i++;
  columns.push({
    label:
      dayjs(zeitraum["von"]).format("DD.MM.") +
      " - " +
      dayjs(zeitraum["bis"]).format("DD.MM.YY"),
    field: "zeitraum" + i,
    type: "number",
    formatFn: methods.formatNumber,
  });
});
</script>

<template>
  <Card>
    <template v-slot:header>
      <div
        class="flex justify-between text-primary dark:text-primary_dark"
        :class="{ active: isActive }"
        role="button"
        @click="setActive"
      >
        <h3>Alle Läufer:</h3>
        <div
          class="transition-all duration-500 ease-in-out"
          :class="{ 'rotate-180': isActive }"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="3.5"
            stroke="currentColor"
            class="h-9 w-9"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19.5 8.25l-7.5 7.5-7.5-7.5"
            />
          </svg>
        </div>
      </div>
    </template>

    <template v-slot:body>
      <Transition name="cardbody">
        <div v-show="isActive">
          <VueGoodTable
            :key="key"
            :columns="columns"
            :rows="data"
            :theme="theme"
            styleClass="vgt-table striped"
            :pagination-options="{
              enabled: true,
              perPage: 10,
              position: 'bottom',
              perPageDropdown: [10, 20, 30, 50, 100],
              dropdownAllowAll: true,
              nextLabel: 'Weiter',
              prevLabel: 'Zurück',
              rowsPerPageLabel: 'Anzahl pro Seite',
              ofLabel: 'von',
              allLabel: 'Alle',
            }"
            :search-options="{
              enabled: true,
              // trigger: 'enter',
              skipDiacritics: true,
              placeholder: 'Suchen...',
            }"
            :sort-options="{
              enabled: true,
              // initialSortBy: { field: 'id', type: 'asc' },
            }"
          >
            <template #emptystate>Keine Einträge vorhanden ...</template>
          </VueGoodTable>
        </div>
      </Transition>
    </template>
  </Card>
</template>

<style scoped>
.chevron-enter-from,
.chevron-leave-to {
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  transform: rotate(180deg);
}
.cardbody-enter-from,
.cardbody-leave-to {
  max-height: 0;
  overflow: hidden;
}
.cardbody-enter-active,
.cardbody-leave-active {
  transition: all 0.5s ease-in-out;
}
.cardbody-enter-to,
.cardbody-leave-from {
  max-height: 100em;
  overflow: hidden;
}
</style>
