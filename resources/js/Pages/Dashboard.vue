<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>

<template>
  <Head title="Dashboard" />

  <ViewLayout>
    <div class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
          <div
            class="bg-secondarybg p-6 text-center text-xl text-primary dark:bg-secondarybg_dark dark:text-primary_dark"
          >
            Einloggen erfolgreich!
          </div>
        </div>
      </div>
    </div>
  </ViewLayout>
</template>
