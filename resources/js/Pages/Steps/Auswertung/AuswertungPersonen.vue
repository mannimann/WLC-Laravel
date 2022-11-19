<script setup>
// import SimpleTable from './SimpleTable.vue';
</script>

<template>
  <div class="card card-primary mb-3">
    <div class="card-header">
      <h3 class="panel-title text-primary">Top Läufer:</h3>
    </div>
    <div class="card-body">
      <!-- <SimpleTable :header="header" :rows="rows" /> -->
    </div>
  </div>
</template>

<script>
export default {
  components: { SimpleTable },
  data() {
    return {
      header: ["#", "Vorname", "Nachname", "Klasse", "Schritte gesamt"],
      rows: [
        { age: 40, first_name: "Dickerson", last_name: "Macdonald" },
        { age: 21, first_name: "Larsen", last_name: "Shaw" },
        { age: 89, first_name: "Geneva", last_name: "Wilson" },
        { age: 38, first_name: "Jami", last_name: "Carney" },
      ],
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
