<script setup>
// import Table from "./Table.vue";
// import StepdataDataService from '../../services/StepdataDataService';

import SimpleTable from "./SimpleTable.vue";

// import DataTable from "@andresouzaabreu/vue-data-table";
// Vue.component("data-table", DataTable);

const props = defineProps(["steps"]);

const header = [
  "Id",
  "Name",
  "Vorname",
  "Klasse",
  "Zeitraum",
  "Schritte",
  "createdAt",
  "updatedAt",
];
</script>

<template>
  <div class="card card-primary mb-3">
    <div class="card-header">
      <h3 class="panel-title text-primary dark:text-primary_dark">
        DB-Inhalt (Test):
      </h3>
    </div>
    <div class="card-body">
      <!-- <table>
        <tr>
          <th v-for="row in header">{{ row }}</th>
        </tr>
        <tr v-for="(row, index) in rows" :key="index">
          <td v-for="(item, index) in row" :key="index" :class="{ 'fw-bold': index === 0 }">{{ item }}</td>
        </tr>
      </table> -->

      <!-- <Table :header="header" :rows="rows" sortable /> -->

      <!-- <DataTable v-bind="bindings" /> -->

      <SimpleTable :header="header" :rows="steps" />

      <!-- <div v-for="step in steps">
        {{ step }}
      </div> -->
    </div>
  </div>
</template>
