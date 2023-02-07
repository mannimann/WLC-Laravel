<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import { useToast } from "vue-toastification";

const props = defineProps(["settings"]);

const form = useForm({
  title: props.settings.title,
  infotext: props.settings.infotext,
  videolink: props.settings.videolink,
  email: props.settings.email,
  eintragen_moeglich: props.settings.eintragen_moeglich,
  override: false,
});

const toast = useToast();
const showToast = function () {
  toast.success("Aktualisieren erfolgreich!");
};
const showToastReset = function () {
  toast.success("Daten zurückgesetzt!");
};
const showToastStandard = function () {
  toast.success("Daten als Standard gespeichert!");
};
const showToastError = function () {
  toast.error("Ups, das hat nicht funktioniert!");
};
</script>

<template>
  <Head title="Einstellungen" />

  <ViewLayout :title="settings.title">
    <section id="settings" class="mx-auto p-4 sm:p-6 lg:p-8">
      <h3 class="text-2xl font-bold">Einstellungen:</h3>
      <div class="py-2">
        <form
          @submit.prevent="
            form.post(route('settings.store'), {
              // onSuccess: () => form.reset(),
              onSuccess: () => {
                if (form.override) showToastStandard();
                else showToast();
              },
              onError: () => {
                showToastError();
              },
            })
          "
        >
          <label for="title" class="text-xl font-bold text-primary"
            >Titel:</label
          >
          <div class="flex w-full">
            <input
              v-model="form.title"
              type="text"
              placeholder="Titel eingeben"
              class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.title" class="mt-2 block" />

          <!-- TODO: mit Formatierungsoptionen? -->
          <label for="infoText" class="text-xl font-bold text-primary"
            >Infotext:</label
          >
          <div class="flex w-full">
            <textarea
              v-model="form.infotext"
              type="text"
              rows="4"
              placeholder="Infotext eingeben"
              class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.infotext" class="mt-2 block" />

          <label for="videolink" class="text-xl font-bold text-primary"
            >Video-Link:</label
          >
          <div class="flex w-full">
            <input
              v-model="form.videolink"
              type="text"
              placeholder="Videolink einfügen"
              class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.videolink" class="mt-2 block" />

          <label for="videolink" class="text-xl font-bold text-primary"
            >Eintragen möglich:</label
          >
          <input
            v-model="form.eintragen_moeglich"
            type="checkbox"
            class="toggle-primary toggle toggle-lg block"
          />
          <InputError
            :message="form.errors.eintragen_moeglich"
            class="mt-2 block"
          />

          <label for="email" class="text-xl font-bold text-primary"
            >Kontakt-Email:</label
          >
          <div class="flex w-full">
            <input
              v-model="form.email"
              type="email"
              placeholder="Kontakt-Email einfügen"
              class="block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <!-- <PrimaryButton class="mt-3">Hinzufügen</PrimaryButton> -->
          </div>
          <InputError :message="form.errors.email" class="mt-2 block" />

          <div class="mt-3">
            <PrimaryButton class="m-3" @click="form.override = false"
              >Aktualisieren</PrimaryButton
            >

            <Link :href="route('settings.create')"
              ><PrimaryButton class="m-3" type="button" @click="showToastReset"
                >Zurücksetzen</PrimaryButton
              ></Link
            >

            <PrimaryButton class="m-3" @click="form.override = true"
              >Als Standard speichern</PrimaryButton
            >
          </div>
        </form>
      </div>
    </section>
  </ViewLayout>
</template>

<style scoped>
/* DaisyUI styles to override Tailwindcss/forms -> Animation stuck */
.toggle {
  flex-shrink: 0;
  --tglbg: hsl(var(--b1));
  --handleoffset: 1.5rem /* 24px */;
  --handleoffsetcalculator: calc(var(--handleoffset) * -1);
  --togglehandleborder: 0 0;
  height: 1.5rem /* 24px */;
  width: 3rem /* 48px */;
  cursor: pointer;
  appearance: none;
  border-width: 1px;
  border-color: hsl(var(--bc) / var(--tw-border-opacity));
  --tw-border-opacity: 0.2;
  background-color: hsl(var(--bc) / var(--tw-bg-opacity));
  --tw-bg-opacity: 0.5;
  transition-duration: 300ms;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  border-radius: var(--rounded-badge, 1.9rem);
  transition: background, box-shadow var(--animation-input, 0.2s) ease-in-out;
  box-shadow: var(--handleoffsetcalculator) 0 0 2px var(--tglbg) inset,
    0 0 0 2px var(--tglbg) inset, var(--togglehandleborder);
}
[dir="rtl"] .toggle {
  --handleoffsetcalculator: calc(var(--handleoffset) * 1);
}
.toggle:focus-visible {
  outline: 2px solid hsl(var(--bc));
  outline-offset: 2px;
}
.toggle:checked,
.toggle[checked="true"],
.toggle[aria-checked="true"] {
  --handleoffsetcalculator: var(--handleoffset);
  --tw-border-opacity: 1;
  --tw-bg-opacity: 1;
}
.toggle:checked,
.toggle[checked="true"],
.toggle[aria-checked="true"] {
  --handleoffsetcalculator: var(--handleoffset);
  --tw-border-opacity: 1;
  --tw-bg-opacity: 1;
}
.toggle:checked,
.toggle[checked="true"],
.toggle[aria-checked="true"] {
  --handleoffsetcalculator: var(--handleoffset);
  --tw-border-opacity: 1;
  --tw-bg-opacity: 1;
}
[dir="rtl"] .toggle:checked,
[dir="rtl"] .toggle[checked="true"],
[dir="rtl"] .toggle[aria-checked="true"] {
  --handleoffsetcalculator: calc(var(--handleoffset) * -1);
}
[dir="rtl"] .toggle:checked,
[dir="rtl"] .toggle[checked="true"],
[dir="rtl"] .toggle[aria-checked="true"] {
  --handleoffsetcalculator: calc(var(--handleoffset) * -1);
}
[dir="rtl"] .toggle:checked,
[dir="rtl"] .toggle[checked="true"],
[dir="rtl"] .toggle[aria-checked="true"] {
  --handleoffsetcalculator: calc(var(--handleoffset) * -1);
}
.toggle:indeterminate {
  --tw-border-opacity: 1;
  --tw-bg-opacity: 1;
  box-shadow: calc(var(--handleoffset) / 2) 0 0 2px var(--tglbg) inset,
    calc(var(--handleoffset) / -2) 0 0 2px var(--tglbg) inset,
    0 0 0 2px var(--tglbg) inset;
}
[dir="rtl"] .toggle:indeterminate {
  box-shadow: calc(var(--handleoffset) / 2) 0 0 2px var(--tglbg) inset,
    calc(var(--handleoffset) / -2) 0 0 2px var(--tglbg) inset,
    0 0 0 2px var(--tglbg) inset;
}
.toggle:disabled {
  cursor: not-allowed;
  --tw-border-opacity: 1;
  border-color: hsl(var(--bc) / var(--tw-border-opacity));
  background-color: transparent;
  opacity: 0.3;
  --togglehandleborder: 0 0 0 3px hsl(var(--bc)) inset,
    var(--handleoffsetcalculator) 0 0 3px hsl(var(--bc)) inset;
}
.toggle-primary:focus-visible {
  outline: 2px solid hsl(var(--p));
}
.toggle-primary:checked,
.toggle-primary[checked="true"],
.toggle-primary[aria-checked="true"] {
  border-color: hsl(var(--p) / var(--tw-border-opacity));
  --tw-border-opacity: 0.1;
  --tw-bg-opacity: 1;
  background-color: hsl(var(--p) / var(--tw-bg-opacity));
  --tw-text-opacity: 1;
  color: hsl(var(--pc) / var(--tw-text-opacity));
}
.toggle-primary:checked,
.toggle-primary[checked="true"],
.toggle-primary[aria-checked="true"] {
  border-color: hsl(var(--p) / var(--tw-border-opacity));
  --tw-border-opacity: 0.1;
  --tw-bg-opacity: 1;
  background-color: hsl(var(--p) / var(--tw-bg-opacity));
  --tw-text-opacity: 1;
  color: hsl(var(--pc) / var(--tw-text-opacity));
}
.toggle-primary:checked,
.toggle-primary[checked="true"],
.toggle-primary[aria-checked="true"] {
  border-color: hsl(var(--p) / var(--tw-border-opacity));
  --tw-border-opacity: 0.1;
  --tw-bg-opacity: 1;
  background-color: hsl(var(--p) / var(--tw-bg-opacity));
  --tw-text-opacity: 1;
  color: hsl(var(--pc) / var(--tw-text-opacity));
}
.toggle-lg {
  --handleoffset: 2rem /* 32px */;
  height: 2rem /* 32px */;
  width: 4rem /* 64px */;
}
</style>
