<template>
  <div class="container max-w-4xl px-4 py-16 mx-auto">
    <div class="mb-12 text-center">
      <h1 class="mb-4 text-4xl font-bold text-teal-600">Contact DoneDeal</h1>
      <p class="max-w-2xl mx-auto text-xl text-gray-600">We're here to help. Reach out to us with any questions, feedback, or support needs.</p>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
      <!-- Contact Form -->
      <div class="p-8 bg-white rounded-lg shadow-md">
        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <label class="block mb-2 text-gray-700" for="name">Full Name</label>
            <input v-model="name" type="text" id="name" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
          </div>

          <div>
            <label class="block mb-2 text-gray-700" for="email">Email Address</label>
            <input v-model="email" type="email" id="email" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500" />
          </div>

          <div>
            <label class="block mb-2 text-gray-700" for="message">Your Message</label>
            <textarea v-model="message" id="message" rows="4" required class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
          </div>

          <button type="submit" class="w-full py-3 text-white transition-colors bg-teal-600 rounded-md hover:bg-teal-700">Send Message</button>
        </form>
      </div>

      <!-- Contact Information -->
      <div class="p-8 space-y-6 rounded-lg bg-gray-50">
        <div class="flex items-center space-x-4">
          <i class="text-2xl text-teal-500 fas fa-map-marker-alt"></i>
          <div>
            <h3 class="font-semibold text-gray-800">Our Address</h3>
            <p class="text-gray-600">123 Productivity Lane, Tech City, Innovation State 12345</p>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <i class="text-2xl text-teal-500 fas fa-envelope"></i>
          <div>
            <h3 class="font-semibold text-gray-800">Email</h3>
            <p class="text-gray-600">support@donedeal.com</p>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <i class="text-2xl text-teal-500 fas fa-phone"></i>
          <div>
            <h3 class="font-semibold text-gray-800">Phone</h3>
            <p class="text-gray-600">(555) 123-4567</p>
          </div>
        </div>

        <div class="mt-6">
          <h3 class="mb-4 font-semibold text-gray-800">Follow Us</h3>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-600 hover:text-teal-600">
              <i class="text-2xl fab fa-twitter"></i>
            </a>
            <a href="#" class="text-gray-600 hover:text-teal-600">
              <i class="text-2xl fab fa-linkedin"></i>
            </a>
            <a href="#" class="text-gray-600 hover:text-teal-600">
              <i class="text-2xl fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";

// Form data
const name = ref("");
const email = ref("");
const message = ref("");

// Form submission method
const submitForm = async () => {
  // Here you would typically send the form data to a backend service
  try {
    // Example of form submission logic
    console.log("Submitted:", { name: name.value, email: email.value, message: message.value });

    // Reset form after submission
    name.value = "";
    email.value = "";
    message.value = "";

    // Optionally show a success message
    alert("Message sent successfully!");
  } catch (error) {
    console.error("Error submitting form:", error);
    alert("Failed to send message. Please try again.");
  }
};
</script>
