<script setup>
// import SimpleTable from './SimpleTable.vue';
</script>

<template>
  <div class="card card-primary mb-3">
    <div class="card-header">
      <h3 class="panel-title text-primary">
        Gesamtanzahl Schritte nach Klasse:
      </h3>
    </div>
    <div class="card-body">
      <!-- <SimpleTable :header="header" :rows="rows" :footer="footer" sortable /> -->
    </div>
  </div>
</template>

<script>
export default {
  components: { SimpleTable },
  data() {
    return {
      header: [
        "#",
        "Klasse",
        "Schritte gesamt",
        "Schritte pro Kopf",
        "Teilnehmer",
      ],
      rows: [
        ["1", "10/3", "397.914", "1.193.741", "3"],
        ["2", "Lehrer", "345.366", "3.799.023", "11"],
        ["3", "5/1", "331.034", "1.324.135", "4"],
        ["4", "11/1", "313.240", "313.240", "1"],
        ["5", "8/4", "276.185", "276.185", "1"],
        ["6", "11/2", "249.684", "749.052", "3"],
        ["7", "Eltern", "234.767", "10.094.970", "43"],
        ["8", "6/2", "201.220", "402.440", "2"],
        ["9", "12/5", "187.970", "187.970", "1"],
        ["10", "7/1", "166.620", "833.099", "5"],
        ["11", "8/1", "165.513", "1.324.106", "8"],
        ["12", "10/4", "165.207", "330.414", "2"],
        ["13", "6/4", "159.624", "478.873", "3"],
        ["14", "5/4", "155.175", "465.526", "3"],
        ["15", "7/4", "149.645", "149.645", "1"],
        ["16", "6/3", "133.930", "267.860", "2"],
        ["17", "12/4", "133.886", "267.772", "2"],
        ["18", "7/2", "129.142", "129.142", "1"],
        ["19", "8/2", "125.558", "376.674", "3"],
        ["20", "12/2", "120.070", "480.281", "4"],
        ["21", "5/3", "102.789", "205.578", "2"],
        ["22", "6/1", "70.875", "70.875", "1"],
        ["23", "10/1", "64.584", "258.337", "4"],
      ],
      footer: ["1000", "Klasse", "Schritte", "Schritte", "X"],
    };
  },
  mounted() {
    // fetch('http://localhost:3000/klassen_liste')
    //   .then((response) => response.json())
    //   .then((data) => (this.klassen_liste = data))
    //   .catch((err) => console.log(err.message));
  },
};
</script>
