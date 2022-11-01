<script setup>
import ViewLayout from "@/Layouts/ViewLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { ref, Transition } from "vue";

const isActive = ref(false);
function setActive() {
  isActive.value = !isActive.value;
}
</script>

<template>
  <Head title="Steps" />

  <ViewLayout>
    <div class="p-4 mx-auto sm:p-6 lg:p-8">
      <!-- DescriptionCard -->
      <section id="DescriptionCard" class="mb-3">
        <div
          class="container mx-auto overflow-hidden rounded-lg shadow-md bg-secondarybg"
        >
          <div
            class="flex justify-between p-3 text-3xl font-bold text-primary"
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
                class="w-9 h-9"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                />
              </svg>
            </div>
          </div>

          <Transition name="cardbody">
            <div v-show="isActive" class="p-3">
              <p>
                Die Challenge besteht darin, in den nächsten Wochen
                <span class="uppercase">so viele Schritte wie möglich</span> zu
                machen. Nutze eine App oder eine Fitness-Uhr, um die Schritte,
                die du jeden Tag machst, mitzählen zu lassen.
                <span class="uppercase">Jede Woche</span> kannst dem die
                Gesamtanzahl der erreichten Schritte
                <span class="uppercase">einmal hier eintragen</span> und für
                deine Klasse Schritte sammeln. Lade dazu am besten noch einen
                Screenshot mit deiner Schrittanzahl hoch. <br />Wir suchen die
                beste Klasse und den besten Läufer! <br /><br />
                <strong>Also nimm die Beine in die Hand und los gehts!</strong>
              </p>
              <div class="flex justify-center flex-shrink mx-auto">
                <iframe
                  class="h-auto max-w-full aspect-video"
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
        </div>
      </section>

      <!-- InputCard -->
      <section id="InputCard" class="mb-3">
        <div
          class="container mx-auto overflow-hidden rounded-lg shadow-md bg-secondarybg"
        >
          <div class="p-3 text-3xl font-bold">
            <h3>Daten eingeben:</h3>
          </div>

          <div class="p-3">
            <div class="text-primary">
              <p class="text-lg">
                Achte darauf, deinen Namen immer gleich zu schreiben, sonst
                können deine Schritte nicht richtig zusammengerechnet werden!
              </p>
            </div>
            <form
              class="pt-6"
              name="insertData"
              id="insertData"
              @submit.prevent="handleSubmit"
            >
              <div
                class="grid grid-cols-1 gap-3 mb-1 md:grid-cols-2 justify-items-stretch"
              >
                <div class="mb-6">
                  <label for="f_vorname" class="form-label">Vorname:</label>
                  <input
                    type="text"
                    class="form-input"
                    pattern="[\p{L} -]+"
                    name="vorname"
                    id="f_vorname"
                    v-model="stepdata.vorname"
                    @focus="addNotEmpty"
                    @blur="removeNotEmpty"
                    required
                  />
                </div>

                <!-- TODO -->
                <div class="mb-6">
                  <label for="f_name" class="form-label">Nachname:</label>
                  <input
                    type="text"
                    class="form-input"
                    pattern="[\p{L} -]+"
                    name="name"
                    id="f_name"
                    v-model="stepdata.name"
                    @focus="addNotEmpty"
                    @blur="removeNotEmpty"
                    required
                  />
                </div>

                <div class="mb-6">
                  <label for="f_klasse" class="form-label">Klasse:</label>
                  <select
                    name="klasse"
                    class="form-input"
                    id="f_klasse"
                    v-model="stepdata.klasse"
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
                </div>

                <div class="mb-6">
                  <label for="f_zeitraum" class="form-label">Zeitraum:</label>
                  <select
                    name="zeitraum"
                    class="form-input"
                    id="f_zeitraum"
                    v-model="stepdata.zeitraum"
                    @focus="addNotEmpty"
                    @blur="removeNotEmpty"
                    required
                  >
                    <!-- Default -->
                    <option value="" class="form-select-option"></option>
                    <option
                      v-for="zeitraum in zeitraum_liste"
                      :key="zeitraum"
                      :value="zeitraum"
                      class="form-select-option"
                    >
                      {{ zeitraum }}
                    </option>

                    <!-- TODO -->

                    <!-- <?php
                      for($i = 0, $len = count($zeitraum_liste); $i < $len; ++$i) {
                          $zeitraum_anzeige = substr($zeitraum_liste[$i][0], 8, 2) . "." . substr($zeitraum_liste[$i][0], 5, 2) . ". - " . 
                              substr($zeitraum_liste[$i][1], 8, 2) . "." . substr($zeitraum_liste[$i][1], 5, 2) . ".";
                          echo "<option value='". $i ."' class='form-select-option'>". $zeitraum_anzeige ."</option>";
                      }
                    ?> -->
                  </select>
                </div>

                <div class="mb-6">
                  <label for="f_schritte" class="form-label">Schritte:</label>
                  <input
                    type="text"
                    class="form-input"
                    pattern="[0-9]+"
                    name="schritte"
                    id="f_schritte"
                    v-model="stepdata.schritte"
                    @focus="addNotEmpty"
                    @blur="removeNotEmpty"
                    required
                  />
                </div>

                <div class="mb-6">
                  <div class="inline-block">
                    <label
                      for="f_screenshot"
                      class=""
                      style="margin-right: 20px"
                      >Screenshot:</label
                    >
                  </div>
                  <div class="mb-6">
                    <label for="f_screenshot" class=""></label>
                    <input
                      type="file"
                      class=""
                      name="screenshot_big"
                      id="f_screenshot"
                      @change="fileChanged"
                    />
                    <!-- multiple="multiple" -->

                    <!-- <input type="hidden" name="screenshot" id="f_screenshot_hidden" value="" /> -->
                  </div>
                </div>
              </div>

              <div class="mt-3 text-center">
                <p>
                  Achtung: Du kannst für jeden Zeitraum nur einmal deine Daten
                  eintragen!
                </p>
                <button
                  type="submit"
                  class="btn btn-lg btn-success"
                  :class="{ disabled: submit_disabled }"
                  value="Eintragen"
                >
                  Eintragen
                </button>
                <!-- bei Bedarf hinzufügen: disabled -->
              </div>
            </form>
            <!-- <p>{{ screenshot }}</p> -->
          </div>
        </div>
      </section>

      <div id="InputCard" class="mb-3"></div>
    </div>
  </ViewLayout>
</template>

<style>
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
// TODO
export default {
  data() {
    return {
      stepdata: {
        vorname: "",
        name: "",
        klasse: "",
        // zeitraum: '',
        schritte: "",
        // screenshot: '',
      },
      submit_disabled: false,
    };
  },
  methods: {
    handleSubmit() {
      console.log(this.stepdata);
      //TODO
    },
    addNotEmpty(e) {
      e.target.parentElement.classList.add("not-empty");
    },
    removeNotEmpty(e) {
      e.target.value === ""
        ? e.target.parentElement.classList.remove("not-empty")
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
                var dataURL = canvas.toDataURL("image/jpeg", 1.0);
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
