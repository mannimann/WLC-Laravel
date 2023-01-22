<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["href", "active"]);

const classes = computed(() =>
  props.active
    ? "block pl-3 pr-4 py-2 border-l-4 border-primary text-base font-medium text-secondary bg-primarybg dark:text-secondary_dark dark:bg-primarybg_dark hover:text-primary hover:bg-secondarybg dark:hover:text-primary dark:hover:bg-secondarybg_dark focus:outline-none focus:text-primary focus:bg-secondarybg focus:border-primary transition duration-150 ease-in-out"
    : "block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-secondary bg-primarybg dark:text-secondary_dark dark:bg-primarybg_dark hover:text-primary hover:bg-secondarybg dark:hover:text-primary dark:hover:bg-secondarybg_dark hover:border-primary focus:outline-none focus:text-primary focus:bg-secondarybg focus:border-primary transition duration-150 ease-in-out"
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
