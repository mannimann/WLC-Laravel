<script setup>
import Table from './Table.vue';
</script>

<template>
  <div class="card card-primary mb-3">
    <div class="card-header">
      <h3 class="panel-title text-primary">Gesamtanzahl Schritte im Zeitraum:</h3>
    </div>
    <div class="card-body">
      <Table :header="header" />
    </div>
  </div>
</template>

<script>
export default {
  components: { Table },
  data() {
    return {
      header: ['Zeitraum', 'Schritte gesamt', 'Teilnehmer', 'Schritte pro Kopf'],
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
