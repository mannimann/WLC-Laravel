<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import { useForm, Head, Link } from "@inertiajs/inertia-vue3";
import { computed, ref, Transition } from "vue";
import Card from "@/Components/Card.vue";

const submit_disabled = ref(true); // TODO
const submitted = ref(false);

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

const klassen_liste = ["5a", "5b", "5c"];
const zeitraum_liste = [
  ["2022-11-28", "2022-12-04"],
  ["2022-11-29", "2022-12-05"],
  ["2022-11-30", "2022-12-06"],
];

const zeitraum = computed({
  get() {
    return [form.von, form.bis];
  },
  set(newValue) {
    // TODO: check if empty

    form.von = newValue[0];
    form.bis = newValue[1];
  },
});
</script>

<template>
  <Head title="Eintragen" />

  <ViewLayout>
    <p>{{ form.von }}</p>
    <p>{{ form.bis }}</p>
    <p>{{ zeitraum }}</p>

    <div class="container mx-auto p-4 sm:p-6 lg:p-8">
      <!-- Submitted -->
      <div v-if="submitted">
        <Card>
          <template v-slot:header>
            <h3>Daten erfolgreich eingetragen</h3>
          </template>
          <template v-slot:body>
            <div class="mt-3 text-center">
              <PrimaryButton
                class="m-3 bg-green-700 hover:bg-green-600 active:bg-green-800"
                value="Zurück"
                @click="submitted = !submitted"
              >
                <span class="text-lg">Zurück</span>
              </PrimaryButton>
              <Link :href="route('dashboard')">
                <PrimaryButton
                  class="m-3 bg-green-700 hover:bg-green-600 active:bg-green-800"
                  value="Zur Auswertung"
                >
                  <span class="text-lg">Zur Auswertung</span>
                </PrimaryButton>
              </Link>
            </div>
          </template>
        </Card>
      </div>

      <!-- Normal Site -->
      <div v-else>
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
                  <p>
                    Die Challenge besteht darin, in den nächsten Wochen
                    <span class="uppercase">so viele Schritte wie möglich</span>
                    zu machen. Nutze eine App oder eine Fitness-Uhr, um die
                    Schritte, die du jeden Tag machst, mitzählen zu lassen.
                    <span class="uppercase">Jede Woche</span> kannst dem die
                    Gesamtanzahl der erreichten Schritte
                    <span class="uppercase">einmal hier eintragen</span> und für
                    deine Klasse Schritte sammeln. Lade dazu am besten noch
                    einen Screenshot mit deiner Schrittanzahl hoch. <br />Wir
                    suchen die beste Klasse und den besten Läufer! <br /><br />
                    <strong
                      >Also nimm die Beine in die Hand und los gehts!</strong
                    >
                  </p>
                  <div class="mx-auto flex flex-shrink justify-center">
                    <iframe
                      class="aspect-video h-auto max-w-full"
                      width="560"
                      height="315"
                      src="https://www.youtube.com/embed/YJ3ShqLPiPo"
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
                  form.post(route('steps.store'), {
                    onSuccess: () => {
                      form.reset();
                      submitted = true;
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
                      pattern="[\p{L} -]+"
                      name="vorname"
                      id="f_vorname"
                      v-model="form.vorname"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                      required
                      autofocus
                    />
                    <InputError :message="form.errors.vorname" class="mt-2" />
                  </div>

                  <div class="mb-6">
                    <label for="f_name" class="form-label">Nachname:</label>
                    <input
                      type="text"
                      class="form-input"
                      pattern="[\p{L} -]+"
                      name="name"
                      id="f_name"
                      v-model="form.name"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                      required
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
                      required
                    >
                      <!-- Default -->
                      <option value="" class="form-select-option"></option>
                      <option
                        v-for="klasse in klassen_liste"
                        :key="klasse"
                        :value="klasse"
                        class="form-select-option"
                      >
                        {{ klasse }}
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
                      required
                    >
                      <!-- Default -->
                      <option value="" class="form-select-option"></option>
                      <option
                        v-for="item in zeitraum_liste"
                        :key="item"
                        :value="item"
                        class="form-select-option"
                      >
                        {{ item[0] + " - " + item[1] }}
                      </option>
                    </select>
                    <InputError :message="form.errors.zeitraum" class="mt-2" />
                  </div>

                  <div class="mb-6">
                    <label for="f_schritte" class="form-label">Schritte:</label>
                    <input
                      type="text"
                      class="form-input"
                      pattern="[0-9]+"
                      name="schritte"
                      id="f_schritte"
                      v-model="form.schritte"
                      @focus="addNotEmpty"
                      @blur="removeNotEmpty"
                      required
                    />
                    <InputError :message="form.errors.schritte" class="mt-2" />
                  </div>

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
                    class="m-3 bg-green-700 hover:bg-green-600 active:bg-green-800"
                    :class="{ disabled: submit_disabled }"
                    :disabled="form.processing"
                    value="Eintragen"
                  >
                    <span class="text-lg">Eintragen</span>
                  </PrimaryButton>

                  <!-- bei Bedarf hinzufügen: disabled -->
                </div>
              </form>
              <!-- <p>{{ screenshot }}</p> -->
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

<script>
export default {
  methods: {
    addNotEmpty(e) {
      e.target.parentElement.classList.add("form-not-empty");
    },
    removeNotEmpty(e) {
      e.target.value === ""
        ? e.target.parentElement.classList.remove("form-not-empty")
        : null;
    },
    // Bilder verkleinern (clientseitig)
    fileChanged(e) {
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
              // document.getElementById('f_screenshot_hidden').value += dataURL + '|';
              this.screenshot += dataURL + "|";
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
    },
  },
};
</script>
