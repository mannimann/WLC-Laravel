<script setup>
// import Table from "./Table.vue";

// import SimpleTable from "./SimpleTable.vue";

import "vue-good-table-next/dist/vue-good-table-next.css";
import { VueGoodTable } from "vue-good-table-next";
import { useDark } from "@vueuse/core";
import { ref, watch, onUpdated, computed } from "vue";
import Card from "@/Components/Card.vue";

const props = defineProps(["data"]);

// const isDark = ref(useDark());
// watch(isDark.value, () => {
//   console.log(useDark());
// });

// let theme = ref("bb");

// const isDark = useDark({
//   onChanged(dark) {
//     theme.value = dark ? "nocturnal" : "";
//     console.log(dark);
//   }
// });

// onUpdated(() => {
//   theme.value = dark ? "nocturnal" : "";
//   console.log(dark);
// });

// const theme = isDark.value ? "nocturnal" : "";

// const htmlElement = document.documentElement;
// const he = htmlElement.classList.contains("dark");
// console.log(htmlElement.classList.contains("dark"));

// watch(he, () => {
//   console.log(he);
// });

// const theme = htmlElement.classList.contains("dark") ? "nocturnal" : "";

// const zeitraumX = computed(() => {
//   return steps.map((r) => {
//     return { zeitraum: `${r.von} - ${r.bis}` };
//   });
//   // return [steps.von, steps.bis];
// });

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
];
</script>

<template>
  <!-- <p>{{ theme }}</p> -->

  <Card>
    <template v-slot:header>
      <h3>DB-Inhalt (Test):</h3>
    </template>
    <template v-slot:body>
      <!-- <SimpleTable :header="header" :rows="steps" /> -->

      <!-- styleClass="condensed" -->
      <span class="dark:hidden">
        <VueGoodTable
          :columns="columns"
          :rows="data"
          theme=""
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
      </span>

      <span class="hidden dark:inline">
        <VueGoodTable
          :columns="columns"
          :rows="data"
          theme="nocturnal"
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
      </span>

      <!-- <div v-for="step in steps">
        {{ step }}
      </div> -->
      <!-- <p>{{ isDark }}</p> -->
    </template>
  </Card>
</template>
