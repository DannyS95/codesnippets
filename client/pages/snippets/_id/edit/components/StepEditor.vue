<template>
  <div>
    <textarea ref="textarea"></textarea>
    <div class="bg-white p-8 rounded-lg text-gray-600">

    </div>
  </div>
</template>

<script>
import StepMarkdown from "@/components/snippets/StepMarkdown";

export default {
  components: {
    StepMarkdown
  },
  props: {
    step: {
      required: true,
      type: Object
    }
  },
  data () {
    return {
      codemirror: null
    }
  },
  computed: {
    document () {
      return this.codemirror.getDoc()
    }
  },
  watch: {
    'step.uuid' () {
      this.document.setValue(this.step.body)
    }
  },
  mounted () {
    let CodeMirror = require("codemirror")

    this.codemirror = CodeMirror.fromTextArea(this.$refs.textarea, {
      indentUnit: 2,
      indentWithTabs: false,
      smartIndent: true,
      lineWrapping: true,
      lineNumbers: false,
      scrollbarStyle: null,
      extraKeys: {
        Tab: (codemirror) => codemirror.execCommand('indentMore'),
        'Shift-Tab': (codemirror) => codemirror.execCommand('indentLess')
      }
    })

    this.document.setValue(this.step.body)
    this.document.on("change", (document) => {
      this.$emit('input', document.getValue())
    })
  }
};
</script>

<style>
.CodeMirror {
  @apply font-sans text-base w-full mb-6 max-w-full border-dashed border-2 border-gray-400 rounded-lg p-8;
}
</style>
