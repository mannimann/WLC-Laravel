<script setup>
import "vue-good-table-next/dist/vue-good-table-next.css";
import { VueGoodTable } from "vue-good-table-next";
import Card from "@/Components/Card.vue";

const props = defineProps(["data"]);

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
    label: "Klasse",
    field: "klasse",
    type: "number",
  },
  {
    label: "Schritte pro Kopf",
    field: "schritte_pro_kopf",
    type: "number",
    formatFn: methods.formatNumber,
  },
  {
    label: "Schritte Gesamt",
    field: "schritte_sum",
    type: "number",
    formatFn: methods.formatNumber,
  },
  {
    label: "Anzahl Teilnehmer",
    field: "teilnehmer_anzahl",
    type: "number",
    formatFn: methods.formatNumber,
  },
];
</script>

<template>
  <Card>
    <template v-slot:header>
      <h3>Gesamtanzahl Schritte nach Klasse:</h3>
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
            perPage: 20,
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
            initialSortBy: { field: 'ranking', type: 'asc' },
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
            initialSortBy: { field: 'ranking', type: 'asc' },
          }"
        >
          <template #emptystate>Keine Einträge vorhanden ...</template>
        </VueGoodTable>
      </span>
    </template>
  </Card>
</template>
