<template>
  <div class="flex items-center justify-center min-h-[92vh] bg-gray-100">
    <div class="w-full max-w-sm p-8 bg-white rounded-lg shadow-lg">
      <h2 class="mb-6 text-2xl font-semibold text-center text-gray-700">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
          <input
            type="email"
            id="email"
            v-model="useUserStore().credentials.email"
            required
            class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            placeholder="Enter your email"
          />
        </div>
        <div class="mb-6">
          <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
          <input
            type="password"
            id="password"
            v-model="useUserStore().credentials.password"
            required
            class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            placeholder="Enter your password"
          />
        </div>

        <button type="submit" class="w-full py-3 font-semibold text-white bg-teal-600 rounded-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500">Login</button>
      </form>

      <p class="mt-4 text-sm text-center text-gray-500">
        Don't have an account?
        <router-link to="/signup" class="text-teal-600 hover:text-teal-700">Sign up</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useUserStore } from "../../stores/user";

// Define the reactive state for the form fields

// Handle the form submission for login
const handleLogin = async () => {
  await useUserStore().login();
};
</script>

<style scoped>
/* Optional: Custom styles if needed */
</style>
