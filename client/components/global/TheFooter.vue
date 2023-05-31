<template>
  <div class="mt-24 mb-12">
    <div class="container">
      <div class="flex flex-wrap lg:flex-no-wrap justify-between">
        <ul class="flex items-center mb-6 lg:mb-0">
          <li class="mr-16">
            <nuxt-link
              class="text-gray-500 text-sm mb-2 inline-block"
              :to="{ name: 'index' }"
              >Home
            </nuxt-link>

            <div class="text-gray-500 text-sm">
              &copy; Codecourse Ltd 2019. All rights reserved.
            </div>
          </li>
        </ul>
        <ul class="flex items-center">
          <li class="mr-8">
            <a
              href="https://codecourse.com"
              class="text-gray-500 text-sm"
              target="_blank"
              rel="noopener"
              >codecourse.com
            </a>
          </li>
          <li class="mr-8">
            <a
              href="https://codecourse.com"
              class="text-gray-500 text-sm"
              target="_blank"
              rel="noopener"
              >Terms
            </a>
          </li>
          <li class="mr-8">
            <a
              href="https://codecourse.com"
              class="text-gray-500 text-sm"
              target="_blank"
              rel="noopener"
              >Privacy Policy
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>
