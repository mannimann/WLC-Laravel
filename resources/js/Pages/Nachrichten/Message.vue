<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

dayjs.extend(relativeTime);

const props = defineProps(["message"]);

const changeStatus = () => {
  axios
    .put(route("messages.update", props.message.id), {
      erledigt: props.message.erledigt,
    })
    .then((response) => {
      // console.log(response);
    });
};

const deletedMessageId = ref(null);
const deleteMessage = () => {
  axios
    .delete(route("messages.destroy", props.message.id), {})
    // TODO: Liste aktualisieren
    .then((response) => {
      // console.log(response);
      // props.message = props.message.filter((props.message) => props.message.id !== deletedMessageId);
      // show Toast
    });
};
</script>

<template>
  <div class="flex space-x-2 p-6">
    <div class="flex flex-col justify-between pr-2">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 -scale-x-100 text-gray-600"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="2"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
        />
      </svg>
      <input
        type="checkbox"
        class="checkbox-info checkbox"
        true-value="1"
        false-value="0"
        v-model="message.erledigt"
        @change="changeStatus"
      />
    </div>
    <div class="flex-1">
      <div class="flex items-center justify-between">
        <div>
          <span class="text-gray-800">{{ message.name }}</span>
          <small class="ml-2 text-sm text-gray-600">{{ message.klasse }}</small>
        </div>
        <small class="ml-2 text-sm text-gray-600">{{ message.email }}</small>
        <small class="ml-2 text-sm text-gray-600">{{
          dayjs(message.created_at).fromNow()
        }}</small>
      </div>
      <p class="mt-4 text-lg text-gray-900">{{ message.nachricht }}</p>
    </div>

    <!-- Löschen -->
    <!-- <Link
      :href="route('messages.destroy', message.id)"
      method="delete"
      as="button"
      class="block rounded px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
    > -->
    <label
      for="my-modal"
      as="button"
      class="btn-ghost btn block rounded px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
      @click="deletedMessageId = message.id"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        class="h-6 w-6"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
        />
      </svg>
    </label>
    <!-- </Link> -->
  </div>

  <Teleport to="body">
    <input type="checkbox" id="my-modal" class="modal-toggle" />
    <div class="modal">
      <div class="modal-box">
        <h3 class="text-lg font-bold">Wirklich löschen?</h3>
        <p class="py-4">Soll die Nachricht wirklich gelöscht werden?</p>
        <div class="modal-action">
          <label for="my-modal" class="btn" as="button">Abbrechen</label>
          <label
            for="my-modal"
            class="btn-error btn"
            @click="deleteMessage"
            as="button"
            >Löschen</label
          >
        </div>
      </div>
    </div>
  </Teleport>
</template>
