<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import { ref } from "vue";

const showingNavigationDropdown = ref(false);

const links_admin = [
  { name: "Daten", route: "admin.home.index" },
  { name: "Einstellungen", route: "admin.einstellungen.index" },
  { name: "Nachrichten", route: "admin.nachrichten.index" },
];
</script>

<template>
  <nav
    class="scrollbar-hide touch-auto overflow-y-hidden overflow-x-scroll whitespace-nowrap border-b border-secondary dark:border-secondary_dark sm:px-9"
  >
    <!-- Primary Navigation Menu -->
    <div class="mx-auto px-5 sm:px-7 lg:px-9">
      <div class="flex h-16 justify-between">
        <div class="flex">
          <!-- Navigation Links -->
          <div class="flex space-x-4 sm:-my-px sm:ml-10 md:space-x-8">
            <NavLink
              v-if="$page.props.auth.user"
              v-for="link in links_admin"
              :key="link.name"
              :href="route(link.route)"
              :active="route().current(link.route)"
            >
              {{ link.name }}
            </NavLink>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- Page Content -->
  <main>
    <slot />
  </main>
</template>

<style scoped>
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
