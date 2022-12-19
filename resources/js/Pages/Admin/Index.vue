<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";

const props = defineProps(["klassen", "zeiträume"]);

const form_klasse = useForm({
  klasse: "",
});
</script>

<template>
  <Head title="Administration" />

  <!-- TODO: an Chirps orientieren -->

  <ViewLayout>
    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <h2 class="text-center text-3xl font-bold">ADMIN</h2>
      <div
        class="mb-3 grid grid-cols-1 justify-items-stretch gap-3 lg:grid-cols-2"
      >
        <section id="klassen">
          <h3>Klassen:</h3>
          <div class="mr-auto max-w-2xl py-2">
            <form
              @submit.prevent="
                form_klasse.post(route('klasse.store'), {
                  onSuccess: () => form_klasse.reset(),
                })
              "
            >
              <input
                v-model="form_klasse.klasse"
                type="text"
                placeholder="Klasse eingeben"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
              <InputError :klasse="form_klasse.errors.klasse" class="mt-2" />
              <PrimaryButton class="mt-4">Hinzufügen</PrimaryButton>
            </form>
          </div>
          <ul>
            <li v-for="klasse in klassen" :key="klasse">
              {{ klasse.klasse }}
            </li>
          </ul>
        </section>
        <section id="zeiträume">
          <h3>Zeiträume:</h3>
          <ul>
            <li v-for="zeitraum in zeiträume" :key="zeitraum">
              {{ zeitraum.von }} - {{ zeitraum.bis }}
            </li>
          </ul>
        </section>
      </div>
    </div>
  </ViewLayout>
</template>
