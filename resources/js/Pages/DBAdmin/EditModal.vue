<script setup>
import InputError from "@/Components/InputError.vue";
import dayjs from "dayjs";
import { useToast } from "vue-toastification";
import { ref, computed, onUnmounted } from "vue";
import { useConfirmDialog } from "@vueuse/core";
import { useForm } from "@inertiajs/vue3";

const props = defineProps(["row", "klassen", "zeiträume"]);
const toast = useToast();

const methods = {
  formatNumber: (number) => {
    let nf = new Intl.NumberFormat("de-DE");
    return nf.format(number);
  },
};

const form = useForm({
  vorname: props.row.vorname,
  name: props.row.name,
  klasse: props.row.klasse,
  von: props.row.von,
  bis: props.row.bis,
  schritte: props.row.schritte,
});

const zeitraum = computed({
  get() {
    const zr = { von: form.von, bis: form.bis };
    return zr;
  },
  set(zeitraum) {
    form.von = zeitraum.von;
    form.bis = zeitraum.bis;
  },
});

const addNotEmpty = (e) => {
  e.target.parentElement.classList.add("form-not-empty");
};
const removeNotEmpty = (e) => {
  e.target.value === ""
    ? e.target.parentElement.classList.remove("form-not-empty")
    : null;
};

// TODO
onUnmounted(() => {
  form.reset();
  console.log("unmounted");
});
const submitForm = () => {
  form.patch(route("admin.dbadmin.update", props.row.id), {
    onSuccess: () => {
      toast.success("Daten geändert!");
      dialog.confirm();
      form.reset();
    },
    onError: () => {
      toast.warning(form.errors.message);
    },
    preserveState: true,
    preserveScroll: true,
  });
};

// Modal
const revaled = ref(false);
const dialog = useConfirmDialog(revaled);
dialog.onConfirm(() => {
  // console.log("confirm");
});
dialog.onCancel(() => {
  // console.log("abbrechen");
});
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
        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
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
                <h3 class="text-lg font-bold">Eintrag bearbeiten</h3>
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
                  Folgender Eintrag wird bearbeitet:
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

                <form
                  class="pt-6"
                  name="insertData"
                  id="insertData"
                  @submit.prevent="submitForm()"
                >
                  <div
                    class="mb-1 grid grid-cols-1 justify-items-stretch gap-3 md:grid-cols-2"
                  >
                    <div class="form-not-empty mb-6">
                      <label for="f_vorname" class="form-label">Vorname:</label>
                      <input
                        type="text"
                        class="form-input"
                        name="vorname"
                        id="f_vorname"
                        v-model="form.vorname"
                        @focus="addNotEmpty"
                        @blur="removeNotEmpty"
                        autofocus
                        autocomplete="vorname"
                      />
                      <InputError :message="form.errors.vorname" class="mt-2" />
                    </div>

                    <div class="form-not-empty mb-6">
                      <label for="f_name" class="form-label">Nachname:</label>
                      <input
                        type="text"
                        class="form-input"
                        name="name"
                        id="f_name"
                        v-model="form.name"
                        @focus="addNotEmpty"
                        @blur="removeNotEmpty"
                        autocomplete="name"
                      />
                      <InputError :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="form-not-empty mb-6">
                      <label for="f_klasse" class="form-label cursor-default"
                        >Klasse:</label
                      >
                      <select
                        name="klasse"
                        class="form-select"
                        id="f_klasse"
                        v-model="form.klasse"
                        @focus="addNotEmpty"
                        @blur="removeNotEmpty"
                      >
                        <option
                          v-for="klasse in klassen"
                          :key="klasse.klasse"
                          :value="klasse.klasse"
                          class="form-select-option"
                        >
                          {{ klasse.klasse }}
                        </option>
                      </select>
                      <InputError :message="form.errors.klasse" class="mt-2" />
                    </div>

                    <div class="form-not-empty mb-6">
                      <label for="f_zeitraum" class="form-label cursor-default"
                        >Zeitraum:</label
                      >
                      <select
                        name="zeitraum"
                        class="form-select"
                        id="f_zeitraum"
                        v-model="zeitraum"
                        @focus="addNotEmpty"
                        @blur="removeNotEmpty"
                      >
                        <option
                          v-for="zeitraum in zeiträume"
                          :key="zeitraum"
                          :value="zeitraum"
                          class="form-select-option"
                        >
                          {{ dayjs(zeitraum.von).format("DD.MM.YYYY") }} -
                          {{ dayjs(zeitraum.bis).format("DD.MM.YYYY") }}
                        </option>
                      </select>
                      <InputError :message="form.errors.von" class="mt-2" />
                    </div>

                    <div class="form-not-empty mb-6">
                      <label for="f_schritte" class="form-label"
                        >Schritte:</label
                      >
                      <input
                        type="text"
                        class="form-input"
                        name="schritte"
                        id="f_schritte"
                        v-model="form.schritte"
                        @focus="addNotEmpty"
                        @blur="removeNotEmpty"
                      />
                      <InputError
                        :message="form.errors.schritte"
                        class="mt-2"
                      />
                    </div>
                  </div>
                </form>
              </div>

              <!-- Modal footer -->
              <div
                class="flex items-center justify-end space-x-2 rounded-b p-6"
              >
                <button type="button" class="btn" @click="dialog.cancel">
                  Abbrechen
                </button>
                <button type="submit" form="insertData" class="btn-primary btn">
                  Ändern
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>
