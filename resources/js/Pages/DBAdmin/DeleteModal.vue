<script setup>
import dayjs from "dayjs";
import { useToast } from "vue-toastification";
import { ref } from "vue";
import { useConfirmDialog } from "@vueuse/core";
import { router } from "@inertiajs/vue3";

const props = defineProps(["row"]);
const toast = useToast();

const methods = {
  formatNumber: (number) => {
    let nf = new Intl.NumberFormat("de-DE");
    return nf.format(number);
  },
};

// Delete Modal
const revaled = ref(false);
const dialog = useConfirmDialog(revaled);
dialog.onConfirm(() => {
  router.delete(route("admin.dbadmin.destroy", props.row.id), {
    preserveScroll: true,
  });
  toast.warning("Eintrag gelöscht!");
});
dialog.onCancel(() => {
  // console.log("abbrechen");
});

const e = () => {
  console.log(props.row.id);
};
</script>

<template>
  <!-- Modal toggle -->
  <button class="btn-ghost btn" type="button" @click="dialog.reveal">
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

  <Teleport to="body">
    <Transition
      enter="duration-300 ease-in-out"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100"
      leave-to="opacity-0"
    >
      <div v-if="revaled">
        <!-- Main modal -->
        <div
          aria-hidden="false"
          data-modal-backdrop="static"
          tabindex="-1"
          class="fixed top-0 left-0 right-0 z-50 flex h-modal items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-40 p-4 md:inset-0 md:h-full"
        >
          <div class="relative h-full w-full max-w-2xl md:h-auto">
            <!-- Modal content -->
            <div
              class="relative rounded-2xl bg-secondarybg shadow dark:bg-secondarybg_dark"
            >
              <!-- Modal header -->
              <div
                class="flex items-start justify-between rounded-t border-b p-6 dark:border-gray-600"
              >
                <h3 class="text-lg font-bold">Eintrag löschen?</h3>
                <button
                  type="button"
                  class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                  @click="dialog.cancel"
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
                  Soll der Eintrag wirklich gelöscht werden?
                </p>
                <p
                  class="text-base leading-relaxed text-secondary dark:text-secondary_dark"
                >
                  {{ row.vorname }} {{ row.name }} - {{ row.klasse }}:
                  {{ methods.formatNumber(row.schritte) }} Schritte ({{
                    dayjs(row.von).format("DD.MM.")
                  }}
                  - {{ dayjs(row.bis).format("DD.MM.YY") }})
                </p>
              </div>
              <!-- Modal footer -->
              <div
                class="flex items-center justify-end space-x-2 rounded-b p-6"
              >
                <button type="button" class="btn" @click="dialog.cancel">
                  Abbrechen
                </button>
                <button
                  type="button"
                  class="btn-error btn"
                  @click="dialog.confirm"
                >
                  Löschen
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
