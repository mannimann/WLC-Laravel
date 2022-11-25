<!-- TODO: auf alle Tabellen anwenden -->
<script setup>
import { DataTable } from "simple-datatables";
</script>

<template>
  <div class="">
    <table
      id="myTable"
      ref="simpleTable"
      style="width: 100%"
      class="table-striped table"
    >
      <thead>
        <tr style="align: left">
          <th v-for="(item, index) in header" :key="item">
            {{ item }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="(row, index) in rows" :key="index">
          <td
            v-for="(item, index) in row"
            :key="index"
            :class="{ 'fw-bold': index === 0 }"
          >
            {{ item }}
          </td>
        </tr>
      </tbody>

      <tfoot v-if="footer" class="fst-italic">
        <tr>
          <td
            v-for="(item, index) in footer"
            :key="index"
            :class="{ 'fw-bold': index === 0 }"
          >
            {{ item }}
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>

<script>
export default {
  props: { header: Array, rows: Array, footer: Array, sortable: Boolean },
  data() {
    return {
      // header: ['Age', 'First Name', 'Last Name'],
      // rows: [
      //   { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
      //   { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
      //   { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
      //   { age: 38, first_name: 'Jami', last_name: 'Carney' },
      // ],
      // footer: [99, 'Vornamen', 'Nachnamen'],
    };
  },
  mounted() {
    console.log(this.$refs.simpleTable); // evtl statt #myTable verwenden
    const dataTable = new DataTable("#myTable", {
      sortable: true,
      searchable: false,
      fixedHeight: true,
      // footer: this.footer ? true : false,
      // footer: false,
      perPage: 10,
      perPageSelect: [10, 20, 50],
      labels: {
        placeholder: "Suche...",
        perPage: "{select} Einträge pro Seite",
        noRows: "Keine Einträge vorhanden",
        info: "Zeige {start} bis {end} von {rows} Einträgen",
      },
      layout: {
        top: "{search}{select}",
        bottom: "{info}{pager}",
      },
    });
  },
};
</script>

<style scoped>
thead {
  color: #ff8d00;
}
table {
  background: white;
}
</style>
