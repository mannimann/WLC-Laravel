import "./bootstrap";
import "../css/app.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";

// my imports
import Toast from "vue-toastification";
import PrimeVue from "primevue/config";

import "@vuepic/vue-datepicker/dist/main.css";
import "vue-toastification/dist/index.css";
import "vue-good-table-next/dist/vue-good-table-next.css";
// import 'flowbite';

const appName =
  window.document.getElementsByTagName("title")[0]?.innerText || "WLC";

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob("./Pages/**/*.vue")
    ),
  setup({ el, app, props, plugin }) {
    return createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(ZiggyVue, Ziggy)
      .use(Toast, {
        transition: "Vue-Toastification__bounce",
        // transition: "Vue-Toastification__slideBlurred",
        maxToasts: 5,
        newestOnTop: true,
        position: "top-right",
        timeout: 3000,
        closeOnClick: true,
        pauseOnFocusLoss: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: false,
        closeButton: "button",
        icon: true,
        rtl: false,
      })
      .use(PrimeVue)
      .mount(el);
  },
});

InertiaProgress.init({ color: "#4B5563" });
