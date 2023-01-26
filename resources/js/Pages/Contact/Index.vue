<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["settings"]);

const form = useForm({
  name: "",
  klasse: "",
  email: "",
  nachricht: "",
});

const submitted = false;
</script>

<template>
  <Head title="Kontakt" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <form
        @submit.prevent="
          form.post(route('contact.store'), {
            onSuccess: () => {
              // TODO
              submitted = true;
              form.reset();
            },
          })
        "
        class="mx-auto w-1/2"
      >
        <h1 class="text-xl font-bold">KONTAKT</h1>
        <p>
          Solltest du versehentlich etwas falsch eingetragen haben, kannst du
          dich hier an uns wenden.
        </p>

        <div class="mb-3 mt-3 pt-0">
          <input
            v-model="form.name"
            type="text"
            placeholder="Dein Name"
            name="name"
            class="relative w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-600 placeholder-gray-400 shadow outline-none focus:outline-none focus:ring"
          />
          <InputError :message="form.errors.name" class="mt-2 block" />
        </div>

        <div class="mb-3 mt-3 pt-0">
          <input
            v-model="form.klasse"
            type="text"
            placeholder="Deine Klasse"
            name="klasse"
            class="relative w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-600 placeholder-gray-400 shadow outline-none focus:outline-none focus:ring"
          />
          <InputError :message="form.errors.klasse" class="mt-2 block" />
        </div>

        <div class="mb-3 pt-0">
          <input
            v-model="form.email"
            type="email"
            placeholder="Email"
            name="email"
            class="relative w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-600 placeholder-gray-400 shadow outline-none focus:outline-none focus:ring"
          />
          <InputError :message="form.errors.email" class="mt-2 block" />
        </div>

        <div class="mb-3 pt-0">
          <textarea
            v-model="form.nachricht"
            placeholder="Deine Nachricht"
            name="message"
            class="relative w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-600 placeholder-gray-400 shadow outline-none focus:outline-none focus:ring"
          />
          <InputError :message="form.errors.nachricht" class="mt-2 block" />
        </div>

        <div class="mb-3 pt-0">
          <PrimaryButton>Nachricht senden</PrimaryButton>
        </div>
      </form>

      <div v-if="submitted" class="mt-10 text-center">
        <h2 class="text-2xl">Vielen Dank!</h2>
        <div class="text-md">Wir melden uns bald bei dir.</div>
      </div>
    </div>
  </ViewLayout>
</template>
