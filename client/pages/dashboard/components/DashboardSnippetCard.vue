<template>
  <SnippetCard :snippet="snippet">
    <ul class="flex items-end text-gray-600">
      <li class="mr-6">
        <template v-if="snippet.is_public">Public</template>
        <template v-else>Private</template>
      </li>
      <li class="mr-6">
        <nuxt-link :to="{
            name: 'snippets-id-edit',
            params: {
              id: snippet.uuid,
            },
          }">Edit</nuxt-link>
      </li>
      <li class="mr-6">
        <button
          class="text-blue-500"
          @click.prevent="deleteSnippet()"
        >
          Delete
        </button>
      </li>
    </ul>
  </SnippetCard>
</template>
<script>
import SnippetCard from "@/components/snippets/SnippetCard";

export default {
  props: {
    snippet: {
      required: true,
      type: Object,
    },
  },
  methods: {
    async deleteSnippet () {
      if (!window.confirm("Are you sure you want to delete this snippet?")) {
        return;
      }

      await this.$axios.delete(`snippets/${this.snippet.uuid}`);

      this.$emit("deleted", this.snippet);
    },
  },
};
</script>
