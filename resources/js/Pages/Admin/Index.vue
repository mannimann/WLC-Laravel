<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";
import Klasse from "@/Pages/Admin/Klasse.vue";
import Zeitraum from "@/Pages/Admin/Zeitraum.vue";
import Datepicker from "@vuepic/vue-datepicker";

const props = defineProps(["klassen", "zeiträume"]);

const form_klasse = useForm({
  klasse: "",
});
const form_zeitraum = useForm({
  von: "",
  bis: "",
});

const zeitraum = computed({
  get() {
    // const zr = { von: form_zeitraum.von, bis: form_zeitraum.bis };
    const zr = [form_zeitraum.von, form_zeitraum.bis];
    // console.log(zr);
    return zr;
  },
  set(zeitraum) {
    // TODO: check if empty

    // console.log(zeitraum);

    form_zeitraum.von = zeitraum[0];
    form_zeitraum.bis = zeitraum[1];
  },
});

// const zeitraum = ref("");
</script>

<template>
  <Head title="Administration" />

  <ViewLayout>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <h2 class="text-center text-3xl font-bold">ADMIN</h2>
      <div
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-8 lg:grid-cols-2"
      >
        <!-- Klassen -->
        <section id="klassen">
          <h3 class="text-xl font-bold">Klassen:</h3>
          <div class="py-2">
            <form
              @submit.prevent="
                form_klasse.post(route('klasse.store'), {
                  onSuccess: () => form_klasse.reset(),
                })
              "
            >
              <div class="flex w-full">
                <input
                  v-model="form_klasse.klasse"
                  type="text"
                  placeholder="Klasse eingeben"
                  class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
                <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton>
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
          <h3 class="text-xl font-bold">Zeiträume:</h3>
          <div class="py-2">
            <form
              @submit.prevent="
                form_zeitraum.post(route('zeitraum.store'), {
                  onSuccess: () => form_zeitraum.reset(),
                })
              "
            >
              <div class="flex w-full">
                <Datepicker
                  v-model="zeitraum"
                  type="date"
                  range
                  :enable-time-picker="false"
                  placeholder="Zeitraum eingeben"
                  class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                />
                <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton>
              </div>
              <p>{{ zeitraum }}</p>
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
    </div>
  </ViewLayout>
</template>
