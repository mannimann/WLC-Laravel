<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";
import { useConfirmDialog } from "@vueuse/core";
import { Inertia } from "@inertiajs/inertia";
import { ref } from "vue";
import Message from "./Message.vue";

const props = defineProps(["settings", "messages"]);

const toast = useToast();
const showToastSuccess = function () {
  toast.success("Alle Nachrichten gelöscht!");
};

// Alle Nachrichten löschen
const revaled = ref(false);
const dialog = useConfirmDialog(revaled);
let messageIds = [];
dialog.onConfirm(() => {
  props.messages.forEach((message) => {
    messageIds.push(message.id);
  });
  Inertia.delete(route("admin.nachrichten.destroy", [messageIds]));
  showToastSuccess();
});
dialog.onCancel(() => {
  // console.log("abbrechen");
});
</script>

<template>
  <Head title="Nachrichten" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="text-2xl font-bold">Nachrichten:</h3>
        <div v-if="messages.length === 0">Keine Nachrichten vorhanden ...</div>

        <div v-else>
          <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
            <Message
              v-for="message in messages"
              :key="message.id"
              :message="message"
            />
          </div>
          <button
            type="button"
            :disabled="revaled"
            @click="dialog.reveal"
            class="btn-error btn mt-5"
          >
            Alle Nachrichten löschen
          </button>
        </div>
      </div>
    </AdminLayout>
  </ViewLayout>

  <div v-if="revaled">
    <Teleport to="body">
      <input type="checkbox" id="my-modal" class="modal-toggle" checked />
      <div class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold">Alles löschen?</h3>
          <p class="py-4">Sollen alle Nachricht wirklich gelöscht werden?</p>
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
