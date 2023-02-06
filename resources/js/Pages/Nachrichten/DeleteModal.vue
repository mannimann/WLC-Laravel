<script setup>
import { Teleport } from "vue";
const emit = defineEmits(["answer"]);

const _cancel = () => {
  emit("answer", false);
};
const _confirm = () => {
  emit("answer", true);
};
</script>

<template>
  <Teleport to="body">
    <input type="checkbox" id="my-modal" class="modal-toggle" checked />
    <div class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Wirklich löschen?</h3>
        <p class="py-4">Soll die Nachricht wirklich gelöscht werden?</p>
        <div class="modal-action">
          <label as="button" class="btn" @click="_cancel">Abbrechen</label>
          <label as="button" class="btn-error btn" @click="_confirm"
            >Löschen</label
          >
        </div>
      </div>
    </div>
  </Teleport>
</template>
