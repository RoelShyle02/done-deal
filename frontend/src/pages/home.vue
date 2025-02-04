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
import { onMounted } from "vue";
import { useTaskStore } from "@/stores/task";

import sidebar from "./sidebar.vue";
import tasks from "./tasks.vue";

onMounted(async () => {
  if (useTaskStore().selected_planner) await useTaskStore().getTasks();
});
</script>
