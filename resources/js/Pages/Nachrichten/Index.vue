<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head } from "@inertiajs/inertia-vue3";
import Message from "./Message.vue";

const props = defineProps(["settings", "messages"]);
// let messagelist = props.messages;

// const refreshMessages = (messageId) => {
//   console.log("REFRESH", messageId);
//   // props.messages = props.messages.filter(() => props.messages.id !== messageId);
//   deleteMessage(messageId);
//   messagelist = messagelist.filter((i) => i.id !== messageId);
//   console.log(messagelist);
// };

// const deleteMessage = (messageId) => {
//   axios.delete(route("messages.destroy", messageId), {}).then((response) => {
//     // showToastSuccess();
//   });
// };
</script>

<template>
  <Head title="Nachrichten" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <h1 class="text-xl font-bold">Nachrichten</h1>
      <!-- {{ messagelist }} -->
      <div v-if="messages.length === 0">Keine Nachrichten vorhanden ...</div>

      <div v-else class="mt-6 divide-y rounded-lg bg-white shadow-sm">
        <Message
          v-for="message in messages"
          :key="message.id"
          :message="message"
        />
        <!-- @messageDeleted="refreshMessages" -->
      </div>
    </div>
  </ViewLayout>
</template>
