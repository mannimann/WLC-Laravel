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
    <div class="flex flex-col min-h-screen bg-slate-800">
      <nav class="bg-white border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <div class="flex">
              <!-- Logo -->
              <div class="shrink-0 flex items-center">
                <Link :href="route('index')">
                  <ApplicationLogo class="block h-9 w-auto" />
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
              <div class="ml-3 relative">
                <div
                  v-if="canLogin"
                  class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
                >
                  <Link
                    :href="route('login')"
                    class="text-sm text-gray-700 dark:text-gray-500 underline"
                    >Log in</Link
                  >

                  <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                    >Register</Link
                  >
                </div>
              </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
              <button
                @click="showingNavigationDropdown = !showingNavigationDropdown"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
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
                class="hidden fixed top-0 right-0 px-6 py-4 sm:block"
              >
                <ResponsiveNavLink
                  :href="route('login')"
                  method="post"
                  as="button"
                  class="text-sm text-gray-700 dark:text-gray-500 underline"
                  >Log in</ResponsiveNavLink
                >

                <ResponsiveNavLink
                  v-if="canRegister"
                  :href="route('register')"
                  method="post"
                  as="button"
                  class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline"
                  >Register</ResponsiveNavLink
                >
              </div>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Heading -->
      <header class="bg-white shadow" v-if="$slots.header">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <slot name="header" />
        </div>
      </header>

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
