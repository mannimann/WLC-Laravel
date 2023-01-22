<script setup>
import "vue-good-table-next/dist/vue-good-table-next.css";
import { VueGoodTable } from "vue-good-table-next";
import Card from "@/Components/Card.vue";

const props = defineProps(["data"]);

const rowStyleClassSum = function (row) {
  return row.von == "" ? "italic font-bold" : "";
};

const columns = [
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
  // {
  //   label: "Zeitraum",
  //   field: "zeitraum",
  //   type: "string",
  // },
  {
    label: "Schritte gesamt",
    field: "schritte_sum",
    type: "number",
  },
  {
    label: "Teilnehmer",
    field: "teilnehmer_count",
    type: "number",
  },
  {
    label: "Schritte pro Kopf",
    field: "schritte_pro_kopf",
    type: "number",
  },
];
</script>

<template>
  <Card>
    <template v-slot:header>
      <h3>Gesamtanzahl Schritte im Zeitraum:</h3>
    </template>

    <template v-slot:body>
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
            enabled: false,
            // initialSortBy: { field: 'von', type: 'asc' },
          }"
          :line-numbers="true"
          :row-style-class="rowStyleClassSum"
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
            enabled: false,
            // initialSortBy: { field: 'von', type: 'asc' },
          }"
          :line-numbers="true"
          :row-style-class="rowStyleClassSum"
        >
          <template #emptystate>Keine Einträge vorhanden ...</template>
          <!-- <template #table-actions-bottom>
            This will show up on the bottom of the table.
          </template> -->
        </VueGoodTable>
      </span>
    </template>
  </Card>
</template>
