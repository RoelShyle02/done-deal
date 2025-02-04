<script setup>
import { useUserStore } from "@/stores/user";
const userStore = useUserStore();
//go to home
function goToHome() {
  window.location.href = "/dashboard";
}

function handleAuth() {
  if (userStore.user) {
    userStore.logout();
  } else {
    window.location.href = "/login";
  }
}
</script>

<template>
  <div>
    <div class="py-4 pl-[17rem] bg-teal-600 shadow-md">
      <div class="flex items-center justify-between w-full pr-4">
        <h1 class="text-2xl font-semibold text-white cursor-pointer" @click="goToHome()">
          DoneDeal
          <i class="fa fa-check"></i>
        </h1>
        <div class="flex items-center space-x-4">
          <a href="/dashboard" class="text-white hover:text-gray-300">Home</a>
          <a href="/about" class="text-white hover:text-gray-300">About</a>
          <a href="/contact" class="text-white hover:text-gray-300">Contact</a>
          <span v-if="userStore.user" class="text-white"><i class="fa fa-user"></i> {{ userStore.user.name }}</span>
          <button @click="handleAuth" class="px-4 py-2 text-white bg-teal-700 rounded hover:text-gray-300">
            {{ userStore.user ? "Logout" : "Login" }}
          </button>
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
