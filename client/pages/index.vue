<template>
  <div>
    <div class="bg-white mb-16">
      <div class="container flex py-16 lg:py-32">
        <div class="w-full lg:w-1/2">
          <h1 class="text-5xl font-medium text-gray-700 leading-tight mb-6">
            Browse and create mini step-by-step tutorials.
          </h1>

          <p class="text-xl text-gray-600 mb-12">
            Snippets are small collections of steps for things you don't need to
            remember.
          </p>
          <nuxt-link
            v-if="snippets.length > 0 "
            :to="{
              name: 'snippets-id',
              params: {
                id: snippets[0].uuid
              }
            }"
            class="inline-block text-lg py-3 px-5 bg-blue-500 text-white rounded-lg"
            >Check out an example &rarr;</nuxt-link
          >
        </div>
      </div>
    </div>

    <div class="container">
      <h1 class="text-xl text-gray-600 font-medium mb-6">
        {{ snippets.length > 0 ? 'Latest snippets': 'No snippets' }}
      </h1>

      <SnippetCard
        v-for="snippet in snippets"
        :key="snippet.uuid"
        :snippet="snippet"
      >
        <nuxt-link
          :to="{
            name: 'author-id',
            params: {
              id: snippet.author.data.username
            }
          }"
          >{{ snippet.author.data.name }}</nuxt-link
        >
      </SnippetCard>
    </div>
  </div>
</template>

<script>
import SnippetCard from "@/components/snippets/SnippetCard";

export default {
  components: {
    SnippetCard
  },
  data() {
    return {
      snippets: []
    };
  },
  head() {
    return {
      title: "Snippets by Codecourse"
    };
  },
  async asyncData({ app }) {
    let snippets = await app.$axios.$get("snippets?limit=10");

    return {
      snippets: snippets.data
    };
  }
};
</script>
