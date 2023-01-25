<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DarkModeButton from "@/Components/DarkModeButton.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Footer from "@/Components/Footer.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

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
    <header class="bg-secondary2bg shadow dark:bg-secondarybg_dark">
      <div class="mx-auto max-w-7xl px-5 pt-6 pb-0 sm:px-7 lg:px-9">
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
      class="border-b border-secondary bg-gradient-to-b from-secondary2bg to-primarybg dark:border-secondary_dark dark:from-secondarybg_dark dark:to-primarybg_dark"
    >
      <!-- Primary Navigation Menu -->
      <div class="mx-auto px-5 sm:px-7 lg:px-9">
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
              <NavLink
                v-if="$page.props.auth.user"
                :href="route('admin.index')"
                :active="route().current('admin.index')"
              >
                Administration
              </NavLink>

              <NavLink
                :href="route('settings.index')"
                :active="route().current('settings.index')"
              >
                Settings
              </NavLink>
            </div>
          </div>
          <div class="hidden sm:ml-6 sm:flex sm:items-center">
            <DarkModeButton />
            <!-- Login/Register -->
            <div class="relative ml-3">
              <div v-if="$page.props.auth.user">
                <Dropdown
                  align="right"
                  width="48"
                  class="text-secondary underline dark:text-secondary_dark"
                >
                  <template #trigger>
                    <span class="inline-flex rounded-md">
                      <button
                        type="button"
                        class="inline-flex items-center rounded-md border border-transparent px-3 py-2 text-sm font-medium leading-4 transition duration-150 ease-in-out focus:outline-none"
                      >
                        {{ $page.props.auth.user.name }}

                        <svg
                          class="ml-2 -mr-0.5 h-4 w-4"
                          xmlns="http://www.w3.org/2000/svg"
                          viewBox="0 0 20 20"
                          fill="currentColor"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          />
                        </svg>
                      </button>
                    </span>
                  </template>

                  <template #content>
                    <DropdownLink
                      :href="route('logout')"
                      method="post"
                      as="button"
                    >
                      Log Out
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>

              <div v-else v-if="canLogin" class="hidden py-4 sm:block">
                <Link
                  :href="route('login')"
                  class="text-sm text-secondary underline focus:outline-none dark:text-secondary_dark"
                  >Log in</Link
                >
                <Link
                  v-if="canRegister"
                  :href="route('register')"
                  class="ml-4 text-sm text-secondary underline focus:outline-none dark:text-secondary_dark"
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
      <!-- TODO: Transition -->
      <Transition name="hamburger">
        <div v-show="showingNavigationDropdown" class="sm:hidden">
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
            <ResponsiveNavLink
              v-if="$page.props.auth.user"
              :href="route('admin.index')"
              :active="route().current('admin.index')"
            >
              Administration
            </ResponsiveNavLink>

            <!-- Responsive Login/Register -->
            <!-- TODO: dark-border -->
            <div v-if="$page.props.auth.user">
              <div
                class="space-y-1 border-t-4 border-gray-700 px-4 py-1 text-center text-secondary dark:text-secondary_dark"
              >
                <div
                  class="text-base font-medium text-secondary dark:text-secondary_dark"
                >
                  {{ $page.props.auth.user.name }}
                </div>
                <div
                  class="text-sm font-medium text-secondary dark:text-secondary_dark"
                >
                  {{ $page.props.auth.user.email }}
                </div>
              </div>

              <div
                class="space-y-1 border-t border-gray-700 pt-1 text-secondary underline dark:text-secondary_dark"
              >
                <ResponsiveNavLink :href="route('logout')" method="post">
                  Log Out
                </ResponsiveNavLink>
              </div>
            </div>
            <div
              v-else
              v-if="canLogin"
              class="space-y-1 border-t-4 border-gray-700 pt-1 text-secondary underline dark:text-secondary_dark"
            >
              <ResponsiveNavLink :href="route('login')"
                >Log in</ResponsiveNavLink
              >
              <ResponsiveNavLink v-if="canRegister" :href="route('register')"
                >Register</ResponsiveNavLink
              >
            </div>
          </div>
        </div>
      </Transition>
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

<style scoped>
.hamburger-enter-from,
.hamburger-leave-to {
  max-height: 0;
  overflow: hidden;
}
.hamburger-enter-active,
.hamburger-leave-active {
  transition: all 0.3s ease-in-out;
}
.hamburger-enter-to,
.hamburger-leave-from {
  max-height: 100em;
  overflow: hidden;
}
</style>
