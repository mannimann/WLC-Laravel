<script setup>
// import Table from "./Table.vue";

// import SimpleTable from "./SimpleTable.vue";

import "vue-good-table-next/dist/vue-good-table-next.css";
import { VueGoodTable } from "vue-good-table-next";
// import { useDark } from "@vueuse/core";
// import { ref, watch } from "vue";
import Card from "@/Components/Card.vue";

const props = defineProps(["steps"]);

// const isDark = ref(useDark());
// watch(isDark.value, () => {
//   console.log(useDark());
// });

// const theme = isDark.value ? "nocturnal" : "";

// const htmlElement = document.documentElement;
// const he = htmlElement.classList.contains("dark");
// console.log(htmlElement.classList.contains("dark"));

// watch(he, () => {
//   console.log(he);
// });

// const theme = htmlElement.classList.contains("dark") ? "nocturnal" : "";

const columns = [
  {
    label: "Id",
    field: "id",
    tdClass: "font-bold",
  },
  {
    label: "Name",
    field: "name",
  },
  {
    label: "Vorname",
    field: "vorname",
  },
  {
    label: "Klasse",
    field: "klasse",
  },
  {
    label: "Zeitraum",
    field: "zeitraum",
  },
  {
    label: "Schritte",
    field: "schritte",
    type: "number",
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
          :rows="steps"
          theme=""
          styleClass="vgt-table striped"
          :pagination-options="{
            enabled: true,
            perPage: 10,
            position: 'bottom',
            perPageDropdown: [10, 25, 50],
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
            initialSortBy: { field: 'id', type: 'asc' },
          }"
        >
          <template #emptystate>Keine Einträge vorhanden ...</template>
        </VueGoodTable>
      </span>

      <span class="hidden dark:inline">
        <VueGoodTable
          :columns="columns"
          :rows="steps"
          theme="nocturnal"
          styleClass="vgt-table striped"
          :pagination-options="{
            enabled: true,
            perPage: 10,
            position: 'bottom',
            perPageDropdown: [10, 25, 50],
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
            initialSortBy: { field: 'id', type: 'asc' },
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
