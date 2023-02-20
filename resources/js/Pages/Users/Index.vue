<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Card from "@/Components/Card.vue";
import EditModal from "./EditModal.vue";
import DeleteModal from "./DeleteModal.vue";
import { Head, router } from "@inertiajs/vue3";
import { VueGoodTable } from "vue-good-table-next";
import { useColorMode } from "@vueuse/core";
import { ref, watch } from "vue";
import { useToast } from "vue-toastification";

const props = defineProps(["settings", "users"]);
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

const columns = [
  {
    label: "Id",
    field: "id",
  },
  {
    label: "Name",
    field: "name",
  },
  {
    label: "Email",
    field: "email",
  },
  {
    label: "Erstellt am",
    field: "created_at",
    type: "date",
    dateInputFormat: "yyyy-MM-dd'T'HH:mm:ss.SSSSSS'Z'",
    dateOutputFormat: "MM.dd.yyyy - HH:mm 'Uhr'",
  },
  {
    label: "Permission Level",
    field: "permission_level",
    type: "number",
  },
  {
    label: "Status",
    field: "active",
    type: "number",
  },
  {
    label: "Aktionen",
    field: "actions",
  },
];

const row = ref(null);
const modalOpen = ref(false);
const modalType = ref(null);

const activate = (props) => {
  router.patch(
    route("admin.users.update", props.row.id),
    {
      type: "active",
      active: 0,
    },
    {
      onSuccess: () => {
        toast.success("Nutzer deaktiviert!");
      },
      onError: (msg) => {
        toast.error(msg.message);
      },
      preserveScroll: true,
    }
  );
};

const deactivate = (props) => {
  router.patch(
    route("admin.users.update", props.row.id),
    {
      type: "active",
      active: 1,
    },
    {
      onSuccess: () => {
        toast.success("Nutzer aktiviert!");
      },
      onError: (msg) => {
        toast.error(msg.message);
      },
      preserveScroll: true,
    }
  );
};
</script>

<template>
  <Head title="Benutzer" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="mb-3 text-2xl font-bold">Nutzer:</h3>

        <Card>
          <template v-slot:header>
            <div class="flex justify-between space-x-3">
              <h4 class="text-xl">Angemeldete Nutzer:</h4>
            </div>
          </template>
          <template v-slot:body>
            <VueGoodTable
              :key="key"
              :columns="columns"
              :rows="users"
              :theme="theme"
              styleClass="vgt-table striped"
              :pagination-options="{
                enabled: true,
                perPage: 10,
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
                initialSortBy: { field: 'permission_level', type: 'desc' },
              }"
            >
              <template #table-row="props">
                <div v-if="props.column.field == 'active'">
                  <p v-if="props.row.active == 1">Aktiviert</p>
                  <p v-else>Deaktiviert</p>
                </div>

                <div v-if="props.column.field == 'actions'">
                  <!-- (De)Aktivieren -->
                  <div class="flex justify-end">
                    <div v-if="props.row.active == 1" class="flex justify-end">
                      <button
                        class="btn-ghost btn px-2 sm:px-3 md:px-4"
                        type="button"
                        @click="activate(props)"
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
                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                          />
                        </svg>
                      </button>
                    </div>
                    <div v-else class="flex justify-end">
                      <button
                        class="btn-ghost btn px-2 sm:px-3 md:px-4"
                        type="button"
                        @click="deactivate(props)"
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
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                          />
                        </svg>
                      </button>
                    </div>

                    <!-- Bearbeiten -->
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

                    <!-- Löschen -->
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
      <div v-if="modalOpen && modalType === 'edit'">
        <EditModal :row="row" @close="modalOpen = false" />
      </div>
      <div v-else-if="modalOpen && modalType === 'delete'">
        <DeleteModal :row="row" @close="modalOpen = false" />
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
