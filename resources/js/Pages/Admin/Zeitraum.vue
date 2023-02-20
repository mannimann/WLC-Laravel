<script setup>
import InputError from "@/Components/InputError.vue";
import Datepicker from "@vuepic/vue-datepicker";
import dayjs from "dayjs";
import { useForm, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { useToast } from "vue-toastification";

const props = defineProps(["zeitraum"]);

const form = useForm({
  von: props.zeitraum.von,
  bis: props.zeitraum.bis,
});

const zeitraum_computed = computed({
  get() {
    const zr = [form.von, form.bis];
    // console.log(zr);
    return zr;
  },
  set(zeitraum) {
    // console.log(zeitraum);
    form.von = zeitraum[0];
    form.bis = zeitraum[1];
  },
});

const editing = ref(false);
const toast = useToast();
</script>

<template>
  <div class="flex space-x-2 p-2 px-4">
    <div class="flex-1">
      <div class="flex items-center justify-between">
        <form
          v-if="editing"
          class="flex w-full"
          @submit.prevent="
            form.put(route('zeitraum.update', zeitraum.id), {
              onSuccess: () => {
                toast.success('Zeitraum geändert!');
              },
              onError: (msg) => toast.error(msg.message),
              preserveScroll: true,
            });
            editing = false;
          "
        >
          <Datepicker
            v-model="zeitraum_computed"
            type="date"
            range
            format="dd.MM.yyyy"
            locale="de"
            cancelText="Abbrechen"
            selectText="Auswählen"
            :enable-time-picker="false"
            placeholder="Zeitraum eingeben"
            class="my-auto block w-full rounded-md border-gray-300 text-lg shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
          />
          <InputError :message="form.errors.von" class="mt-2" />
          <div class="mt-3 space-x-2">
            <!-- Speichern -->
            <button type="submit" class="btn-ghost btn ml-2">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                class="h-6 w-6 stroke-gray-700"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"
                />
              </svg>
            </button>
            <!-- Abbrechen -->
            <button
              class="btn-ghost btn"
              @click="
                editing = false;
                form.reset();
                form.clearErrors();
              "
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                class="h-6 w-6 stroke-gray-700"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </form>
        <p v-else class="w-full text-lg text-gray-900">
          {{ dayjs(zeitraum.von).format("DD.MM.YYYY") }} -
          {{ dayjs(zeitraum.bis).format("DD.MM.YYYY") }}
        </p>

        <!-- Bearbeiten -->
        <button
          class="block rounded px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
          :class="editing ? 'disabled hidden' : ''"
          @click="editing = true"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"
            />
          </svg>
        </button>

        <!-- Löschen -->
        <button
          @click="
            router.delete(route('zeitraum.destroy', zeitraum.id), {
              onSuccess: () => toast.warning('Zeitraum gelöscht!'),
              onError: (msg) => toast.error(msg.message),
              preserveScroll: true,
            })
          "
          class="block rounded px-4 py-2 text-left text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:bg-gray-100"
          preserve-scroll
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-6 w-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"
            />
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>
