<script setup>
import "vue-good-table-next/dist/vue-good-table-next.css";
import { VueGoodTable } from "vue-good-table-next";
import Card from "@/Components/Card.vue";
import { ref } from "vue";

const isActive = ref(false);
function setActive() {
  isActive.value = !isActive.value;
}

const props = defineProps(["data"]);

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
];
</script>

<template>
  <Card>
    <template v-slot:header>
      <div
        class="flex justify-between text-primary dark:text-primary_dark"
        :class="{ active: isActive }"
        role="button"
        @click="setActive"
      >
        <h3>Alle Läufer:</h3>
        <div
          class="transition-all duration-500 ease-in-out"
          :class="{ 'rotate-180': isActive }"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="3.5"
            stroke="currentColor"
            class="h-9 w-9"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19.5 8.25l-7.5 7.5-7.5-7.5"
            />
          </svg>
        </div>
      </div>
    </template>

    <template v-slot:body>
      <Transition name="cardbody">
        <div v-show="isActive">
          <span class="dark:hidden">
            <VueGoodTable
              :columns="columns"
              :rows="data"
              theme=""
              styleClass="vgt-table striped"
              :pagination-options="{
                enabled: true,
                perPage: 10,
                position: 'bottom',
                perPageDropdown: [10, 25, 50],
                dropdownAllowAll: true,
                nextLabel: 'Weiter',
                prevLabel: 'Zurück',
                rowsPerPageLabel: 'Anzahl pro Seite',
                ofLabel: 'von',
                allLabel: 'Alle',
              }"
              :search-options="{
                enabled: true,
                // trigger: 'enter',
                skipDiacritics: true,
                placeholder: 'Suchen...',
              }"
              :sort-options="{
                enabled: true,
                // initialSortBy: { field: 'id', type: 'asc' },
              }"
            >
              <template #emptystate>Keine Einträge vorhanden ...</template>
            </VueGoodTable>
          </span>

          <span class="hidden dark:inline">
            <VueGoodTable
              :columns="columns"
              :rows="data"
              theme="nocturnal"
              styleClass="vgt-table striped"
              :pagination-options="{
                enabled: true,
                perPage: 10,
                position: 'bottom',
                perPageDropdown: [10, 25, 50],
                dropdownAllowAll: true,
                nextLabel: 'Weiter',
                prevLabel: 'Zurück',
                rowsPerPageLabel: 'Anzahl pro Seite',
                ofLabel: 'von',
                allLabel: 'Alle',
              }"
              :search-options="{
                enabled: true,
                // trigger: 'enter',
                skipDiacritics: true,
                placeholder: 'Suchen...',
              }"
              :sort-options="{
                enabled: true,
                // initialSortBy: { field: 'id', type: 'asc' },
              }"
            >
              <template #emptystate>Keine Einträge vorhanden ...</template>
            </VueGoodTable>
          </span>
        </div>
      </Transition>
    </template>
  </Card>
</template>

<style scoped>
.chevron-enter-from,
.chevron-leave-to {
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  transform: rotate(180deg);
}
.cardbody-enter-from,
.cardbody-leave-to {
  max-height: 0;
  overflow: hidden;
}
.cardbody-enter-active,
.cardbody-leave-active {
  transition: all 0.5s ease-in-out;
}
.cardbody-enter-to,
.cardbody-leave-from {
  max-height: 100em;
  overflow: hidden;
}
</style>
