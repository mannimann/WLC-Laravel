<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["href", "active"]);

const classes = computed(() =>
  props.active
    ? "inline-flex items-center border-b-2 border-primary px-1 pt-1 text-sm font-bold uppercase leading-5 text-secondary transition duration-150 ease-in-out hover:text-primary focus:border-primary focus:border-primary_dark focus:outline-none dark:border-primary_dark dark:text-secondary_dark dark:hover:text-primary_dark"
    : "inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-bold uppercase leading-5 text-secondary transition duration-150 ease-in-out hover:border-primary hover:text-primary focus:border-primary focus:text-primary focus:outline-none dark:text-secondary_dark dark:hover:border-primary_dark dark:hover:text-primary_dark dark:focus:border-primary_dark dark:focus:text-primary_dark"
);
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
