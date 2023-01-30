<script setup>
defineProps({
  type: {
    type: String,
    default: "submit",
  },
});
</script>

<template>
  <button
    :type="type"
    class="btn-primary btn text-[1em] font-bold tracking-widest text-white"
  >
    <!-- class="focus:shadow-outline-gray text-xs m-3 inline-flex items-center rounded-md border border-transparent bg-green-700 px-4 py-2 font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-green-600 focus:border-gray-900 focus:outline-none active:bg-green-800" -->
    <slot />
  </button>
</template>
