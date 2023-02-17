<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/Card.vue";
import EditModal from "./EditModal.vue";
import DeleteModal from "./DeleteModal.vue";
import { Head } from "@inertiajs/inertia-vue3";
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
    label: "Aktionen",
    field: "actions",
    // width: "10px",
  },
];
</script>

<template>
  <Head title="DB-Admin" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="mb-3 text-2xl font-bold">DB-Admin:</h3>

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
              <template #table-row="props">
                <div v-if="props.column.field == 'actions'">
                  <EditModal
                    :row="props.row"
                    :klassen="klassen"
                    :zeiträume="zeiträume"
                  />
                  <DeleteModal :row="props.row" />
                </div>
              </template>
              <template #emptystate>Keine Einträge vorhanden ...</template>
            </VueGoodTable>
          </template>
        </Card>
      </div>
    </AdminLayout>
  </ViewLayout>
</template>
