<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
// import onUpdated from "vue";

const props = defineProps(["settings", "notice"]);
// onUpdated((form.title = props.settings.title));

const form = useForm({
  title: props.settings.title,
  infotext: props.settings.infotext,
  videolink: props.settings.videolink,
  email: props.settings.email,
});
</script>

<template>
  <Head title="Einstellungen" />

  <ViewLayout :title="settings.title">
    <!-- TODO -->
    {{ notice }}
    <section id="settings" class="mx-auto p-4 sm:p-6 lg:p-8">
      <h3 class="text-2xl font-bold">Einstellungen:</h3>
      <div class="py-2">
        <!-- TODO: Feedback ob es geklappt hat -->
        <form
          @submit.prevent="
            form.post(route('settings.store'), {
              // onSuccess: () => form.reset(),
            })
          "
        >
          <label for="title" class="text-xl font-bold text-primary"
            >Titel:</label
          >
          <div class="flex w-full">
            <input
              v-model="form.title"
              type="text"
              placeholder="Titel eingeben"
              class="text-lg block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.title" class="mt-2 block" />

          <!-- TODO: mit Formatierungsoptionen? -> ENTER! -->
          <label for="infoText" class="text-xl font-bold text-primary"
            >Infotext:</label
          >
          <div class="flex w-full">
            <textarea
              v-model="form.infotext"
              type="text"
              rows="4"
              placeholder="Infotext eingeben"
              class="text-lg block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.infotext" class="mt-2 block" />

          <label for="videolink" class="text-xl font-bold text-primary"
            >Video-Link:</label
          >
          <div class="flex w-full">
            <input
              v-model="form.videolink"
              type="text"
              placeholder="Videolink einfügen"
              class="text-lg block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.videolink" class="mt-2 block" />

          <label for="email" class="text-xl font-bold text-primary"
            >Kontakt-Email:</label
          >
          <div class="flex w-full">
            <input
              v-model="form.email"
              type="email"
              placeholder="Kontakt-Email einfügen"
              class="text-lg block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.email" class="mt-2 block" />

          <div class="mt-3">
            <PrimaryButton>Aktualisieren</PrimaryButton>
            <Link :href="route('settings.create')"
              ><PrimaryButton :type="none">Zurücksetzen</PrimaryButton></Link
            >
          </div>
        </form>
      </div>
    </section>
  </ViewLayout>
</template>