<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-sm">
      <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
          <input
            type="email"
            id="email"
            v-model="useUserStore().credentials.email"
            required
            class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
            class="w-full p-3 mt-1 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Enter your password"
          />
        </div>

        <!-- <div class="flex justify-between items-center mb-4">
          <div class="flex items-center">
            <input
              type="checkbox"
              id="remember"
              v-model="rememberMe"
              class="h-4 w-4 text-blue-500"
            />
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
          </div>
          <a href="#" class="text-sm text-blue-500 hover:text-blue-700">Forgot password?</a>
        </div> -->

        <button
          type="submit"
          class="w-full py-3 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Login
        </button>
      </form>

      <p class="text-center text-sm text-gray-500 mt-4">
        Don't have an account?
        <router-link to="/signup" class="text-blue-500 hover:text-blue-700">Sign up</router-link>
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
