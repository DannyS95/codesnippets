<template>
  <div>
    <div class="bg-white mb-16">
      <div class="container py-10 pb-16">
        <div class="w-5/6">
          <input
            v-model="snippet.title"
            type="text"
            class="w-full block rounded border-2 border-dashed border-gray-400 text-4xl text-gray-700 font-medium leading-tight p-2 mb-4"
            value=""
            placeholder="Untitled snippet"
          />
          <div class="text-gray-600">
            Created by
            <nuxt-link :to="{
              name: 'author-id',
              params: {
                id: snippet.author.data.username,
              },
            }">{{
              snippet.author.data.name
            }}</nuxt-link>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="flex items-center mb-6">
        <div class="text-xl text-gray-600 font-medium mr-3">
          {{ currentStepIndex + 1 }}/{{ steps.length }}.
        </div>
        <input
          v-model="currentStep.title"
          type="text"
          class="text-xl text-gray-600 font-medium px-2 py-1 bg-transparent border-2 rounded border-dashed border-gray-400 w-full"
          value=""
          placeholder="Untitled step"
        />
      </div>
      <div class="flex flex-wrap lg:flex-no-wrap">
        <div class="w-full lg:w-2/3 lg:mr-16 flex flex-wrap lg:flex-no-wrap justify-between items-start mb-8">
          <div class="flex flex-row lg:flex-col mr-2 order-first">
            <StepNavigationButton
              :step="previousStep"
              title="Previous Step"
            >
              <svg
                class="fill-current text-white h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path d="M5.41 11H21a1 1 0 0 1 0 2H5.41l5.3 5.3a1 1 0 0 1-1.42 1.4l-7-7a1 1 0 0 1 0-1.4l7-7a1 1 0 0 1 1.42 1.4L5.4 11z" />
              </svg>
            </StepNavigationButton>
            <AddStepButton
              @added="handleStepAdded"
              position="before"
              :snippet="snippet"
              :currentStep="currentStep"
            />
          </div>

          <div class="w-full lg:mr-2">
            <StepEditor
              :step="currentStep"
              v-model="currentStep.body"
            />
          </div>

          <div class="flex flex-row-reverse lg:flex-col order-first lg:order-last">
            <StepNavigationButton
              :step="nextStep"
              title="Next Step"
            >
              <svg
                class="fill-current text-white h-6 w-6"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                width="24"
                height="24"
              >
                <path d="M18.59 13H3a1 1 0 0 1 0-2h15.59l-5.3-5.3a1 1 0 1 1 1.42-1.4l7 7a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.42-1.4l5.3-5.3z" />
              </svg>
            </StepNavigationButton>
            <AddStepButton
              position="after"
              :snippet="snippet"
              :currentStep="currentStep"
              @added="handleStepAdded"
            />
            <DeleteStepButton
              v-if="steps.length > 1"
              :snippet="snippet"
              :currentStep="currentStep"
              @deleted="handleStepDeleted"
            />
          </div>
        </div>
        <div class="w-full lg:w-1/3">
          <div class="mb-8">
            <h3 class="text-xl text-gray-600 font-medium mb-6">Steps</h3>
            <StepList
              :steps="orderedStepsAsc"
              :currentStep="currentStep"
            />
          </div>

          <div class="border-t-2 border-gray-300 pt-6 pb-2">
            <h3 class="text-xl text-gray-600 font-medium mb-2">Publishing</h3>
            <div class="text-gray-500 text-sm mb-6">
              <template v-if="lastSaved">
                Last saved at {{ lastSavedFormatted }}
              </template>
              <template v-else>
                No changes saved in this session yet.
              </template>
            </div>

            <div class="flex items-baseline mb-6">
              <input
                v-model="snippet.is_public"
                type="checkbox"
                name="public"
                id="public"
                class="mr-2"
              />
              <div>
                <label
                  for="public"
                  class="text-gray-600 font-medium"
                >
                  Make this snippet public
                </label>
                <p class="text-gray-500 text-sm">
                  Don't worry you can change this later
                </p>
              </div>
            </div>
          </div>

          <div class="text-gray-500 text-sm">
            Use
            <div class="highlight">ctrl</div>
            +
            <div class="highlight">shift</div>
            +
            <div class="highlight">left or right</div>
            on your keyboard to navigation between steps
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Mixins
import browseSnippet from "@/mixins/snippets/browseSnippet";

// Plugins
import { debounce as _debounce } from "lodash";
import moment from "moment";

// Components
import StepEditor from "./components/StepEditor";
import StepList from "../components/StepList";
import StepNavigationButton from "../components/StepNavigationButton";
import AddStepButton from "./components/AddStepButton";
import DeleteStepButton from "./components/DeleteStepButton";

export default {
  middleware: ["auth"],
  mixins: [browseSnippet],
  components: {
    StepEditor,
    StepList,
    StepNavigationButton,
    AddStepButton,
    DeleteStepButton,
  },
  head () {
    return {
      title: `Editing ${this.snippet.title || "Untitled snippet"}`,
    };
  },
  data () {
    return {
      snippet: null,
      steps: [],
      lastSaved: null,
    };
  },
  watch: {
    "snippet.title": {
      handler: _debounce(async function (title) {
        await this.$axios.$patch(`snippets/${this.snippet.uuid}`, {
          title,
        });

        this.touchLastSaved();
      }, 500),
    },
    "snippet.is_public": {
      handler: _debounce(async function (isPublic) {
        await this.$axios.$patch(`snippets/${this.snippet.uuid}`, {
          is_public: isPublic,
        });

        this.touchLastSaved();
      }, 500),
    },
    currentStep: {
      deep: true,
      handler: _debounce(async function (step) {
        await this.$axios.$patch(
          `snippets/${this.snippet.uuid}/steps/${step.uuid}`,
          {
            title: step.title,
            body: step.body,
          }
        );

        this.touchLastSaved();
      }, 500),
    },
  },
  computed: {
    lastSavedFormatted () {
      return moment(this.lastSaved).format("hh:mm:ss");
    },
  },
  methods: {
    touchLastSaved () {
      this.lastSaved = moment.now();
    },
    handleStepAdded (step) {
      this.steps.push(step);
      this.goToStep(step);
    },
    handleStepDeleted (step) {
      const previousStep = this.previousStep;

      this.steps = this.steps.filter((s) => {
        return s.uuid !== step.uuid;
      });

      this.goToStep(previousStep || this.firstStep);
    },
  },
  async asyncData ({ app, params }) {
    let snippet = await app.$axios.$get(`snippets/${params.id}`);

    return {
      snippet: snippet.data,
      steps: snippet.data.steps.data,
    };
  },
};
</script>

<style scoped>
.highlight {
  @apply inline-block px-2 leading-relaxed text-gray-600 rounded bg-gray-400 text-sm;
}
</style>
