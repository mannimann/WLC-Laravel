<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps(["settings", "admin_layout"]);
</script>

<template>
  <Head title="Zugriff verweigert" />

  <ViewLayout :title="settings.title">
    <AdminLayout v-if="admin_layout">
      <div class="py-12" v-motion-fade>
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow-sm sm:rounded-lg">
            <div
              class="bg-secondarybg p-6 text-center text-xl text-primary dark:bg-secondarybg_dark dark:text-primary_dark"
            >
              <p>Zugriff verweigert!</p>
              <p class="mt-3 text-md">(Keine Berechtigung)</p>
            </div>
          </div>
        </div>
      </div>
    </AdminLayout>

    <div v-else class="py-12">
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden shadow-sm sm:rounded-lg">
          <div
            class="bg-secondarybg p-6 text-center text-xl text-primary dark:bg-secondarybg_dark dark:text-primary_dark"
          >
            <p>Zugriff verweigert!</p>
            <p class="mt-3 text-md">(Keine Berechtigung)</p>
          </div>
        </div>
      </div>
    </div>
  </ViewLayout>
</template>
