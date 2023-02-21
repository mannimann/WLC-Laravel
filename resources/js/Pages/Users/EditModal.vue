<script setup>
import dayjs from "dayjs";
import InputError from "@/Components/InputError.vue";
import { useToast } from "vue-toastification";
import { useForm } from "@inertiajs/vue3";
import { onMounted, onUnmounted } from "vue";

const props = defineProps(["row"]);
const emit = defineEmits(["close"]);
const toast = useToast();

const form = useForm({
  permission_level: props.row.permission_level,
  type: "permission",
});

const confirm = () => {
  form.patch(route("admin.users.update", props.row.id), {
    onSuccess: () => {
      toast.success("Berechtigungs-Level geändert!");
      emit("close");
    },
    onError: (msg) => {
      toast.error(msg.message);
    },
    preserveScroll: true,
  });
};
const cancel = () => {
  emit("close");
};

onMounted(() => {
  document.body.classList.add("modal-open");
});
onUnmounted(() => {
  document.body.classList.remove("modal-open");
});
</script>

<template>
  <!-- Main modal -->
  <div
    class="fixed inset-0 z-50 flex h-full items-center justify-center overflow-y-auto overflow-x-hidden bg-black bg-opacity-40 p-4"
  >
    <div class="relative h-modal w-full max-w-2xl md:h-auto">
      <!-- Modal content -->
      <div
        class="relative mb-4 rounded-2xl bg-secondarybg shadow dark:bg-secondarybg_dark"
      >
        <!-- Modal header -->
        <div
          class="flex items-start justify-between rounded-t border-b p-6 dark:border-gray-600"
        >
          <h3 class="text-lg font-bold">Berechtigungs-Level ändern?</h3>
          <button
            type="button"
            class="ml-auto inline-flex items-center rounded-lg bg-transparent p-1.5 text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
            @click="cancel"
          >
            <svg
              class="h-5 w-5"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
        </div>
        <!-- Modal body -->
        <div class="space-y-6 p-6">
          <p
            class="text-base leading-relaxed text-secondary dark:text-secondary_dark"
          >
            Soll das Berechtigungs-Level des Nutzers geändert werden?
          </p>
          <p
            class="text-base leading-relaxed text-secondary dark:text-secondary_dark"
          >
            {{ row.name }} ({{ row.email }})<br />
            Erstellt am:
            {{ dayjs(row.created_at).format("DD.MM.YY HH:mm") }} Uhr<br />
            Berechtigungs-Level: {{ row.permission_level }}
          </p>
          <p
            class="text-sm leading-relaxed text-secondary dark:text-secondary_dark"
          >
            Hinweis: Das Berechtigungs-Level eines Nutzers mit dem gleichen
            Level wie man selbst lässt sich nicht mehr verändern!
          </p>
          <form
            class="pt-6"
            name="setPermission"
            id="setPermission"
            @submit.prevent="confirm"
          >
            <div class="form-not-empty">
              <label for="f_permission_level" class="form-label"
                >Berechtigungs-Level:</label
              >
              <select
                name="permission_level"
                class="form-select"
                id="f_permission_level"
                v-model="form.permission_level"
                @focus="addNotEmpty"
                @blur="removeNotEmpty"
              >
                <option value="3" class="form-select-option">3 - Admin</option>
                <option value="2" class="form-select-option">
                  2 - Nutzer verwalten
                </option>
                <option value="1" class="form-select-option">
                  1 - Schreiben
                </option>
                <option value="0" class="form-select-option">0 - Lesen</option>
              </select>
              <InputError
                :message="form.errors.permission_level"
                class="mt-2"
              />
            </div>
          </form>
        </div>
        <!-- Modal footer -->
        <div class="flex items-center justify-end space-x-2 rounded-b p-6">
          <button type="button" class="btn" @click="cancel">Abbrechen</button>
          <button type="submit" form="setPermission" class="btn-warning btn">
            Ändern
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
