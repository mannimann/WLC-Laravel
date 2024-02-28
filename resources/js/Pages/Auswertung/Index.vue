<script setup>
import AuswertungTest from "./AuswertungTest.vue";
import AuswertungVBarChart from "./AuswertungVBarChart.vue";
import AuswertungHBarChart from "./AuswertungHBarChart.vue";
import AuswertungZeitraum from "./AuswertungZeitraum.vue";
import AuswertungPersonen from "./AuswertungPersonen.vue";
import AuswertungKlassen from "./AuswertungKlassen.vue";
import AuswertungAlle from "./AuswertungAlle.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps([
  "settings",
  // "steps_all",
  "steps_zeitraum",
  "steps_läufer_schüler",
  "steps_läufer_erwachsene",
  "steps_klassen",
  "steps_läufer_zeitraum",
  "zeiträume",
]);

// Auswertung Teilnehmeranzahl
const topTeilnehmer = props.steps_klassen
  .sort((a, b) => {
    return b.teilnehmer_anzahl - a.teilnehmer_anzahl;
  })
  .slice(0, 10);
const dataTeilnehmer = topTeilnehmer.map((entry) => entry.teilnehmer_anzahl);
const labelsTeilnehmer = topTeilnehmer.map((entry) => entry.klasse);

// Auswertung Schüler
const topLäuferSchüler = props.steps_läufer_schüler
  .sort((a, b) => {
    return b.schritte_sum - a.schritte_sum;
  })
  .slice(0, 5);
const dataLäuferSchüler = topLäuferSchüler.map((entry) => entry.schritte_sum);
const labelsLäuferSchüler = topLäuferSchüler.map(
  (entry) => entry.vorname + " " + entry.name + " - " + entry.klasse
);

// Auswertung Erwachsene
const topLäuferErwachsene = props.steps_läufer_erwachsene
  .sort((a, b) => {
    return b.schritte_sum - a.schritte_sum;
  })
  .slice(0, 5);
const dataLäuferErwachsene = topLäuferErwachsene.map(
  (entry) => entry.schritte_sum
);
const labelsLäuferErwachsene = topLäuferErwachsene.map(
  (entry) => entry.vorname + " " + entry.name + " - " + entry.klasse
);

// Auswertung Klassen
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
        class="mb-10 grid grid-cols-1 justify-items-stretch gap-3 xl:grid-cols-2"
        v-motion-slide-bottom
      >
        <AuswertungHBarChart
          title="Top 10 Teilnehmeranzahl"
          :data="dataTeilnehmer"
          :labels="labelsTeilnehmer"
          v-motion-fade
        />
        <AuswertungZeitraum :data="steps_zeitraum" v-motion-fade />
      </section>

      <section
        class="mb-10 grid grid-cols-1 justify-items-stretch gap-3 xl:grid-cols-2"
      >
        <AuswertungVBarChart
          title="Top 5 Klassen (Schritte pro Kopf)"
          :data="dataKlassen"
          :labels="labelsKlassen"
          v-motion-slide-bottom
        />
        <AuswertungKlassen :data="steps_klassen" v-motion-slide-bottom />
      </section>

      <section
        class="mb-10 grid grid-cols-1 justify-items-stretch gap-3 xl:grid-cols-2"
      >
        <div class="mb-10 space-y-3 md:mb-0">
          <AuswertungVBarChart
            title="Top 5 Schüler"
            :data="dataLäuferSchüler"
            :labels="labelsLäuferSchüler"
            v-motion-fade
          />
          <AuswertungPersonen
            title="Platzierungen Schüler"
            :data="steps_läufer_schüler"
            v-motion-fade
          />
        </div>

        <div class="space-y-3">
          <AuswertungVBarChart
            title="Top 5 Erwachsene"
            :data="dataLäuferErwachsene"
            :labels="labelsLäuferErwachsene"
            v-motion-fade
          />
          <AuswertungPersonen
            title="Platzierungen Erwachsene"
            :data="steps_läufer_erwachsene"
            v-motion-fade
          />
        </div>
      </section>

      <section class="mb-3">
        <AuswertungAlle
          :data="steps_läufer_zeitraum"
          :zeiträume="zeiträume"
          v-motion-fade
        />
      </section>
    </div>
  </ViewLayout>
</template>
