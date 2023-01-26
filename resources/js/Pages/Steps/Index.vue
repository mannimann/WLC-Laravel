<script setup>
import AuswertungTest from "./Auswertung/AuswertungTest.vue";
import AuswertungZeitraum from "./Auswertung/AuswertungZeitraum.vue";
import AuswertungPersonen from "./Auswertung/AuswertungPersonen.vue";
import AuswertungKlassen from "./Auswertung/AuswertungKlassen.vue";
import AuswertungAlle from "./Auswertung/AuswertungAlle.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps([
  "settings",
  "steps_all",
  "steps_zeitraum",
  "steps_top",
  "steps_klassen",
]);
</script>

<template>
  <Head title="Auswertung" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <section class="mb-3 hidden">
        <AuswertungTest :data="steps_all" />
      </section>

      <section
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 xl:grid-cols-2"
      >
        <div>
          <AuswertungZeitraum class="mb-3" :data="steps_zeitraum" />
          <AuswertungPersonen :data="steps_top" />
        </div>
        <AuswertungKlassen :data="steps_klassen" />
      </section>

      <section class="mb-3">
        <AuswertungAlle :data="steps_all" />
      </section>
    </div>
  </ViewLayout>
</template>
