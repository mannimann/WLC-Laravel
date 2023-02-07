<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { useToast } from "vue-toastification";
import { ref } from "vue";
import { useConfirmDialog } from "@vueuse/core";
import { Inertia } from "@inertiajs/inertia";

// TODO: Deutsch
// dayjs.extend(relativeTime);

const props = defineProps(["message"]);

const changeStatus = () => {
  Inertia.put(route("messages.update", props.message.id), {
    erledigt: props.message.erledigt,
  });
};

const toast = useToast();
const showToastSuccess = function () {
  toast.success("Nachricht gelöscht!");
};

// Delete Modal
const revaled = ref(false);
const dialog = useConfirmDialog(revaled);
dialog.onConfirm(() => {
  Inertia.delete(route("messages.destroy", props.message.id));
  showToastSuccess();
});
dialog.onCancel(() => {
  // console.log("abbrechen");
});
</script>

<template>
  <!-- TODO: Layout -->
  <div class="p-4">
    <!-- <div id="obere Zeile" class="flex justify-between pr-2"> -->
    <div
      id="obere Zeile"
      class="grid grid-flow-col grid-rows-2 pr-2 md:grid-flow-row md:grid-cols-3 md:grid-rows-none"
    >
      <div id="links" class="flex space-x-2 align-middle">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-6 w-6 flex-shrink-0 -scale-x-100 self-center text-gray-600"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          stroke-width="2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
          />
        </svg>
        <span class="self-center text-gray-800">{{ message.name }}</span>
        <small class="self-center text-sm text-gray-600">{{
          message.klasse
        }}</small>
      </div>
      <small
        class="ml-8 self-center text-sm text-gray-600 md:ml-2 md:text-center"
        >{{ message.email }}</small
      >
      <small class="self-center text-right text-sm text-gray-600">{{
        // dayjs(message.created_at).fromNow()
        dayjs(message.created_at).format("DD.MM.YY HH:mm")
      }}</small>
    </div>
    <div id="untere Zeile" class="mt-2 flex justify-between">
      <div class="flex">
        <div class="mr-3 mt-1">
          <input
            type="checkbox"
            class="checkbox-info checkbox"
            true-value="1"
            false-value="0"
            v-model="message.erledigt"
            @change="changeStatus"
          />
        </div>
        <p class="text-lg text-gray-900">{{ message.nachricht }}</p>
      </div>

      <!-- Löschen -->
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
      </button>
    </div>
  </div>

  <div v-if="revaled">
    <Teleport to="body">
      <input type="checkbox" id="my-modal" class="modal-toggle" checked />
      <div class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold">Wirklich löschen?</h3>
          <p class="py-4">Soll die Nachricht wirklich gelöscht werden?</p>
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
