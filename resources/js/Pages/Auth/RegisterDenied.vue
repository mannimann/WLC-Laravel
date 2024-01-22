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
              <p>Keine weiteren Registrierungen mehr möglich!</p>
              <p class="mt-3 text-md">Kontaktieren Sie den Administrator</p>

              <div class="text-sm">
                <p class="mt-10">
                  Zum Testen können folgende Zugangsdaten genutzt werden:
                </p>
                <p class="mt-3">Email: test01@mail.de</p>
                <p class="">Passwort: 1234asdf!</p>
              </div>
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
            <p>Keine weiteren Registrierungen mehr möglich!</p>
            <p class="mt-3 text-md">Kontaktieren Sie den Administrator</p>

            <div class="text-sm">
              <p class="mt-10">
                Zum Testen können folgende Zugangsdaten genutzt werden:
              </p>
              <p class="mt-3">Email: test01@mail.de</p>
              <p class="">Passwort: 1234asdf!</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </ViewLayout>
</template>
