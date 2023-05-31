<template>
  <div class="container mt-16">
    <div class="flex flex-col items-center">
      <h1 class="text-3xl text-gray-700 font-medium mb-10">Get snippeting.</h1>

      <form
        @submit.prevent="submit"
        action="#"
        class="bg-white p-8 rounded w-full md:w-2/3 lg:w-7/12 mb-10"
      >
        <div class="flex flex-wrap -mx-4">
          <div class="w-full px-4 mb-6">
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
          <div class="w-full md:w-1/2 px-4 mb-6">
            <label
              for="name"
              class="block text-gray-600 font-medium mb-2"
              :class="{ 'text-red-500': validation.name }"
            >Name</label>
            <input
              v-model="form.name"
              type="text"
              name="name"
              id="name"
              class="border-2 border-gray-400 rounded w-full p-3"
              :class="{ 'border-red-500': validation.name }"
            />

            <div
              v-if="validation.name"
              class="text-red-500 font-medium mb-4 text-sm mt-1"
            >
              {{ validation.name[0] }}
            </div>
          </div>
          <div class="w-full md:w-1/2 px-4 mb-6">
            <label
              for="name"
              class="block text-gray-600 font-medium mb-2"
              :class="{ 'text-red-500': validation.username }"
            >Username</label>
            <input
              v-model="form.username"
              type="text"
              name="username"
              id="username"
              class="border-2 border-gray-400 rounded w-full p-3"
              :class="{ 'border-red-500': validation.username }"
            />

            <div
              v-if="validation.username"
              class="text-red-500 font-medium mb-4 text-sm mt-1"
            >
              {{ validation.username[0] }}
            </div>
          </div>
          <div class="w-full md:w-1/2 px-4 mb-6">
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
          <div class="w-full md:w-1/2 px-4 mb-6">
            <label
              for="password_confirmation"
              class="block text-gray-600 font-medium mb-2"
              :class="{ 'text-red-500': validation.password_confirmation }"
            >Password Confirmation</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              name="password_confirmation"
              id="password_confirmation"
              class="border-2 border-gray-400 rounded w-full p-3"
              :class="{ 'border-red-500': validation.password_confirmation }"
            />

            <div
              v-if="validation.password_confirmation"
              class="text-red-500 font-medium mb-4 text-sm mt-1"
            >
              {{ validation.password_confirmation[0] }}
            </div>
          </div>
        </div>

        <div>
          <button
            type="submit"
            class="bg-blue-500 text-white p-4 rounded text-center font-medium block w-full focus:outline-none"
          >
            Sign up
          </button>
        </div>
      </form>

      <div class="text-center text-gray-600">
        Already have an account?

        <nuxt-link :to="{ name: 'auth-login' }">Login here</nuxt-link>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  head () {
    return {
      title: "Sign Up",
    };
  },
  data () {
    return {
      form: {
        email: "",
        password: "",
        password_confirmation: "",
        name: "",
        username: ""
      },
      validation: {},
    };
  },
  methods: {
    async submit () {
      try {
        await this.$axios.$post('auth/signup', this.form)
        await this.$auth.loginWith("local", {
          data: {
            email: this.form.email,
            password: this.form.password
          }
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
