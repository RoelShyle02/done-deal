<template>
  <div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-lg">
      <h2 class="text-2xl font-bold text-center mb-6">Sign Up</h2>
      <form @submit.prevent="handleSubmit">
        <div class="mb-4">
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input
            id="name"
            type="text"
            v-model="form.name"
            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            type="email"
            v-model="form.email"
            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            id="password"
            type="password"
            v-model="form.password"
            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <div class="mb-6">
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
            id="password_confirmation"
            type="password"
            v-model="form.password_confirmation"
            class="mt-1 block w-full px-4 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          />
        </div>

        <button
          type="submit"
          class="w-full py-2 px-4 bg-blue-600 text-white font-bold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
          Sign Up
        </button>
      </form>
      <p class="mt-4 text-sm text-center text-gray-600">
        Already have an account?
        <router-link to="/login" class="text-blue-600 hover:underline">Login here</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";
import { useUserStore } from "../../stores/user";

// Form data for signup
const form = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

// Handle form submission
const handleSubmit = async () => {
  try {
    // Make API request to register the user (adjust URL as needed)
    await useUserStore()
      .signup(form)
      .then(() => {
        //redirect to login
        router.push("/login");
      });

    // Redirect to login page on success
    if (response.status === 201) {
      router.push("/login");
    }
  } catch (error) {
    console.error("Signup failed:", error.response.data);
    alert("Error during signup. Please try again.");
  }
};
</script>

<style scoped>
/* Add any scoped custom styles here if necessary */
</style>
