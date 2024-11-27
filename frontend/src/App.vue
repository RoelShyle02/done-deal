<script setup>
//go to home
function goToHome() {
  window.location.href = "/";
}
</script>

<template>
  <div>
    <!-- //header and logo -->

    <div class="bg-teal-600 p-4 shadow-md">
      <div class="max-w-6xl mx-auto flex justify-between items-center">
        <!-- Logo or Name -->
        <h1 class="text-white text-2xl font-semibold cursor-pointer" @click="goToHome()">
          DoneDeal

          <i class="fa fa-check"></i>
        </h1>
        <!-- Navigation Links (Optional) -->
        <div class="space-x-4">
          <a href="#" class="text-white hover:text-gray-300">Home</a>
          <a href="#" class="text-white hover:text-gray-300">About</a>
          <a href="#" class="text-white hover:text-gray-300">Contact</a>
        </div>
      </div>
    </div>
    <router-view class=""></router-view>
  </div>
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
