<script setup>
// import Table from "./Table.vue";
// import SimpleTable from "./SimpleTable.vue";

import { VueGoodTable } from "vue-good-table-next";
import { useColorMode } from "@vueuse/core";
import { ref, watch } from "vue";
import Card from "@/Components/Card.vue";

const key = ref(0);
const color = useColorMode();
let theme = color.value === "dark" ? "nocturnal" : "";
watch(color, (newColor) => {
  theme = newColor === "dark" ? "nocturnal" : "";
  // re-render Table-Component
  key.value += 1;
});

const props = defineProps(["data"]);

const methods = {
  formatNumber: (number) => {
    let nf = new Intl.NumberFormat("de-DE");
    return nf.format(number);
  },
};

const columns = [
  {
    label: "Id",
    field: "id",
    type: "number",
    tdClass: "font-bold",
    // thClass: "text-primary",
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
    label: "Von",
    field: "von",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "dd.MM.yyyy",
  },
  {
    label: "Bis",
    field: "bis",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "dd.MM.yyyy",
  },
  {
    label: "Schritte",
    field: "schritte",
    type: "number",
    formatFn: methods.formatNumber,
  },
  {
    label: "Created At",
    field: "created_at",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "MM.dd.yy - HH:mm:ss",
    hidden: true,
  },
  {
    label: "Updated At",
    field: "updated_at",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "MM.dd.yy - HH:mm:ss",
    hidden: true,
  },
  {
    label: "Screenshot",
    field: "screenshot",
  },
];
</script>

<template>
  <!-- <p>Color value: {{ color }} - Theme: {{ theme }}</p> -->

  <Card>
    <template v-slot:header>
      <h3>DB-Inhalt (Test):</h3>
    </template>
    <template v-slot:body>
      <!-- <SimpleTable :header="header" :rows="steps" /> -->

      <!-- styleClass="condensed" -->
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
          enabled: true,
          // initialSortBy: { field: 'id', type: 'asc' },
        }"
      >
        <template #emptystate>Keine Einträge vorhanden ...</template>
      </VueGoodTable>

      <!-- <div v-for="step in steps">
        {{ step }}
      </div> -->
      <!-- <p>{{ isDark }}</p> -->
    </template>
  </Card>
</template>
