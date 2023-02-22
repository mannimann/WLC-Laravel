<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Klasse from "@/Pages/Admin/Klasse.vue";
import Zeitraum from "@/Pages/Admin/Zeitraum.vue";
import Datepicker from "@vuepic/vue-datepicker";
import { useForm, Head } from "@inertiajs/vue3";
import { computed } from "vue";
import { useToast } from "vue-toastification";

const props = defineProps(["settings", "klassen", "zeiträume"]);
const toast = useToast();

const form_klasse = useForm({
  klasse: "",
  kategorie: "Schüler",
});
const form_zeitraum = useForm({
  von: "",
  bis: "",
});

const zeitraum = computed({
  get() {
    const zr = [form_zeitraum.von, form_zeitraum.bis];
    return zr;
  },
  set(zeitraum) {
    form_zeitraum.von = zeitraum[0];
    form_zeitraum.bis = zeitraum[1];
  },
});
</script>

<template>
  <Head title="Administration" />

  <ViewLayout :title="settings.title">
    <AdminLayout>
      <div class="mx-auto p-4 sm:p-6 lg:p-8">
        <h3 class="mb-3 text-2xl font-bold">Administration:</h3>

        <div
          class="mb-3 grid grid-cols-1 justify-items-stretch gap-8 lg:grid-cols-2"
        >
          <!-- Zeiträume -->
          <section id="zeiträume">
            <h4 class="text-xl font-bold">Zeiträume:</h4>
            <div class="py-2">
              <form
                @submit.prevent="
                  form_zeitraum.post(route('zeitraum.store'), {
                    onSuccess: () => {
                      toast.success('Zeitraum hinzugefügt!');
                      form_zeitraum.reset();
                    },
                    onError: (msg) => {
                      if (msg.status == 'warning') {
                        toast.warning(msg.message);
                      } else toast.error(msg.message);
                    },
                    preserveScroll: true,
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

          <!-- Klassen -->
          <section id="klassen">
            <h4 class="text-xl font-bold">Klassen:</h4>
            <div class="py-2">
              <form
                @submit.prevent="
                  form_klasse.post(route('klasse.store'), {
                    onSuccess: () => {
                      toast.success('Klasse hinzugefügt!');
                      form_klasse.reset();
                    },
                    onError: (msg) => {
                      if (msg.message) toast.error(msg.message);
                    },
                    preserveScroll: true,
                  })
                "
              >
                <div class="flex w-full">
                  <div
                    class="grid w-full grid-cols-1 content-center gap-2 sm:grid-cols-2"
                  >
                    <TextInput
                      v-model="form_klasse.klasse"
                      type="text"
                      placeholder="Klasse eingeben"
                      class="block w-full text-lg"
                    />
                    <select
                      name="kategorie"
                      v-model="form_klasse.kategorie"
                      placeholder="Kategorie"
                      class="rounded-md border-gray-300 text-lg text-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    >
                      <option value="Schüler">Schüler</option>
                      <option value="Erwachsene">Erwachsene</option>
                    </select>
                  </div>
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
                <InputError
                  :message="form_klasse.errors.kategorie"
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
        </div>
      </div>
    </AdminLayout>
  </ViewLayout>
</template>
