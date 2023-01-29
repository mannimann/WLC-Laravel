<script setup>
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

defineProps(["message"]);
</script>

<template>
  <div class="flex space-x-2 p-6">
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
      <p class="text-lg mt-4 text-gray-900">{{ message.nachricht }}</p>
    </div>
  </div>
</template>
