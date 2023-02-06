<script setup>
import { Teleport } from "vue";

const show = (opts = {}) => {
  return new Promise((resolve, reject) => {
    let resolvePromise = resolve;
    let rejectPromise = reject;
  });
};

const _cancel = () => {
  resolvePromise(false);
};
const _confirm = () => {
  resolvePromise(true);
};
</script>

<template>
  <Teleport to="body">
    <input type="checkbox" id="my-modal" class="modal-toggle" />
    <div class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Wirklich löschen?</h3>
        <p class="py-4">Soll die Nachricht wirklich gelöscht werden?</p>
        <div class="modal-action">
          <label as="button" for="my-modal" class="btn" @click="_cancel"
            >Abbrechen</label
          >
          <label
            as="button"
            for="my-modal"
            class="btn-error btn"
            @click="_confirm"
            >Löschen</label
          >
        </div>
      </div>
    </div>
  </Teleport>
</template>
