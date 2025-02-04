<template>
  <div class="h-screen text-white bg-teal-600" :class="isCollapsed ? 'w-16' : 'w-64'">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4" :class="{ 'justify-center': isCollapsed }">
      <h2 class="text-xl font-semibold" v-show="!isCollapsed">Planners</h2>
      <div class="flex items-center gap-2">
        <span v-if="!isCollapsed" title="Add new" class="cursor-pointer" @click="show_new = !show_new">
          <i class="fa fa-lg fa-plus-square"></i>
        </span>
        <span title="Toggle sidebar" class="flex items-center justify-center w-8 h-8 cursor-pointer" @click="isCollapsed = !isCollapsed">
          <i class="fa fa-lg" :class="isCollapsed ? 'fa-angle-right' : 'fa-angle-left'"></i>
        </span>
      </div>
    </div>
    <!-- Sidebar Links -->
    <ul class="px-2">
      <template v-if="show_new && !isCollapsed">
        <li>
          <input v-model="new_planner" @keyup.enter="addPlanner" type="text" class="w-full px-2 py-1 text-black border rounded" placeholder="Enter planner name" />
        </li>
      </template>
      <li class="border-b" v-for="planner in useTaskStore().planners" :key="planner.id">
        <div @click="goTo(planner.guid)" 
        class="block px-4 py-2 transition rounded cursor-pointer flex justify-between" :class="useTaskStore().selected_planner?.guid === planner.guid ? 'bg-teal-800' : 'hover:bg-teal-700'">

          <i class="fa fa-list" v-if="isCollapsed"></i>
          <span v-else>{{ planner.name }}</span>
          <i class="fa fa-trash" v-if="!isCollapsed" @click.prevent="deletePlanner(planner.id)"></i>

        </div>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import { useTaskStore } from "@/stores/task";

const show_new = ref(false);
const new_planner = ref("");
const isCollapsed = ref(false);



async function deletePlanner(id){

  await useTaskStore().deletePlanner(id)
  .then(()=>{

    //i have to remove this planner from the list of planners 

    useTaskStore().planners = [...useTaskStore().planners.filter(p=>
      p.id != id
    )]
    useToast().info("Planner was deleted successfully");
})
}

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
  useTaskStore().selected_planner = useTaskStore().planners.find((planner) => planner.guid == planner_guid);
  // i will get the tasks for the planner

  await useTaskStore().getTasks();
}
// This is where you can add any reactive properties or methods if needed
</script>
