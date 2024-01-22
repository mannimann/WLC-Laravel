<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { useToast } from "vue-toastification";

const props = defineProps(["settings"]);

const form = useForm({
  name: "",
  klasse: "",
  email: "",
  nachricht: "",
});

const submitted = ref(false);

const toast = useToast();
const showToastSuccess = function () {
  toast.success("Nachricht gesendet!");
};
const showToastError = function () {
  toast.error("Ups, das hat nicht funktioniert!");
};
</script>

<template>
  <Head title="Kontakt" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <div v-if="submitted" class="mt-10 text-center" v-motion-fade>
        <h2 class="text-2xl">Vielen Dank!</h2>
        <div class="mb-3 text-md">Wir kümmern uns um dein Anliegen.</div>
        <PrimaryButton class="m-3" type="button" @click="submitted = false"
          >Neue Nachricht schreiben</PrimaryButton
        >
      </div>

      <form
        v-else
        @submit.prevent="
          form.post(route('kontakt.store'), {
            onSuccess: () => {
              showToastSuccess();
              submitted = true;
              form.reset();
            },
            onError: () => {
              showToastError();
            },
          })
        "
        class="mx-auto w-full sm:w-3/4 md:w-2/3 lg:w-1/2"
        v-motion-fade
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
            type="text"
            rows="6"
            class="relative w-full rounded border-0 bg-white px-3 py-3 text-sm text-gray-600 placeholder-gray-400 shadow outline-none focus:outline-none focus:ring"
          />
          <InputError :message="form.errors.nachricht" class="mt-2 block" />
        </div>

        <div class="mb-3 pt-0">
          <PrimaryButton class="m-3" :disabled="form.processing" v-motion-pop
            >Nachricht senden<svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="ml-2 h-6 w-6"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"
              />
            </svg>
          </PrimaryButton>
        </div>
      </form>
    </div>
  </ViewLayout>
</template>
