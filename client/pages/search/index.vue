<template>
  <AisInstantSearchSsr>
    <div>
      <div class="bg-white mb-16">
        <div class="container py-10 pb-16">
          <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl text-gray-700 font-medium leading-tight mb-4">
              Search
            </h1>
            <client-only>
              <AisPoweredBy />
            </client-only>
          </div>

          <AisSearchBox
            placeholder="Search snippets"
            :class-names="{
              'ais-SearchBox': 'w-full',
              'ais-SearchBox-input':
                'w-full border-2 border-gray-400 rounded-lg block p-4 text-lg focus:outline-none focus:border-blue-500',
              'ais-SearchBox-submit': 'hidden',
              'ais-SearchBox-submitIcon': 'hidden',
              'ais-SearchBox-reset': 'hidden',
            }"
          />
        </div>
      </div>

      <div class="container pb-16">
        <AisStateResults>
          <div slot-scope="{ query }">
            <template v-if="query.length">
              <AisStats>
                <h1
                  class="text-xl text-gray-600 font-medium mb-6"
                  slot-scope="{ nbHits }"
                >
                  Snippets ({{ nbHits }})
                </h1>
              </AisStats>
              <AisHits>
                <div slot="item" slot-scope="{ item }">
                  <SearchSnippetCard :snippet="item.data" />
                </div>
              </AisHits>
            </template>
          </div>
        </AisStateResults>
      </div>
    </div>
  </AisInstantSearchSsr>
</template>

<script>
import SearchSnippetCard from "./components/SearchSnippetCard";
import {
  AisInstantSearchSsr,
  AisStateResults,
  AisHits,
  AisSearchBox,
  AisStats,
  AisPagination,
  AisPoweredBy,
  createServerRootMixin,
} from "vue-instantsearch";
import algoliasearch from "algoliasearch/lite";

const searchClient = algoliasearch(
  process.env.ALGOLIA_APP_ID,
  process.env.ALGOLIA_SECRET
);

function nuxtRouter(vueRouter) {
  return {
    read() {
      return vueRouter.currentRoute.query;
    },
    write(routeState) {
      vueRouter.push({
        query: routeState,
      });
    },
    createURL(routeState) {
      return vueRouter.resolve({
        query: routeState,
      }).href;
    },
    onUpdate(cb) {
      if (typeof window === "undefined") return;

      this._onPopState = (event) => {
        const routeState = event.state;
        // On initial load, the state is read from the URL without
        // update. Therefore, the state object isn't present. In this
        // case, we fallback and read the URL.
        if (!routeState) {
          cb(this.read());
        } else {
          cb(routeState);
        }
      };
      window.addEventListener("popstate", this._onPopState);
    },
    dispose() {
      if (typeof window === "undefined") return;

      window.removeEventListener("popstate", this._onPopState);
    },
  };
}

export default {
  components: {
    SearchSnippetCard,
    AisInstantSearchSsr,
    AisStateResults,
    AisHits,
    AisSearchBox,
    AisStats,
    AisPagination,
    AisPoweredBy,
  },
  head() {
    return {
      title: "Search",
    };
  },
  data() {
    // Create it in `data` to access the Vue Router
    const mixin = createServerRootMixin({
      searchClient,
      indexName: "snippets",
      routing: {
        router: nuxtRouter(this.$nuxt.$router),
      },
    });
    return {
      ...mixin.data(),
      key: null,
    };
  },
  provide() {
    return {
      // Provide the InstantSearch instance for SSR
      $_ais_ssrInstantSearchInstance: this.instantsearch,
    };
  },
  serverPrefetch() {
    return this.instantsearch.findResultsState(this).then((algoliaState) => {
      this.$ssrContext.nuxt.algoliaState = algoliaState;
    });
  },
  beforeMount() {
    const results =
      this.$nuxt.context.nuxtState.algoliaState || window.__NUXT__.algoliaState;

    this.instantsearch.hydrate(results);
  },
  async asyncData({ app }) {
    let keys = await app.$axios.$get("keys/algolia");

    return {
      key: keys.data,
    };
  },
};
</script>
