<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/Card.vue";
import ScreenshotModal from "./ScreenshotModal.vue";
import EditModal from "./EditModal.vue";
import DeleteModal from "./DeleteModal.vue";
import DeleteAllModal from "./DeleteAllModal.vue";
import { Head } from "@inertiajs/vue3";
import { VueGoodTable } from "vue-good-table-next";
import { useColorMode } from "@vueuse/core";
import { ref, watch } from "vue";

const props = defineProps(["settings", "steps", "klassen", "zeiträume"]);

// Table Theme
const key = ref(0);
const color = useColorMode();
let theme = color.value === "dark" ? "nocturnal" : "";
watch(color, (newColor) => {
  theme = newColor === "dark" ? "nocturnal" : "";
  // re-render Table-Component
  key.value += 1;
});

const methods = {
  formatNumber: (number) => {
    let nf = new Intl.NumberFormat("de-DE");
    return nf.format(number);
  },
};

const columns = [
  {
    label: "Id",
    field: "id",
    type: "number",
    // tdClass: "font-bold",
  },
  {
    label: "Vorname",
    field: "vorname",
  },
  {
    label: "Name",
    field: "name",
  },
  {
    label: "Klasse",
    field: "klasse",
    type: "number",
  },
  {
    label: "Von",
    field: "von",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "dd.MM.yyyy",
  },
  {
    label: "Bis",
    field: "bis",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "dd.MM.yyyy",
  },
  {
    label: "Schritte",
    field: "schritte",
    type: "number",
    formatFn: methods.formatNumber,
  },
  {
    label: "Created At",
    field: "created_at",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "MM.dd.yy - HH:mm:ss",
    hidden: true,
  },
  {
    label: "Updated At",
    field: "updated_at",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "MM.dd.yy - HH:mm:ss",
    hidden: true,
  },
  {
    label: "Screenshot",
    field: "screenshot",
  },
  {
    label: "Aktionen",
    field: "actions",
  },
];

const row = ref(null);
const modalOpen = ref(false);
const modalType = ref(null);
const screenshotHeight = ref(80);
</script>

<template>
  <Head title="DB-Admin" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="mb-3 text-2xl font-bold">DB-Admin:</h3>

        <div class="mb-3 flex flex-wrap">
          <a :href="route('admin.export')" target="_blank">
            <button
              type="button"
              class="btn-primary btn m-3 h-fit"
              :disabled="modalOpen"
            >
              Export als Excel
            </button>
          </a>
          <div>
            <button
              type="button"
              class="btn-error btn m-3 h-fit"
              @click="
                modalOpen = true;
                modalType = 'deleteAll';
              "
              :disabled="modalOpen"
            >
              Alle Schritt-Daten löschen
            </button>
          </div>
        </div>

        <Card>
          <template v-slot:header>
            <div class="flex justify-between space-x-3">
              <h4 class="text-xl">Einträge bearbeiten oder löschen:</h4>
              <div>
                <label
                  for="minmax-range"
                  class="block text-sm font-medium text-secondary dark:text-secondary_dark"
                  >Screenshot-Größe: (Zum Vergrößern Bild anklicken)</label
                >
                <input
                  id="minmax-range"
                  type="range"
                  min="40"
                  max="500"
                  :value="screenshotHeight"
                  class="h-2 w-full cursor-pointer appearance-none rounded-lg bg-gray-300 dark:bg-gray-700"
                  @input="screenshotHeight = $event.target.value"
                />
              </div>
            </div>
          </template>
          <template v-slot:body>
            <VueGoodTable
              :key="key"
              :columns="columns"
              :rows="steps"
              :theme="theme"
              styleClass="vgt-table striped"
              :pagination-options="{
                enabled: true,
                perPage: 30,
                position: 'bottom',
                perPageDropdown: [10, 20, 30, 50],
                dropdownAllowAll: true,
                nextLabel: 'Weiter',
                prevLabel: 'Zurück',
                rowsPerPageLabel: 'Anzahl pro Seite',
                ofLabel: 'von',
                allLabel: 'Alle',
              }"
              :search-options="{
                enabled: true,
                skipDiacritics: true,
                placeholder: 'Suchen...',
              }"
              :sort-options="{
                enabled: true,
                // initialSortBy: { field: 'id', type: 'asc' },
              }"
            >
              <template #table-row="props">
                <div v-if="props.column.field == 'screenshot'">
                  <div class="flex justify-end">
                    <button
                      type="button"
                      @click="
                        modalOpen = true;
                        modalType = 'image';
                        row = props.row;
                      "
                      :disabled="modalOpen"
                      :style="{ width: screenshotHeight + 'px' }"
                    >
                      <img :src="props.row.screenshot" alt="" class="h-full" />
                    </button>
                  </div>
                </div>
                <div v-if="props.column.field == 'actions'">
                  <div class="flex justify-end">
                    <button
                      class="btn-ghost btn px-2 sm:px-3 md:px-4"
                      type="button"
                      @click="
                        modalOpen = true;
                        modalType = 'edit';
                        row = props.row;
                      "
                      :disabled="modalOpen"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
                        />
                      </svg>
                    </button>

                    <button
                      class="btn-ghost btn px-2 sm:px-3 md:px-4"
                      type="button"
                      @click="
                        modalOpen = true;
                        modalType = 'delete';
                        row = props.row;
                      "
                      :disabled="modalOpen"
                    >
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
              </template>
              <template #emptystate>Keine Einträge vorhanden ...</template>
            </VueGoodTable>
          </template>
        </Card>
      </div>
    </AdminLayout>
  </ViewLayout>

  <Teleport to="body">
    <Transition name="fade" mode="out-in">
      <div v-if="modalOpen && modalType === 'image'">
        <ScreenshotModal :row="row" @close="modalOpen = false" />
      </div>
      <div v-else-if="modalOpen && modalType === 'edit'">
        <EditModal
          :row="row"
          :klassen="klassen"
          :zeiträume="zeiträume"
          @close="modalOpen = false"
        />
      </div>
      <div v-else-if="modalOpen && modalType === 'delete'">
        <DeleteModal :row="row" @close="modalOpen = false" />
      </div>
      <div v-else-if="modalOpen && modalType === 'deleteAll'">
        <DeleteAllModal @close="modalOpen = false" />
      </div>
    </Transition>
  </Teleport>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
