<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Klasse from "@/Pages/Admin/Klasse.vue";
import Zeitraum from "@/Pages/Admin/Zeitraum.vue";
import Datepicker from "@vuepic/vue-datepicker";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import { useToast } from "vue-toastification";
import { useConfirmDialog } from "@vueuse/core";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["settings", "klassen", "zeiträume"]);

const form_klasse = useForm({
  klasse: "",
});
const form_zeitraum = useForm({
  von: "",
  bis: "",
});

const zeitraum = computed({
  get() {
    const zr = [form_zeitraum.von, form_zeitraum.bis];
    // console.log(zr);
    return zr;
  },
  set(zeitraum) {
    // console.log(zeitraum);
    form_zeitraum.von = zeitraum[0];
    form_zeitraum.bis = zeitraum[1];
  },
});

const toast = useToast();
const showToastSuccess = function () {
  toast.success("Alle Schritt-Daten gelöscht!");
};

// Alle eingetragenen Schritt-Daten löschen
const revaled = ref(false);
const dialog = useConfirmDialog(revaled);
dialog.onConfirm(() => {
  Inertia.delete(route("admin.home.destroy"));
  showToastSuccess();
});
dialog.onCancel(() => {
  // console.log("abbrechen");
});
</script>

<template>
  <Head title="Administration" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="pb-2 text-2xl font-bold">Admin:</h3>

        <div
          class="mb-3 grid grid-cols-1 justify-items-stretch gap-8 lg:grid-cols-2"
        >
          <!-- Klassen -->
          <section id="klassen">
            <h4 class="text-xl font-bold">Klassen:</h4>
            <div class="py-2">
              <form
                @submit.prevent="
                  form_klasse.post(route('klasse.store'), {
                    onSuccess: () => form_klasse.reset(),
                  })
                "
              >
                <div class="flex w-full">
                  <TextInput
                    v-model="form_klasse.klasse"
                    type="text"
                    placeholder="Klasse eingeben"
                    class="block w-full text-lg"
                  />
                  <PrimaryButton class="mx-3 my-1 hidden sm:block"
                    >Hinzufügen</PrimaryButton
                  >
                  <PrimaryButton class="mx-3 my-1 px-5 text-lg sm:hidden"
                    >+</PrimaryButton
                  >
                </div>
                <InputError
                  :message="form_klasse.errors.klasse"
                  class="mt-2 block"
                />
              </form>
            </div>

            <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
              <Klasse
                v-for="klasse in klassen"
                :key="klasse.id"
                :klasse="klasse"
              />
            </div>
          </section>

          <!-- Zeiträume -->
          <section id="zeiträume">
            <h4 class="text-xl font-bold">Zeiträume:</h4>
            <div class="py-2">
              <form
                @submit.prevent="
                  form_zeitraum.post(route('zeitraum.store'), {
                    onSuccess: () => form_zeitraum.reset(),
                  })
                "
              >
                <div class="align-center flex w-full">
                  <Datepicker
                    v-model="zeitraum"
                    type="date"
                    range
                    format="dd.MM.yyyy"
                    locale="de"
                    cancelText="Abbrechen"
                    selectText="Auswählen"
                    :enable-time-picker="false"
                    placeholder="Zeitraum eingeben"
                    class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                  />
                  <PrimaryButton class="mx-3 my-1 hidden sm:block"
                    >Hinzufügen</PrimaryButton
                  >
                  <PrimaryButton class="mx-3 my-1 px-5 text-lg sm:hidden"
                    >+</PrimaryButton
                  >
                </div>
                <InputError
                  :message="form_zeitraum.errors.von"
                  class="mt-2 block"
                />
              </form>
            </div>

            <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
              <Zeitraum
                v-for="zeitraum in zeiträume"
                :key="zeitraum.id"
                :zeitraum="zeitraum"
              />
            </div>
          </section>
        </div>
        <button
          type="button"
          :disabled="revaled"
          @click="dialog.reveal"
          class="btn-error btn mt-5"
        >
          Alle Schritt-Daten löschen
        </button>
      </div>
    </AdminLayout>
  </ViewLayout>

  <div v-if="revaled">
    <Teleport to="body">
      <input type="checkbox" id="my-modal" class="modal-toggle" checked />
      <div class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold">Alles löschen?</h3>
          <p class="pt-4">
            Sollen alle eingetragenen Schritt-Daten wirklich gelöscht werden?
          </p>
          <p class="pb-4">
            Dieser Vorgang kann nicht rückgängig gemacht werden!
          </p>
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
