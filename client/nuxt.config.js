let env = require("dotenv").config();

console.log(env)
export default {
  // Global page headers (https://go.nuxtjs.dev/config-head)
  env: env.parsed,
  head: {
    titleTemplate: "%s - Snippets",
    meta: [
      { charset: "utf-8" },
      { name: "viewport", content: "width=device-width, initial-scale=1" },
      { hid: "description", name: "description", content: "" }
    ],
    link: [
      { rel: "icon", type: "image/x-icon", href: "/favicon.ico" },
      {
        rel: "stylesheet",
        href:
          "https://fonts.googleapis.com/css2?family=Rubik:wght@400;500&display=swap"
      }
    ]
  },

  // Global CSS (https://go.nuxtjs.dev/config-css)
  css: ["~/assets/styles/app.scss"],

  // Plugins to run before rendering page (https://go.nuxtjs.dev/config-plugins)
  plugins: [],

  // Auto import components (https://go.nuxtjs.dev/config-components)
  components: true,

  // Modules for dev and build (recommended) (https://go.nuxtjs.dev/config-modules)
  buildModules: [
    // https://go.nuxtjs.dev/tailwindcss
  ],

  // Modules (https://go.nuxtjs.dev/config-modules)
  modules: ["@nuxtjs/axios", "@nuxtjs/auth"],

  axios: {
    baseURL: process.env.API_URL
  },

  auth: {
    redirect: {
      login: "/auth/login"
    },
    strategies: {
      local: {
        endpoints: {
          login: {
            url: "auth/login",
            method: "post",
            propertyName: "data.token"
          },
          user: {
            url: "auth/me",
            method: "get",
            propertyName: "data"
          },
          logout: {
            url: "auth/logout",
            method: "post"
          }
        }
      }
    }
  },

  // Build Configuration (https://go.nuxtjs.dev/config-build)
  build: {
    transpile: ["vue-instantsearch", "instantsearch.js/es"],
    postcss: {
      plugins: {
        tailwindcss: "./tailwind.config.js"
      }
    }
  }
};
