<script setup>
import AuswertungTest from "./Auswertung/AuswertungTest.vue";
import AuswertungZeitraum from "./Auswertung/AuswertungZeitraum.vue";
import AuswertungPersonen from "./Auswertung/AuswertungPersonen.vue";
import AuswertungKlassen from "./Auswertung/AuswertungKlassen.vue";
import AuswertungAlle from "./Auswertung/AuswertungAlle.vue";

import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps(["steps"]);
</script>

<template>
  <Head title="Auswertung" />

  <ViewLayout>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <section class="mb-3 hidden">
        <AuswertungTest :steps="steps" />
      </section>

      <section
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 lg:grid-cols-2"
      >
        <AuswertungZeitraum :steps="steps" />
        <AuswertungPersonen :steps="steps" />
      </section>

      <div class="mb-3">
        <AuswertungKlassen :steps="steps" />
      </div>

      <div class="mb-3">
        <AuswertungAlle :steps="steps" />
      </div>
    </div>
  </ViewLayout>
</template>
