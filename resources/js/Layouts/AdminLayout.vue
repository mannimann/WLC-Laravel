<script setup>
import NavLink from "@/Components/NavLink.vue";

const links_admin = [
  { name: "Daten", route: "admin.home.index" },
  { name: "Einstellungen", route: "admin.einstellungen.index" },
  { name: "Nachrichten", route: "admin.nachrichten.index" },
  { name: "DB-Admin", route: "admin.dbadmin.index" },
];
</script>

<template>
  <nav
    class="scrollbar-hide -ml-2 touch-auto overflow-y-hidden overflow-x-scroll whitespace-nowrap border-b border-secondary dark:border-secondary_dark sm:mx-0 sm:px-11"
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
