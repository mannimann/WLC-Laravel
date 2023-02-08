<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import DarkModeButton from "@/Components/DarkModeButton.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Footer from "@/Components/Footer.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";
import Hamburger from "@/Components/Hamburger.vue";

// import { useColorMode } from "@vueuse/core";
// const mode = useColorMode();
// mode.value = "dark";

// defineProps({
//     canLogin: Boolean,
//     canRegister: Boolean,
// });

const props = defineProps(["title"]);

const canLogin = true;
const canRegister = true;

const showingNavigationDropdown = ref(false);

const links = [
  { name: "Eintragen", route: "home" },
  { name: "Auswertung", route: "steps.index" },
  { name: "Kontakt", route: "contact.index" },
];
const links_admin = [
  { name: "Administration", route: "admin.index" },
  { name: "Einstellungen", route: "settings.index" },
  { name: "Nachrichten", route: "messages.index" },
];
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
          <h1
            class="text-center text-3xl font-bold uppercase md:text-4xl lg:text-5xl"
          >
            <div v-if="title">{{ title }}</div>
            <div v-else>Winterlauf Challenge</div>
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
              <NavLink
                v-for="link in links"
                :key="link.name"
                :href="route(link.route)"
                :active="route().current(link.route)"
              >
                <!-- v-if="link.auth ? $page.props.auth.user : ''" -->
                {{ link.name }}
              </NavLink>

              <NavLink
                v-if="$page.props.auth.user"
                v-for="link in links_admin"
                :key="link.name"
                :href="route(link.route)"
                :active="route().current(link.route)"
              >
                {{ link.name }}
              </NavLink>

              <!-- <NavLink :href="route('home')" :active="route().current('home')">
                Eintragen
              </NavLink>
              <NavLink
                :href="route('steps.index')"
                :active="route().current('steps.index')"
              >
                Auswertung
              </NavLink>
              <NavLink
                :href="route('contact.index')"
                :active="route().current('contact.index')"
              >
                Kontakt
              </NavLink>
              <NavLink
                v-if="$page.props.auth.user"
                :href="route('admin.index')"
                :active="route().current('admin.index')"
              >
                Administration
              </NavLink>
              <NavLink
                v-if="$page.props.auth.user"
                :href="route('settings.index')"
                :active="route().current('settings.index')"
              >
                Einstellungen
              </NavLink> -->
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
                      Abmelden
                    </DropdownLink>
                  </template>
                </Dropdown>
              </div>

              <div v-else v-if="canLogin" class="hidden py-4 sm:block">
                <Link
                  :href="route('login')"
                  class="text-sm text-secondary underline focus:outline-none dark:text-secondary_dark"
                  >Anmelden</Link
                >
                <Link
                  v-if="canRegister"
                  :href="route('register')"
                  class="ml-4 text-sm text-secondary underline focus:outline-none dark:text-secondary_dark"
                  >Registrieren</Link
                >
              </div>
            </div>
          </div>
          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <DarkModeButton />

            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center rounded-md p-1 text-secondary transition duration-150 ease-in-out hover:bg-primarybg hover:text-primary focus:bg-primarybg focus:text-primary focus:outline-none dark:text-secondary_dark dark:hover:bg-primarybg_dark dark:hover:text-primary_dark dark:focus:bg-primarybg_dark dark:focus:text-primary_dark"
            >
              <Hamburger :active="showingNavigationDropdown" class="h-8 w-8" />
            </button>
          </div>
        </div>
      </div>
      <!-- Responsive Navigation Menu -->
      <Transition name="hamburger">
        <div v-show="showingNavigationDropdown" class="sm:hidden">
          <div class="space-y-1 pt-2 pb-3">
            <ResponsiveNavLink
              v-for="link in links"
              :key="link.name"
              :href="route(link.route)"
              :active="route().current(link.route)"
            >
              <!-- v-if="link.auth ? $page.props.auth.user : ''" -->
              {{ link.name }}
            </ResponsiveNavLink>

            <ResponsiveNavLink
              v-if="$page.props.auth.user"
              v-for="link in links_admin"
              :key="link.name"
              :href="route(link.route)"
              :active="route().current(link.route)"
            >
              {{ link.name }}
            </ResponsiveNavLink>

            <!-- <ResponsiveNavLink
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
              :href="route('contact.index')"
              :active="route().current('contact.index')"
            >
              Kontakt
            </ResponsiveNavLink>

            <ResponsiveNavLink
              v-if="$page.props.auth.user"
              :href="route('admin.index')"
              :active="route().current('admin.index')"
            >
              Administration
            </ResponsiveNavLink>
            <ResponsiveNavLink
              v-if="$page.props.auth.user"
              :href="route('settings.index')"
              :active="route().current('settings.index')"
            >
              Einstellungen
            </ResponsiveNavLink> -->

            <!-- Responsive Login/Register -->
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
                <ResponsiveNavLink
                  :href="route('logout')"
                  method="post"
                  as="button"
                >
                  Abmelden
                </ResponsiveNavLink>
              </div>
            </div>
            <div
              v-else
              v-if="canLogin"
              class="space-y-1 border-t-4 border-gray-700 pt-1 text-secondary underline dark:text-secondary_dark"
            >
              <ResponsiveNavLink :href="route('login')"
                >Anmelden</ResponsiveNavLink
              >
              <ResponsiveNavLink v-if="canRegister" :href="route('register')"
                >Registrieren</ResponsiveNavLink
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
