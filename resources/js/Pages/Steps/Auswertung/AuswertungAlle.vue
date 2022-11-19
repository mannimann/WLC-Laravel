<script setup>
import Table from './Table.vue';
</script>

<template>
  <div class="card card-primary text-primary" id="alleTeilnehmerDiv">
    <div
      class="card-header panel-heading"
      :class="{ active: isActive }"
      id="alleTeilnehmerHeader"
      role="button"
      data-bs-toggle="collapse"
      data-bs-parent="#alleTeilnehmerDiv"
      href="#alleTeilnehmer"
      aria-expanded="false"
      aria-controls="alleTeilnehmer"
      @click="setActive"
    >
      <h3 class="panel-title">Alle Läufer:</h3>
    </div>

    <div id="alleTeilnehmer" class="card-body collapse" aria-labelledby="alleTeilnehmerHeader">
      <Table :header="header" sortable />
    </div>
  </div>
</template>

<script>
export default {
  props: ['title'],
  components: { Table },
  data() {
    return {
      isActive: false,

      // TODO: alle Zeiträume auflisten
      header: ['#', 'Vorname', 'Nachname', 'Klasse', 'Schritte gesamt'],
    };
  },
  methods: {
    setActive() {
      this.isActive = !this.isActive;
    },
  },
  mounted() {
    // fetch('http://localhost:3000/klassen_liste')
    //   .then((response) => response.json())
    //   .then((data) => (this.klassen_liste = data))
    //   .catch((err) => console.log(err.message));
  },
};
</script>

<style scoped>
.panel-heading h3:before {
  font-family: FontAwesome;
  content: '\f078';
  font-weight: 900;
  float: right;
  transition: all 0.5s;
}
.panel-heading.active h3:before {
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  transform: rotate(180deg);
}
</style>
