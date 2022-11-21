<script setup>
// import AuswertungAlle from "./Auswertung/AuswertungAlle.vue";
// import AuswertungZeitraum from "./Auswertung/AuswertungZeitraum.vue";
// import AuswertungPersonen from "./Auswertung/AuswertungPersonen.vue";
// import AuswertungKlassen from "./Auswertung/AuswertungKlassen.vue";
import AuswertungTest from "./Auswertung/AuswertungTest.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["steps"]);
</script>

<template>
  <Head title="Auswertung" />

  <ViewLayout>
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <section class="mb-3">
        <div
          class="container mx-auto overflow-hidden rounded-lg bg-secondarybg shadow-md dark:bg-secondarybg_dark"
        >
          <AuswertungTest />
        </div>
      </section>

      <!-- <div class="col-md-6 mb-3">
        <AuswertungZeitraum />
        <AuswertungPersonen />
      </div>
      <div class="col-md-6 mb-3">
        <AuswertungKlassen />
      </div>
      <div class="col-12 mb-3">
        <AuswertungAlle />
      </div> -->

      <!-- TODO -->
      <div v-for="step in steps">
        {{ step }}
      </div>
    </div>
  </ViewLayout>
</template>

<script>
export default {
  data() {
    return {
      // klassen_liste: null,
      // zeitraum_liste: null,
    };
  },
};
</script>

<style></style>
