<script setup>
import Table from "./Table.vue";
// import StepdataDataService from '../../services/StepdataDataService';
</script>

<template>
  <div class="card card-primary mb-3">
    <div class="card-header">
      <h3 class="panel-title text-primary">DB-Inhalt (Test):</h3>
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
      <Table :header="header" :rows="rows" sortable />
    </div>
  </div>
</template>

<script>
export default {
  components: { Table },
  data() {
    return {
      header: [
        "Id",
        "Name",
        "Vorname",
        "Klasse",
        "Von",
        "Bis",
        "Schritte",
        "createdAt",
        "updatedAt",
      ],
      rows: [],
    };
  },
  methods: {
    retrieveData() {
      // fetch('http://localhost:3000/api/stepdata')
      //   .then((response) => response.json())
      //   .then((data) => {
      //     this.rows = data;
      //     console.log(this.rows);
      //   })
      //   .catch((err) => console.log(err.message));
      // StepdataDataService.getAll()
      //   .then((res) => {
      //     this.rows = res.data;
      //     // console.log(res.data);
      //     // console.log(this.rows);
      //   })
      //   .catch((err) => {
      //     console.log("Error: ", err.message);
      //   });
    },
  },
  mounted() {
    this.retrieveData();
  },
};
</script>
