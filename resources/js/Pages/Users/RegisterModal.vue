<script setup>
import { useToast } from "vue-toastification";
import axios from "axios";
import { ref, onMounted, onUnmounted } from "vue";

const emit = defineEmits(["close"]);
const toast = useToast();

const cancel = () => {
  emit("close");
};

onMounted(() => {
  document.body.classList.add("modal-open");
});
onUnmounted(() => {
  document.body.classList.remove("modal-open");
});

const link = ref(null);
const newLink = () => {
  axios
    .get(route("admin.users.create"))
    .then(function (response) {
      link.value = response.data;
      toast.success("Link erzeugt!");
    })
    .catch(function (error) {
      console.log(error);
    });
};

const copyURL = async () => {
  try {
    await navigator.clipboard.writeText(link.value);
    toast.success("Link kopiert!");
  } catch ($e) {
    toast.error("Ups, das hat nicht funktioniert!");
  }
};
</script>

<template>
  <!-- Main modal -->
  <div
    class="fixed inset-0 z-50 flex h-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-40 p-4"
  >
    <div class="relative h-modal w-full max-w-2xl md:h-auto">
      <!-- Modal content -->
      <div
        class="relative mb-4 rounded-2xl bg-secondarybg shadow dark:bg-secondarybg_dark"
      >
        <!-- Modal header -->
        <div
          class="flex items-start justify-between rounded-t border-b p-6 dark:border-gray-600"
        >
          <h3 class="text-lg font-bold">Registrierungslink erzeugen</h3>
          <button
            type="button"
            class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
            @click="cancel"
          >
            <svg
              class="h-5 w-5"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
        </div>
        <!-- Modal body -->
        <div
          class="space-y-6 p-6 text-base leading-relaxed text-secondary dark:text-secondary_dark"
        >
          <p class="leading-tight">
            Neuen Registrierungslink erzeugen:<br />
            <span class="text-sm">(Der Link ist 30 Tage lang gültig.)</span>
          </p>
          <p class="text-sm">
            Hinweis: Neue Nutzer haben zunächst nur Lese-Rechte. Diese können
            nach der Registrierung angepasst werden.
          </p>
          <textarea
            id="url"
            type="text"
            rows="5"
            v-model="link"
            class="w-full cursor-text rounded bg-gray-100 text-gray-700"
            disabled
          />
          <button type="button" class="btn-primary btn m-3" @click="newLink">
            Neuer Link
          </button>
          <button
            v-if="link"
            type="button"
            class="btn-outline btn m-3"
            @click="copyURL"
          >
            Kopieren
          </button>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center justify-end space-x-2 rounded-b p-6">
          <button type="button" class="btn" @click="cancel">Schließen</button>
        </div>
      </div>
    </div>
  </div>
</template>
