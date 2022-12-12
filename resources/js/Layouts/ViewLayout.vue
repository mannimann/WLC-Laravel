<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";
import Footer from "@/Components/Footer.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import DarkModeButton from "@/Components/DarkModeButton.vue";
import { Link } from "@inertiajs/inertia-vue3";

// import { useColorMode } from "@vueuse/core";
// const mode = useColorMode();
// mode.value = "dark";

// defineProps({
//     canLogin: Boolean,
//     canRegister: Boolean,
// });

const canLogin = true;
const canRegister = true;

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div class="flex min-h-screen flex-col bg-primarybg dark:bg-primarybg_dark">
    <!-- Page Heading -->
    <header class="bg-secondarybg shadow dark:bg-secondarybg_dark">
      <div class="mx-auto max-w-7xl px-4 pt-6 pb-0 sm:px-6 lg:px-8">
        <div v-if="$slots.header">
          <slot name="header" />
        </div>
        <div v-else>
          <h1 class="text-center text-4xl font-bold uppercase lg:text-5xl">
            Winterlauf Challenge
          </h1>
        </div>
      </div>
    </header>
    <nav
      class="border-b border-secondary bg-gradient-to-b from-secondarybg to-primarybg dark:border-secondary_dark dark:from-secondarybg_dark dark:to-primarybg_dark"
    >
      <!-- Primary Navigation Menu -->
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
          <div class="flex">
            <!-- Logo -->
            <div class="flex shrink-0 items-center">
              <Link :href="route('home')">
                <ApplicationLogo class="block h-9 w-auto" />
              </Link>
            </div>
            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <NavLink :href="route('home')" :active="route().current('home')">
                Eintragen
              </NavLink>
              <NavLink
                :href="route('steps.index')"
                :active="route().current('steps.index')"
              >
                Auswertung
              </NavLink>
            </div>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <DarkModeButton />
            <!-- Login/Register -->
            <div class="relative ml-3">
              <div v-if="canLogin" class="hidden px-6 py-4 sm:block">
                <Link
                  :href="route('login')"
                  class="text-sm text-secondary underline dark:text-secondary_dark"
                  >Log in</Link
                >
                <Link
                  v-if="canRegister"
                  :href="route('register')"
                  class="ml-4 text-sm text-secondary underline dark:text-secondary_dark"
                  >Register</Link
                >
              </div>
            </div>
          </div>
          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <DarkModeButton />
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center rounded-md p-2 text-secondary transition duration-150 ease-in-out hover:bg-primarybg hover:text-primary focus:bg-primarybg focus:text-primary focus:outline-none dark:text-secondary_dark dark:hover:bg-primarybg_dark dark:hover:text-primary_dark dark:focus:bg-primarybg_dark dark:focus:text-primary_dark"
            >
              <svg
                class="h-6 w-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>
      <!-- Responsive Navigation Menu -->
      <div
        :class="{
          block: showingNavigationDropdown,
          hidden: !showingNavigationDropdown,
        }"
        class="sm:hidden"
      >
        <div class="space-y-1 pt-2 pb-3">
          <ResponsiveNavLink
            :href="route('home')"
            :active="route().current('home')"
          >
            Eintragen
          </ResponsiveNavLink>
          <ResponsiveNavLink
            :href="route('steps.index')"
            :active="route().current('steps.index')"
          >
            Auswertung
          </ResponsiveNavLink>
          <!-- Responsive Login/Register -->
          <!-- TODO: dark-border-->
          <div
            v-if="canLogin"
            class="space-y-1 border-t border-gray-700 pt-1 text-secondary underline dark:text-secondary_dark"
          >
            <ResponsiveNavLink :href="route('login')">Log in</ResponsiveNavLink>
            <ResponsiveNavLink v-if="canRegister" :href="route('register')"
              >Register</ResponsiveNavLink
            >
          </div>
        </div>
      </div>
    </nav>
    <!-- Page Content -->
    <main class="text-secondary dark:text-secondary_dark">
      <slot />
    </main>
    <footer class="mt-auto">
      <Footer />
    </footer>
  </div>
</template>
