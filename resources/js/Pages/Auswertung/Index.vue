<script setup>
// import AuswertungAlle from "./AuswertungAlle.vue";
// import AuswertungZeitraum from "./AuswertungZeitraum.vue";
// import AuswertungPersonen from "./AuswertungPersonen.vue";
// import AuswertungKlassen from "./AuswertungKlassen.vue";
import AuswertungTest from "./AuswertungTest.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Auswertung" />

  <ViewLayout>
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <section class="mb-3">
        <div
          class="container mx-auto overflow-hidden rounded-lg bg-secondarybg shadow-md"
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
    </div>
  </ViewLayout>
</template>

<script>
export default {
  components: {
    // AuswertungZeitraum,
    // AuswertungPersonen,
    // AuswertungKlassen,
    // AuswertungAlle,
  },
  data() {
    return {
      // klassen_liste: null,
      // zeitraum_liste: null,
    };
  },
};
</script>

<style></style>
