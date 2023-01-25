<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head } from "@inertiajs/inertia-vue3";

const props = defineProps(["settings"]);

const form = useForm({
  title: props.settings.title,
  infotext: props.settings.infotext,
  videolink: props.settings.videolink,
});
</script>

<template>
  <Head title="Settings" />

  <ViewLayout>
    <p>{{ settings.title }}</p>
    <p>{{ settings.infotext }}</p>
    <section id="settings" class="container mx-auto p-4">
      <h3 class="text-2xl font-bold">Settings:</h3>
      <div class="py-2">
        <form
          @submit.prevent="
            form.post(route('settings.store'), {
              onSuccess: () => form.reset(),
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
            <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton>
          </div>
          <InputError :message="form.errors.title" class="mt-2 block" />

          <!-- TODO: Enter wird nicht übernommen bzw. direkt mit Formatierung einfügen -->
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
            <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton>
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
            <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton>
          </div>
          <InputError :message="form.errors.videolink" class="mt-2 block" />
        </form>
      </div>
    </section>
  </ViewLayout>
</template>
