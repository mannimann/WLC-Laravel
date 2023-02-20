<script setup>
import dayjs from "dayjs";
import { useToast } from "vue-toastification";
import { router } from "@inertiajs/vue3";
import { onMounted, onUnmounted } from "vue";

const props = defineProps(["row"]);
const emit = defineEmits(["close"]);
const toast = useToast();

const confirm = () => {
  router.delete(route("admin.users.destroy", props.row.id), {
    onSuccess: () => toast.warning("Nutzer gelöscht!"),
    onError: (msg) => {
      toast.error(msg.message);
    },
    preserveScroll: true,
  });
  emit("close");
};
const cancel = () => {
  emit("close");
};

onMounted(() => {
  document.body.classList.add("modal-open");
});
onUnmounted(() => {
  document.body.classList.remove("modal-open");
});
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
          <h3 class="text-lg font-bold">Nutzer löschen?</h3>
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
        <div class="space-y-6 p-6">
          <p
            class="text-base leading-relaxed text-secondary dark:text-secondary_dark"
          >
            Soll der Nutzer wirklich gelöscht werden?
          </p>
          <p
            class="text-base leading-relaxed text-secondary dark:text-secondary_dark"
          >
            {{ row.name }} ({{ row.email }})<br />
            Erstellt am:
            {{ dayjs(row.created_at).format("DD.MM.YY HH:mm") }} Uhr<br />
            Permission Level: {{ row.permission_level }}
          </p>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center justify-end space-x-2 rounded-b p-6">
          <button type="button" class="btn" @click="cancel">Abbrechen</button>
          <button type="button" class="btn-error btn" @click="confirm">
            Löschen
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
