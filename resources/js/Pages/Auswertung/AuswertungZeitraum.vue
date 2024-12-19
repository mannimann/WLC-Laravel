<script setup>
import { VueGoodTable } from "vue-good-table-next";
// import { useColorMode } from "@vueuse/core";
import { ref, watch } from "vue";
import Card from "@/Components/Card.vue";

const props = defineProps(["data"]);

// Table Theme
const key = ref(0);
// const color = useColorMode();
let theme = "nocturnal";
// let theme = color.value === "dark" ? "nocturnal" : "";
// watch(color, (newColor) => {
//   theme = newColor === "dark" ? "nocturnal" : "";
//   // re-render Table-Component
//   key.value += 1;
// });

const rowStyleClassSum = function (row) {
  return row.zeitraum == "Gesamt" ? "italic font-bold" : "";
};

const methods = {
  formatNumber: (number) => {
    let nf = new Intl.NumberFormat("de-DE");
    return nf.format(number);
  },
};

const columns = [
  {
    label: "Zeitraum",
    field: "zeitraum",
    type: "string",
    tdClass: "font-bold",
  },
  {
    label: "Schritte gesamt",
    field: "schritte_sum",
    type: "number",
    formatFn: methods.formatNumber,
  },
  {
    label: "Teilnehmer",
    field: "teilnehmer_count",
    type: "number",
    formatFn: methods.formatNumber,
  },
  {
    label: "Schritte pro Kopf",
    field: "schritte_pro_kopf",
    type: "number",
    formatFn: methods.formatNumber,
  },
];
</script>

<template>
  <Card>
    <template v-slot:header>
      <h3>Gesamtanzahl Schritte im Zeitraum</h3>
    </template>

    <template v-slot:body>
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
          perPageDropdown: [10, 20, 30, 50],
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
          enabled: false,
          // initialSortBy: { field: 'von', type: 'asc' },
        }"
        :line-numbers="true"
        :row-style-class="rowStyleClassSum"
      >
        <template #emptystate>Keine Einträge vorhanden ...</template>
      </VueGoodTable>
    </template>
  </Card>
</template>
