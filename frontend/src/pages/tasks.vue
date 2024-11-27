<template>
  <div class="w-full p-4">
    <div class="mb-4 flex justify-between items-center">
      <h2 class="text-2xl font-bold">Tasks : Dashboard</h2>

      <!-- Filter by Status -->
      <div class="select">
        <select v-model="selectedStatus" class="border rounded px-2 py-1 text-sm select">
          <option value="">All Statuses</option>
          <option value="Pending">Pending</option>
          <option value="In Progress">In Progress</option>
          <option value="Completed">Completed</option>
          <option value="Blocked">Blocked</option>
        </select>
      </div>
    </div>

    <!-- Grouped Tasks -->
    <div v-for="(tasks, planner) in filteredTasksByPlanner" :key="planner" class="mb-6">
      <!-- <h3 class="text-lg font-semibold mb-2">{{ planner }}</h3> -->
      <div class="bg-white shadow-md rounded overflow-hidden divide-y">
        <div v-for="task in tasks" :key="task.id" class="p-4 flex justify-between items-center bg-teal-50/80">
          <div>
            <div class="flex items-center">
              <h4 class="font-medium">{{ task.name }}</h4>
              <i class="fa fa-pen fa-xs pl-1 text-gray-300 hover:text-gray-700" @click="editTask(task)"></i>
            </div>

            <p class="text-sm text-gray-500">{{ task.description }}</p>
            <p class="text-sm text-gray-400">Due: {{ formatDate(task.due_date) }}</p>
          </div>
          <div>
            <span
              :class="[
                'px-2 py-1 text-xs font-semibold rounded',
                task.priority === 'High'
                  ? 'bg-red-100 text-red-700'
                  : task.priority === 'Medium'
                  ? 'bg-yellow-100 text-yellow-700'
                  : 'bg-green-100 text-green-700',
              ]"
            >
              {{ task.priority }}
            </span>
            <span
              :class="[
                'ml-2 px-2 py-1 text-xs font-semibold rounded',
                task.status === 'Completed'
                  ? 'bg-green-200 text-green-800'
                  : task.status === 'In Progress'
                  ? 'bg-blue-200 text-blue-800'
                  : task.status === 'Blocked'
                  ? 'bg-red-200 text-red-800'
                  : 'bg-gray-200 text-gray-800',
              ]"
            >
              {{ task.status }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed, ref } from "vue";

// Dummy data
const tasks = ref([
  {
    id: 1,
    name: "Plan marketing strategy",
    description: "Develop a detailed marketing strategy for Q1.",
    planner_guid: "abc123-guid",
    status: "Completed",
    priority: "High",
    due_date: "2024-12-01T12:00:00",
  },

  {
    id: 3,
    name: "Fix Login Bug",
    description: "Fix the login page bug for incorrect error handling.",
    planner_guid: "abc123-guid",
    status: "In Progress",
    priority: "Medium",
    due_date: "2024-11-29T10:00:00",
  },
]);

const selectedStatus = ref(""); // To filter by status

// Group tasks by planner
const tasksByPlanner = computed(() => {
  return tasks.value.reduce((acc, task) => {
    const planner = task.planner_guid || "Unassigned";
    if (!acc[planner]) acc[planner] = [];
    acc[planner].push(task);
    return acc;
  }, {});
});

// Filter tasks by status and group by planner
const filteredTasksByPlanner = computed(() => {
  const filteredTasks = selectedStatus.value
    ? tasks.value.filter((task) => task.status === selectedStatus.value)
    : tasks.value;

  return filteredTasks.reduce((acc, task) => {
    const planner = task.planner_guid || "Unassigned";
    if (!acc[planner]) acc[planner] = [];
    acc[planner].push(task);
    return acc;
  }, {});
});

function editTask(task) {
  // Handle edit task logic
}

// Helper function to format dates
const formatDate = (dateStr) => {
  const date = new Date(dateStr);
  return date.toLocaleDateString();
};
</script>
