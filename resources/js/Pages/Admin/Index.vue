<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps(["klassen", "zeiträume"]);
</script>

<template>
  <Head title="Administration" />

  <!-- TODO: an Chirps orientieren -->

  <ViewLayout>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <h2 class="text-center text-3xl font-bold">ADMIN</h2>
      <div
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 lg:grid-cols-2"
      >
        <section id="klassen">
          <h3>Klassen:</h3>
          <ul>
            <li v-for="klasse in klassen" :key="klasse">
              {{ klasse.klasse }}
            </li>
          </ul>
        </section>
        <section id="zeiträume">
          <h3>Zeiträume:</h3>
          <ul>
            <li v-for="zeitraum in zeiträume" :key="zeitraum">
              {{ zeitraum.von }} - {{ zeitraum.bis }}
            </li>
          </ul>
        </section>
      </div>
    </div>
  </ViewLayout>
</template>
