<script setup>
import AuswertungTest from "./Auswertung/AuswertungTest.vue";
import AuswertungZeitraum from "./Auswertung/AuswertungZeitraum.vue";
import AuswertungPersonen from "./Auswertung/AuswertungPersonen.vue";
import AuswertungKlassen from "./Auswertung/AuswertungKlassen.vue";
import AuswertungAlle from "./Auswertung/AuswertungAlle.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps([
  "steps_all",
  "steps_zeitraum",
  "steps_top",
  "steps_klassen",
]);
</script>

<template>
  <Head title="Auswertung" />

  <ViewLayout>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <section class="mb-3 hidden">
        <AuswertungTest :data="steps_all" />
      </section>

      <section
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 lg:grid-cols-2"
      >
        <AuswertungZeitraum :data="steps_zeitraum" />
        <AuswertungPersonen :data="steps_top" />
      </section>

      <div class="mb-3">
        <AuswertungKlassen :data="steps_klassen" />
      </div>

      <div class="mb-3">
        <AuswertungAlle :data="steps_all" />
      </div>
    </div>
  </ViewLayout>
</template>
