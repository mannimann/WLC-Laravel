<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Message from "./Message.vue";

const props = defineProps(["settings", "messages"]);
</script>

<template>
  <Head title="Nachrichten" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <h1 class="text-xl font-bold">Nachrichten</h1>

      <div class="mt-6 divide-y rounded-lg bg-white shadow-sm">
        <Message
          v-for="message in messages"
          :key="message.id"
          :message="message"
        />
      </div>
    </div>
  </ViewLayout>
</template>
