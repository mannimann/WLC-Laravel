<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import NavLink from "@/Components/NavLink.vue";
import Footer from "@/Components/Footer.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";

// defineProps({
//     canLogin: Boolean,
//     canRegister: Boolean,
// });

const canLogin = true;
const canRegister = true;

const showingNavigationDropdown = ref(false);
</script>

<template>
  <div>
    <!-- Page Heading -->
    <header class="shadow bg-secondarybg" v-if="$slots.header">
      <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>
    <header v-else class="shadow bg-secondarybg">
      <div class="px-4 pt-6 pb-0 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-center lg:text-5xl xl:text-6xl">
          Winterlauf Challenge
        </h1>
      </div>
    </header>

    <div class="flex flex-col min-h-screen bg-primarybg">
      <nav
        class="border-b border-secondarybg bg-gradient-to-b from-secondarybg to-primarybg"
      >
        <!-- Primary Navigation Menu -->
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="flex items-center shrink-0">
                <Link :href="route('index')">
                  <ApplicationLogo class="block w-auto h-9" />
                </Link>
              </div>

              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink
                  :href="route('index')"
                  :active="route().current('index')"
                >
                  Steps
                </NavLink>
              </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
              <!-- Login/Register -->
              <div class="relative ml-3">
                <div
                  v-if="canLogin"
                  class="fixed top-0 right-0 hidden px-6 py-4 sm:block"
                >
                  <Link
                    :href="route('login')"
                    class="text-sm text-gray-500 underline dark:text-gray-500"
                    >Log in</Link
                  >

                  <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-500 underline dark:text-gray-500"
                    >Register</Link
                  >
                </div>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
              <button
                @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500"
              >
                <svg
                  class="w-6 h-6"
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
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink
              :href="route('index')"
              :active="route().current('index')"
            >
              Steps
            </ResponsiveNavLink>
          </div>

          <!-- Responsive Login/Register -->
          <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">
              <div
                v-if="canLogin"
                class="fixed top-0 right-0 hidden px-6 py-4 sm:block"
              >
                <ResponsiveNavLink
                  :href="route('login')"
                  method="post"
                  as="button"
                  class="text-sm text-gray-500 underline dark:text-gray-500"
                  >Log in</ResponsiveNavLink
                >

                <ResponsiveNavLink
                  v-if="canRegister"
                  :href="route('register')"
                  method="post"
                  as="button"
                  class="ml-4 text-sm text-gray-500 underline dark:text-gray-500"
                  >Register</ResponsiveNavLink
                >
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main class="text-secondary">
        <slot />
      </main>

      <footer class="mt-auto">
        <Footer />
      </footer>
    </div>
  </div>
</template>
