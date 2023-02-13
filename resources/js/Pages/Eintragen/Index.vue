<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import { computed, ref, Transition } from "vue";
import Card from "@/Components/Card.vue";
import moment from "moment";
import { useToast } from "vue-toastification";

const submitted = ref(false);

// Dropdown-Animation
const isActive = ref(false);
function setActive() {
  isActive.value = !isActive.value;
}

const form = useForm({
  vorname: "",
  name: "",
  klasse: "",
  von: "",
  bis: "",
  schritte: "",
  screenshot: "",
});

const props = defineProps(["settings", "klassen", "zeiträume"]);

const zeitraum = computed({
  get() {
    const zr = { von: form.von, bis: form.bis };
    return zr;
  },
  set(zeitraum) {
    form.von = zeitraum.von;
    form.bis = zeitraum.bis;
  },
});

const toast = useToast();
const showToastSuccess = function () {
  toast.success("Daten erfolgreich eingetragen!");
};
const showToastError = function (message) {
  if (message) toast.error(message);
  // toast.error("Du hast dich für diesen Zeitraum bereits eingetragen!");
};

const e = () => {
  console.log(form.screenshot);
};

const addNotEmpty = (e) => {
  e.target.parentElement.classList.add("form-not-empty");
};
const removeNotEmpty = (e) => {
  e.target.value === ""
    ? e.target.parentElement.classList.remove("form-not-empty")
    : null;
};

// Bilder verkleinern (clientseitig)
const fileChanged = (e) => {
  form.screenshot = "";
  for (var i = 0; i < e.target.files.length; i++) {
    var file = e.target.files[i];
    if (file.type == "image/jpeg" || file.type == "image/png") {
      var reader = new FileReader();
      reader.onload = (readerEvent) => {
        var image = new Image();
        image.onload = (imageEvent) => {
          var max_size = 860;
          var w = image.width;
          var h = image.height;
          if (w > h) {
            if (w > max_size) {
              h *= max_size / w;
              w = max_size;
            }
          } else {
            if (h > max_size) {
              w *= max_size / h;
              h = max_size;
            }
          }
          var canvas = document.createElement("canvas");
          canvas.width = w;
          canvas.height = h;
          canvas.getContext("2d").drawImage(image, 0, 0, w, h);
          if (file.type == "image/jpeg") {
            var dataURL = canvas.toDataURL("image/jpeg", 1);
          } else {
            var dataURL = canvas.toDataURL("image/png");
          }
          console.log(dataURL);
          // document.getElementById('f_screenshot_hidden').value += dataURL + '|';
          form.screenshot += dataURL + "|";
        };
        image.src = readerEvent.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      e.target.value = "";
      alert("Bitte wählen Sie nur Bilder im JPG- oder PNG-Format aus.");
      return false;
    }
  }
};
</script>

<template>
  <Head title="Eintragen" />

  <ViewLayout :title="settings.title">
    <div class="mx-auto p-4 sm:p-6 lg:p-8">
      <!-- Submitted -->
      <div v-if="submitted">
        <Card class="container mx-auto p-8 text-center">
          <template v-slot:header>
            <h3>Daten erfolgreich eingetragen</h3>
          </template>
          <template v-slot:body>
            <div class="m-3 text-center">
              <PrimaryButton
                class="m-3"
                value="Zurück"
                @click="submitted = !submitted"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke-width="1.5"
                  stroke="currentColor"
                  class="mr-2 h-6 w-6"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75"
                  />
                </svg>
                Zurück
              </PrimaryButton>
              <Link :href="route('auswertung.index')">
                <PrimaryButton class="m-3">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="mr-2 h-6 w-6"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"
                    />
                  </svg>
                  Zur Auswertung
                </PrimaryButton>
              </Link>
            </div>
          </template>
        </Card>
      </div>

      <!-- Main Content -->
      <div v-else class="container mx-auto">
        <!-- DescriptionCard -->
        <section id="DescriptionCard" class="mb-3">
          <Card>
            <template v-slot:header>
              <div
                class="flex justify-between text-primary dark:text-primary_dark"
                :class="{ active: isActive }"
                role="button"
                @click="setActive"
              >
                <h3>Beschreibung:</h3>
                <div
                  class="transition-all duration-500 ease-in-out"
                  :class="{ 'rotate-180': isActive }"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="3.5"
                    stroke="currentColor"
                    class="h-9 w-9"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                    />
                  </svg>
                </div>
              </div>
            </template>

            <template v-slot:body>
              <Transition name="cardbody">
                <div v-show="isActive">
                  <div v-if="settings.infotext">
                    <p class="whitespace-pre-line">{{ settings.infotext }}</p>
                  </div>
                  <div v-else>
                    <p>
                      Die Challenge besteht darin, in den nächsten Wochen
                      <span class="uppercase"
                        >so viele Schritte wie möglich</span
                      >
                      zu machen. Nutze eine App oder eine Fitness-Uhr, um die
                      Schritte, die du jeden Tag machst, mitzählen zu lassen.
                      <span class="uppercase">Jede Woche</span> kannst dem die
                      Gesamtanzahl der erreichten Schritte
                      <span class="uppercase">einmal hier eintragen</span> und
                      für deine Klasse Schritte sammeln. Lade dazu am besten
                      noch einen Screenshot mit deiner Schrittanzahl hoch.
                      <br />Wir suchen die beste Klasse und den besten
                      Läufer!<br />
                    </p>
                  </div>
                  <p class="mt-3">
                    <strong
                      >Also nimm die Beine in die Hand und los gehts!</strong
                    >
                  </p>
                  <div class="mx-auto flex flex-shrink justify-center">
                    <iframe
                      class="aspect-video h-auto max-w-full"
                      width="560"
                      height="315"
                      :src="settings.videolink"
                      title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen
                    ></iframe>
                  </div>
                </div>
              </Transition>
            </template>
          </Card>
        </section>

        <!-- InputCard -->
        <section id="InputCard" class="mb-3">
          <Card>
            <template v-slot:header>
              <h3>Daten eingeben:</h3>
            </template>

            <template v-slot:body>
              <div class="text-primary dark:text-primary_dark">
                <p class="text-lg">
                  Achte darauf, deinen Namen immer gleich zu schreiben, sonst
                  können deine Schritte nicht richtig zusammengerechnet werden!
                </p>
              </div>

              <!-- Form -->
              <form
                class="pt-6"
                name="insertData"
                id="insertData"
                @submit.prevent="
                  form.post(route('eintragen.store'), {
                    onSuccess: () => {
                      showToastSuccess();
                      form.reset();
                      submitted = true;
                    },
                    onError: () => {
                      showToastError(form.errors.message);
                    },
                  })
                "
              >
                <div
                  class="mb-1 grid grid-cols-1 justify-items-stretch gap-3 md:grid-cols-2"
                >
                  <div class="mb-6">
                    <label for="f_vorname" class="form-label">Vorname:</label>
                    <input
                      type="text"
                      class="form-input"
                      name="vorname"
                      id="f_vorname"
                      v-model="form.vorname"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                      autofocus
                      autocomplete="vorname"
                    />
                    <InputError :message="form.errors.vorname" class="mt-2" />
                  </div>

                  <div class="mb-6">
                    <label for="f_name" class="form-label">Nachname:</label>
                    <input
                      type="text"
                      class="form-input"
                      name="name"
                      id="f_name"
                      v-model="form.name"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                      autocomplete="name"
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                  </div>

                  <div class="mb-6">
                    <label for="f_klasse" class="form-label cursor-default"
                      >Klasse:</label
                    >
                    <select
                      name="klasse"
                      class="form-select"
                      id="f_klasse"
                      v-model="form.klasse"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                    >
                      <!-- Default -->
                      <option value="" class="form-select-option"></option>
                      <option
                        v-for="klasse in klassen"
                        :key="klasse.klasse"
                        :value="klasse.klasse"
                        class="form-select-option"
                      >
                        {{ klasse.klasse }}
                      </option>
                    </select>
                    <InputError :message="form.errors.klasse" class="mt-2" />
                  </div>

                  <div class="mb-6">
                    <label for="f_zeitraum" class="form-label cursor-default"
                      >Zeitraum:</label
                    >
                    <select
                      name="zeitraum"
                      class="form-select"
                      id="f_zeitraum"
                      v-model="zeitraum"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                    >
                      <!-- Default -->
                      <option value="" class="form-select-option"></option>
                      <option
                        v-for="zeitraum in zeiträume"
                        :key="zeitraum"
                        :value="zeitraum"
                        class="form-select-option"
                      >
                        {{ moment(zeitraum.von).format("DD.MM.YYYY") }} -
                        {{ moment(zeitraum.bis).format("DD.MM.YYYY") }}
                      </option>
                    </select>
                    <InputError :message="form.errors.von" class="mt-2" />
                  </div>

                  <div class="mb-6">
                    <label for="f_schritte" class="form-label">Schritte:</label>
                    <input
                      type="text"
                      class="form-input"
                      name="schritte"
                      id="f_schritte"
                      v-model="form.schritte"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                    />
                    <InputError :message="form.errors.schritte" class="mt-2" />
                  </div>

                  <!-- TODO: Screenshot -->
                  <div class="mb-6 flex overflow-hidden">
                    <div class="mt-4">
                      <label
                        for="f_screenshot"
                        class="mr-3 cursor-pointer text-[14px] uppercase"
                        >Screenshot:</label
                      >
                    </div>
                    <input
                      type="file"
                      class="form-input cursor-pointer"
                      name="screenshot_big"
                      id="f_screenshot"
                      @change="fileChanged"
                    />
                    <!-- multiple="multiple" -->
                    <InputError
                      :message="form.errors.screenshot"
                      class="mt-2"
                    />
                    <progress
                      v-if="form.progress"
                      :value="form.progress.percentage"
                      max="100"
                    >
                      {{ form.progress.percentage }}%
                    </progress>

                    <!-- <input type="hidden" name="screenshot" id="f_screenshot_hidden" value="" /> -->
                  </div>
                </div>

                <div class="mt-3 text-center">
                  <p>
                    Achtung: Du kannst für jeden Zeitraum nur einmal deine Daten
                    eintragen!
                  </p>
                  <PrimaryButton
                    class="m-3"
                    :class="{ 'btn-disabled': !settings.eintragen_moeglich }"
                    :disabled="form.processing"
                    value="Eintragen"
                    >Eintragen
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke-width="1.5"
                      stroke="currentColor"
                      class="ml-2 h-6 w-6"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"
                      />
                    </svg>
                  </PrimaryButton>
                  <p v-if="!settings.eintragen_moeglich">
                    Eintragen zurzeit nicht möglich
                  </p>
                </div>
              </form>
            </template>
          </Card>
        </section>
      </div>
    </div>
  </ViewLayout>
</template>

<style scoped>
.chevron-enter-from,
.chevron-leave-to {
  -webkit-transform: rotate(180deg);
  -moz-transform: rotate(180deg);
  transform: rotate(180deg);
}
.cardbody-enter-from,
.cardbody-leave-to {
  max-height: 0;
  overflow: hidden;
}
.cardbody-enter-active,
.cardbody-leave-active {
  transition: all 0.5s ease-in-out;
}
.cardbody-enter-to,
.cardbody-leave-from {
  max-height: 100em;
  overflow: hidden;
}
</style>
