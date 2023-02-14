<script setup>
import AuswertungTest from "./AuswertungTest.vue";
import AuswertungVBarChart from "./AuswertungVBarChart.vue";
import AuswertungHBarChart from "./AuswertungHBarChart.vue";
import AuswertungZeitraum from "./AuswertungZeitraum.vue";
import AuswertungPersonen from "./AuswertungPersonen.vue";
import AuswertungKlassen from "./AuswertungKlassen.vue";
import AuswertungAlle from "./AuswertungAlle.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps([
  "settings",
  "steps_all",
  "steps_zeitraum",
  "steps_läufer",
  "steps_klassen",
  "steps_läufer_zeitraum",
  "zeiträume",
]);

const topTeilnehmer = props.steps_klassen
  .sort((a, b) => {
    return b.teilnehmer_anzahl - a.teilnehmer_anzahl;
  })
  .slice(0, 10);
const dataTeilnehmer = topTeilnehmer.map((entry) => entry.teilnehmer_anzahl);
const labelsTeilnehmer = topTeilnehmer.map((entry) => entry.klasse);

const topLäufer = props.steps_läufer
  .sort((a, b) => {
    return b.schritte_sum - a.schritte_sum;
  })
  .slice(0, 5);
const dataLäufer = topLäufer.map((entry) => entry.schritte_sum);
const labelsLäufer = topLäufer.map(
  (entry) => entry.vorname + " " + entry.name + " - " + entry.klasse
);

const topKlassen = props.steps_klassen
  .sort((a, b) => {
    return b.schritte_pro_kopf - a.schritte_pro_kopf;
  })
  .slice(0, 5);
const dataKlassen = topKlassen.map((entry) => entry.schritte_pro_kopf);
const labelsKlassen = topKlassen.map((entry) => entry.klasse);
</script>

<template>
  <Head title="Auswertung" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <!-- <section class="mb-3">
        <AuswertungTest :data="steps_all" />
      </section> -->

      <section
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 xl:grid-cols-2"
      >
        <AuswertungHBarChart
          title="Top 10 Teilnehmeranzahl"
          :data="dataTeilnehmer"
          :labels="labelsTeilnehmer"
        />
        <AuswertungZeitraum :data="steps_zeitraum" />

        <AuswertungVBarChart
          title="Top 5 Läufer"
          :data="dataLäufer"
          :labels="labelsLäufer"
        />
        <AuswertungVBarChart
          title="Top 5 Klassen"
          :data="dataKlassen"
          :labels="labelsKlassen"
        />

        <AuswertungPersonen :data="steps_läufer" />

        <AuswertungKlassen :data="steps_klassen" />
      </section>

      <!-- <section
      class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 xl:grid-cols-2"
    >
      <div>
        <AuswertungZeitraum class="mb-3" :data="steps_zeitraum" />
        <AuswertungPersonen :data="steps_läufer" />
      </div>
      <AuswertungKlassen :data="steps_klassen" />
    </section> -->

      <section class="mb-3">
        <AuswertungAlle :data="steps_läufer_zeitraum" :zeiträume="zeiträume" />
      </section>
    </div>
  </ViewLayout>
</template>
