<template>
  <div class="flex flex-col items-center justify-center min-h-screen p-8 bg-gray-50">
    <div class="w-full max-w-5xl">
      <h1 class="mb-12 text-4xl font-extrabold text-center text-gray-800">Planner Dashboard</h1>

      <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
        <!-- Add New Planner Card -->
        <div @click="showNewPlannerModal = true" class="flex flex-col items-center justify-center p-6 transition-all bg-white border-2 border-teal-500 border-dashed cursor-pointer rounded-2xl hover:bg-teal-50 group">
          <div class="flex items-center justify-center w-20 h-20 mb-4 transition-colors bg-teal-100 rounded-full group-hover:bg-teal-200">
            <i class="text-3xl text-teal-600 fas fa-plus"></i>
          </div>
          <h3 class="text-xl font-semibold text-teal-700">Create New Planner</h3>
        </div>

        <!-- Planner Cards -->
        <div
          v-for="planner in useTaskStore().dashboardPlanners"
          :key="planner.planner.id"
          @click="selectPlanner(planner)"
          class="transition-all transform bg-white shadow-lg cursor-pointer rounded-2xl hover:shadow-xl hover:-translate-y-2"
        >
          <div class="p-6">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-2xl font-bold text-teal-600">{{ planner.planner.name }}</h2>
              <span class="text-gray-400">
                <i class="fas fa-tasks"></i>
              </span>
            </div>

            <div class="space-y-4">
              <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                  <div class="text-2xl font-bold text-gray-800">{{ getPlannerStats(planner).total }}</div>
                  <div class="text-xs text-gray-500 uppercase">Total Tasks</div>
                </div>
                <div class="text-center">
                  <div class="text-2xl font-bold text-green-600">{{ getPlannerStats(planner).completed }}</div>
                  <div class="text-xs text-gray-500 uppercase">Completed</div>
                </div>
                <div class="text-center">
                  <div class="text-2xl font-bold text-yellow-600">{{ getPlannerStats(planner).pending }}</div>
                  <div class="text-xs text-gray-500 uppercase">Pending</div>
                </div>
              </div>

              <div class="w-full h-3 overflow-hidden bg-gray-200 rounded-full">
                <div class="h-3 transition-all duration-500 bg-teal-500 rounded-full" :style="`width: ${getPlannerStats(planner).completionPercentage}%`"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- New Planner Modal -->
    <div v-if="showNewPlannerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="p-8 bg-white shadow-2xl rounded-2xl w-96">
        <h3 class="mb-6 text-2xl font-bold text-center text-teal-600">Create New Planner</h3>
        <input v-model="newPlannerName" @keyup.enter="addPlanner" type="text" placeholder="Enter planner name" class="w-full px-4 py-3 mb-4 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-teal-500" />
        <div class="flex justify-center space-x-4">
          <button @click="showNewPlannerModal = false" class="px-6 py-2 text-gray-500 rounded-lg hover:bg-gray-100">Cancel</button>
          <button @click="addPlanner" class="px-6 py-2 text-white bg-teal-600 rounded-lg hover:bg-teal-700">Create</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useTaskStore } from "@/stores/task";
import { useToast } from "vue-toastification";

const router = useRouter();
const taskStore = useTaskStore();
const toast = useToast();

const showNewPlannerModal = ref(false);
const newPlannerName = ref("");

function getPlannerStats(planner) {
  console.log(planner);

  if (!planner.tasks || planner.tasks.length === 0) {
    return {
      total: 0,
      completed: 0,
      pending: 0,
      completionPercentage: 0,
    };
  }

  const completed = planner.tasks.filter((task) => task.status_id === 3).length;
  const total = planner.tasks.length;
  return {
    total,
    completed,
    pending: total - completed,
    completionPercentage: total ? (completed / total) * 100 : 0,
  };
}
function selectPlanner(planner) {
  console.log(planner);
  taskStore.selected_planner = planner.planner;
  router.push("/");
}

async function addPlanner() {
  if (!newPlannerName.value.trim()) {
    toast.error("Planner name cannot be empty");
    return;
  }

  await taskStore.addPlanner(newPlannerName.value);
  newPlannerName.value = "";
  showNewPlannerModal.value = false;
  toast.info("Planner added successfully");
}
</script>
