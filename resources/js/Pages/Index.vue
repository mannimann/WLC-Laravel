<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps(["settings"]);
</script>

<template>
  <Head title="Wilkommen" />

  <ViewLayout :title="settings.title">
    <div
      class="relative flex pt-10 pb-5 text-center sm:min-h-[65vh] sm:items-center sm:pt-0"
    >
      <div
        class="absolute top-1/2 left-1/2 h-3/4 w-full -translate-y-1/2 -translate-x-1/2 animate-pulse rounded-[50%] bg-secondary2bg blur-2xl filter dark:bg-secondarybg_dark sm:w-5/6 md:h-2/3"
      ></div>

      <div class="container relative mx-5 my-auto p-2 sm:m-auto sm:p-10">
        <h2
          class="p-5 text-xl font-bold uppercase md:text-2xl lg:text-3xl"
          v-motion-pop
        >
          Wilkommen zur
          <span v-if="props.settings.title">{{ props.settings.title }}</span
          ><span v-else>Winterlauf Challenge</span>!
        </h2>
        <div class="flex flex-wrap justify-center">
          <div v-motion-slide-left>
            <Link :href="route('eintragen.index')">
              <PrimaryButton class="m-3">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="mr-2 h-6 w-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062A1.125 1.125 0 013 16.81V8.688zM12.75 8.688c0-.864.933-1.405 1.683-.977l7.108 4.062a1.125 1.125 0 010 1.953l-7.108 4.062a1.125 1.125 0 01-1.683-.977V8.688z"
                  />
                </svg>
                Teilnehmen
              </PrimaryButton>
            </Link>
          </div>
          <div v-motion-slide-right>
            <Link :href="route('auswertung.index')">
              <PrimaryButton class="m-3">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="mr-2 inline h-6 w-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"
                  />
                </svg>
                Zur Auswertung
              </PrimaryButton>
            </Link>
          </div>
        </div>
      </div>
    </div>
  </ViewLayout>
</template>
