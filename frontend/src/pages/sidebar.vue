<template>
  <div class="bg-teal-600 text-white w-64 h-screen p-4">
    <!-- Sidebar Header -->
    <div class="mb-6 flex items-center justify-between">
      <h2 class="text-xl font-semibold">Planners</h2>
      <span title="Add new" class="cursor-pointer" @click="show_new = !show_new">
        <i class="fa fa-lg fa-plus-square"></i>
      </span>
    </div>

    <!-- Sidebar Links -->
    <ul class="">
      <template v-if="show_new">
        <li>
          <input
            v-model="new_planner"
            @keyup.enter="addPlanner"
            type="text"
            class="w-full px-2 py-1 text-black rounded border"
            placeholder="Enter planner name"
          />
        </li>
      </template>
      <li class="border-b" v-for="planner in useTaskStore().planners" :key="planner.id">
        <div @click="goTo(planner.guid)" class="block py-2 px-4 rounded hover:bg-teal-700 transition cursor-pointer">
          {{ planner.name }}
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { useTaskStore } from "@/stores/task";
const show_new = ref(false);
const new_planner = ref("");

async function addPlanner() {
  await useTaskStore()
    .addPlanner(new_planner.value)
    .then(() => {
      new_planner.value = "";
      show_new.value = false;
      useToast().info("Planner added successfully");
    });
}
async function goTo(planner_guid) {
  useTaskStore().selectedPlanner = useTaskStore().planners.find((planner) => planner.guid === planner_guid);
  // i will get the tasks for the planner

  await useTaskStore().getTasks();
}
// This is where you can add any reactive properties or methods if needed
</script>
