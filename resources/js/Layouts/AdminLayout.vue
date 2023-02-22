<script setup>
import NavLink from "@/Components/NavLink.vue";
import { ref } from "vue";
import { useWindowSize } from "@vueuse/core";
import { onMounted } from "vue";
import { watch } from "vue";

const links_admin = [
  { name: "Daten", route: "admin.home.index" },
  { name: "Einstellungen", route: "admin.einstellungen.index" },
  { name: "Nachrichten", route: "admin.nachrichten.index" },
  { name: "DB-Admin", route: "admin.dbadmin.index" },
  {
    name: "Nutzer",
    route: "admin.users.index",
  },
];

let scroller;
let showLeftShadow = ref(false);
let showRightShadow = ref(false);
const { width, height } = useWindowSize();
onMounted(() => {
  scroller = document.getElementById("scroller");
  showRightShadow.value = scroller.scrollLeftMax > 0 ? true : false;
});
watch(width, () => {
  showRightShadow.value = scroller.scrollLeftMax > 0 ? true : false;
});

const setShadows = (e) => {
  window.requestAnimationFrame(() => {
    if (
      e.target.scrollLeft > 0 &&
      e.target.scrollLeftMax < e.target.scrollWidth
    ) {
      showLeftShadow.value = true;
    } else {
      showLeftShadow.value = false;
    }
    if (
      e.target.scrollLeft < e.target.scrollLeftMax &&
      e.target.scrollLeftMax < e.target.scrollWidth
    ) {
      showRightShadow.value = true;
    } else {
      showRightShadow.value = false;
    }
  });
};
</script>

<template>
  <div class="relative">
    <nav
      id="scroller"
      @scroll="setShadows"
      class="scrollbar-hide -ml-2 touch-auto overflow-y-hidden overflow-x-scroll whitespace-nowrap border-b border-secondary dark:border-secondary_dark sm:mx-0 sm:px-11"
    >
      <!-- Primary Navigation Menu -->
      <div class="mx-auto px-5 sm:px-7 lg:px-9">
        <div class="flex h-16 justify-between">
          <div class="flex">
            <!-- Navigation Links -->
            <div
              class="flex space-x-4 last:pr-4 sm:-my-px sm:ml-10 md:space-x-8"
            >
              <NavLink
                v-if="$page.props.auth.user"
                v-for="link in links_admin"
                :key="link.name"
                :href="route(link.route)"
                :active="route().current(link.route)"
                preserve-state
                preserve-scroll
              >
                {{ link.name }}
              </NavLink>
            </div>
          </div>
        </div>
      </div>
    </nav>
    <Transition>
      <div
        v-show="showLeftShadow"
        class="pointer-events-none absolute inset-0 shadow-[1em_0em_1em_-0.8em_inset] shadow-secondary dark:shadow-secondary_dark"
      />
    </Transition>
    <Transition>
      <div
        v-show="showRightShadow"
        class="pointer-events-none absolute inset-0 shadow-[-1em_0em_1em_-0.8em_inset] shadow-secondary dark:shadow-secondary_dark"
      />
    </Transition>
  </div>
  <!-- Page Content -->
  <main v-motion-fade>
    <slot />
  </main>
</template>

<style scoped>
@media (max-width: 767px) {
  .scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
  .scrollbar-hide::-webkit-scrollbar {
    display: none;
  }
}

.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}
</style>
