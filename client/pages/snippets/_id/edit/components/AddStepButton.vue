<template>
    <button
        @click.prevent="addStep"
        class="block mb-2 p-3 bg-blue-500 rounded-lg"
        :title="`Add step ${position}`"
    >
        <svg
            class="fill-current text-white h-6 w-6"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="24"
            height="24"
            >
            <path
                d="M17 11a1 1 0 0 1 0 2h-4v4a1 1 0 0 1-2 0v-4H7a1 1 0 0 1 0-2h4V7a1 1 0 0 1 2 0v4h4z"
            />
        </svg>
    </button>
</template>

<script>
export default {
  props: {
    position: {
        required: true,
        type: String
    },
    snippet: {
        required: true,
        type: Object
    },
    currentStep: {
        required: true,
        type: Object
    },
  },
  methods: {
    async addStep() {
        const response = await this.$axios.post(`snippets/${this.snippet.uuid}/steps`, {
            [this.position]: this.currentStep.uuid
        })

        this.$emit('added', response.data.data)
    }
  }
};
</script>