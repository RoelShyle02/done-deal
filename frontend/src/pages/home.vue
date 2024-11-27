<template>
  <div class="flex">
    <div>
      <!-- BLOCK:: SIDEBAR -->

      <sidebar></sidebar>
    </div>

    <!-- BLOCK:: TASKS -->
    <tasks></tasks>

  </div>
</template>

<script setup>
import { ref } from "vue";

import sidebar from "./sidebar.vue";
import tasks from "./tasks.vue";
</script>
