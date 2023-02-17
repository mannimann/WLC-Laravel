<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/Card.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { VueGoodTable } from "vue-good-table-next";
import { useColorMode } from "@vueuse/core";
import { useConfirmDialog } from "@vueuse/core";
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useToast } from "vue-toastification";

const props = defineProps(["settings", "steps"]);

const toast = useToast();

// Table Theme
const key = ref(0);
const color = useColorMode();
let theme = color.value === "dark" ? "nocturnal" : "";
watch(color, (newColor) => {
  theme = newColor === "dark" ? "nocturnal" : "";
  // re-render Table-Component
  key.value += 1;
});

// Delete Modal
const revaled = ref(false);
const dialog = useConfirmDialog(revaled);
dialog.onConfirm(() => {
  // TODO
  Inertia.delete(route("admin.dbadmin.destroy", step.id), {
    preserveScroll: true,
  });
  toast.warning("Eintrag gelöscht!");
});
dialog.onCancel(() => {
  // console.log("abbrechen");
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
    tdClass: "font-bold",
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
    label: "Actions",
    field: "actions",
  },
];
</script>

<template>
  <Head title="DB-Admin" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="mb-3 text-2xl font-bold">DB-Admin:</h3>

        <!-- Modal toggle -->
        <button
          data-modal-target="staticModal"
          data-modal-toggle="staticModal"
          class="block rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
          type="button"
        >
          Toggle modal
        </button>

        <EditModal />

        <Card>
          <template v-slot:header>
            <h3>DB-Inhalt:</h3>
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
              <template #table-row="props"
                ><span v-if="props.column.field == 'actions'">
                  <!-- TODO -->
                  <!-- Delete Button -->
                  <button
                    type="button"
                    :disabled="revaled"
                    @click="dialog.reveal"
                    class="btn-ghost btn"
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
                  </button> </span
              ></template>
              <template #emptystate>Keine Einträge vorhanden ...</template>
            </VueGoodTable>
          </template>
        </Card>
      </div>
    </AdminLayout>
  </ViewLayout>

  <div v-if="revaled">
    <Teleport to="body">
      <input type="checkbox" id="my-modal" class="modal-toggle" checked />
      <div class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold">Eintrag löschen?</h3>
          <p class="py-4">Solle der Eintrag wirklich gelöscht werden?</p>
          <div class="modal-action">
            <label as="button" class="btn" @click="dialog.cancel"
              >Abbrechen</label
            >
            <label as="button" class="btn-error btn" @click="dialog.confirm"
              >Löschen</label
            >
          </div>
        </div>
      </div>
    </Teleport>
  </div>
</template>
