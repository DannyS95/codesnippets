<template>
  <div class="container mt-16">
    <div class="flex flex-col items-center">
      <h1 class="text-3xl text-gray-700 font-medium mb-10">Hello.</h1>

      <form
        @submit.prevent="submit"
        action="#"
        class="bg-white p-8 rounded w-full md:w-1/2 lg:w-1/3 mb-10"
      >
        <div class="mb-6">
          <label
            for="email"
            class="block text-gray-600 font-medium mb-2"
            :class="{ 'text-red-500': validation.email }"
          >Email Address</label>
          <input
            v-model="form.email"
            type="text"
            name="email"
            id="email"
            class="border-2 border-gray-400 rounded w-full p-3"
            :class="{ 'border-red-500': validation.email }"
          />

          <div
            v-if="validation.email"
            class="text-red-500 font-medium mb-4 text-sm mt-1"
          >
            {{ validation.email[0] }}
          </div>
        </div>
        <div class="mb-6">
          <label
            for="password"
            class="block text-gray-600 font-medium mb-2"
            :class="{ 'text-red-500': validation.password }"
          >Password</label>
          <input
            v-model="form.password"
            type="password"
            name="password"
            id="password"
            class="border-2 border-gray-400 rounded w-full p-3"
            :class="{ 'border-red-500': validation.password }"
          />

          <div
            v-if="validation.password"
            class="text-red-500 font-medium mb-4 text-sm mt-1"
          >
            {{ validation.password[0] }}
          </div>
        </div>
        <div>
          <button
            type="submit"
            class="bg-blue-500 text-white p-4 rounded text-center font-medium block w-full focus:outline-none"
          >
            Sign in
          </button>
        </div>
      </form>

      <div class="text-center text-gray-600">
        No account?

        <nuxt-link :to="{ name: 'auth-signup' }">Create one here</nuxt-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  head () {
    return {
      title: "Login",
    };
  },
  data () {
    return {
      form: {
        email: "",
        password: "",
      },
      validation: {},
    };
  },
  methods: {
    async submit () {
      try {
        await this.$auth.loginWith("local", {
          data: this.form,
        });
      } catch (e) {
        if (e.response.status === 422) {
          this.validation = e.response.data.errors;
        }
      }
    },
  },
};
</script>
