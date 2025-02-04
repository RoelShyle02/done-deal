<template>
  <div class="w-full p-4">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-2xl font-bold">Tasks Dashboard {{ useTaskStore().selected_planner ? "- " + useTaskStore().selected_planner.name : "" }}</h2>
      <div class="flex items-center gap-4" v-if="filteredTasksByPlanner.length != 0">
        <!-- Redesigned Status Filter -->
        <div class="relative">
          <div
            @click="statusDropdownOpen = !statusDropdownOpen"
            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 transition-colors bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-teal-500"
          >
            <span>
              {{ selectedStatus || "All Statuses" }}
            </span>
            <i class="text-xs fas fa-chevron-down"></i>
          </div>

          <div v-if="statusDropdownOpen" class="absolute right-0 z-10 mt-2 origin-top-right bg-white border border-gray-100 rounded-lg shadow-lg">
            <div class="py-1">
              <a @click="selectStatus('')" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-50"> All Statuses </a>
              <a v-for="status in useTaskStore().statuses" :key="status.id" @click="selectStatus(status.name)" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-50">
                {{ status.name }}
              </a>
            </div>
          </div>
        </div>

        <!-- Redesigned Priority Filter -->
        <div class="relative">
          <div
            @click="priorityDropdownOpen = !priorityDropdownOpen"
            class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 transition-colors bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-teal-500"
          >
            <span>
              {{ selectedPriority || "All Priorities" }}
            </span>
            <i class="text-xs fas fa-chevron-down"></i>
          </div>

          <div v-if="priorityDropdownOpen" class="absolute right-0 z-10 mt-2 origin-top-right bg-white border border-gray-100 rounded-lg shadow-lg">
            <div class="py-1">
              <a @click="selectPriority('')" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-50"> All Priorities </a>
              <a v-for="priority in useTaskStore().priorities" :key="priority.id" @click="selectPriority(priority.name)" class="block px-4 py-2 text-sm text-gray-700 cursor-pointer hover:bg-gray-50">
                {{ priority.name }}
              </a>
            </div>
          </div>
        </div>

        <!-- Add task button -->
        <button @click="openTaskModal" class="px-2 py-1 text-white bg-teal-600 rounded-full hover:bg-teal-700">
          <i class="fas fa-plus"></i>
        </button>
      </div>
    </div>

    <div v-if="Object.keys(filteredTasksByPlanner).length === 0 && useTaskStore().selected_planner" class="flex flex-col items-center justify-center w-full p-8 rounded-lg">
      <div class="mb-6 text-center">
        <i class="block mb-4 text-6xl text-gray-400 fas fa-tasks"></i>
        <p class="mb-4 text-xl text-gray-600">No tasks in this planner yet</p>
      </div>
      <button @click="openTaskModal" class="flex items-center justify-center gap-3 px-6 py-3 text-lg text-white transition-colors bg-teal-600 rounded-lg shadow-lg hover:bg-teal-700">
        <i class="fas fa-plus"></i>
        Create Your First Task
      </button>
    </div>

    <!-- Grouped Tasks -->
    <div v-for="(tasks, planner) in filteredTasksByPlanner" :key="planner" class="mb-6">
      <div class="space-y-4">
        <div v-for="task in tasks" :key="task.id" class="transition-all duration-300 ease-in-out bg-white border border-gray-100 rounded-lg shadow-md hover:shadow-lg">
          <div class="flex items-start p-4 space-x-4">
            <!-- Checkbox -->
            <div class="pt-1">
              <input type="checkbox" :checked="task.status_id === 3" @change="updateTaskStatus(task)" class="w-5 h-5 mt-1 rounded-full accent-teal-600" />
            </div>

            <!-- Task Content -->
            <div class="flex-grow">
              <div class="flex items-start justify-between">
                <div>
                  <h4 class="mb-1 text-lg font-semibold" :class="{ 'line-through text-gray-400': task.status_id === 3 }">
                    {{ task.title }}
                  </h4>
                  <p class="w-full mb-2 text-sm text-gray-600 break-words break-all whitespace-normal overflow-wrap-break-word">
                    {{ task.description }}
                  </p>
                </div>

                <!-- Edit Button -->
                <button @click="editTask(task)" class="text-gray-500 transition-colors hover:text-teal-600">
                  <i class="fas fa-edit"></i>
                </button>
              </div>

              <!-- Task Metadata -->
              <div class="flex flex-wrap items-center gap-2 mt-2">
                <span :class="getPriorityClass(task.priority_id)" class="inline-block">
                  {{ useTaskStore().priorities.find((p) => p.id === task.priority_id)?.name }}
                </span>
                <span :class="getStatusClass(task.status_id)" class="inline-block">
                  {{ useTaskStore().statuses.find((p) => p.id === task.status_id)?.name }}
                </span>
                <span class="flex items-center gap-1 text-xs text-gray-500">
                  <i class="fas fa-calendar-alt"></i>
                  {{ formatDate(task.due_date) }}
                </span>
                <span v-if="task.completed_at" class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded"> Completed: {{ formatDate(task.completed_at) }} </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="showTaskModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
      <div class="p-6 bg-white rounded-lg w-[30rem]">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-xl font-bold">{{ isEditing ? "Edit Task" : "Create New Task" }}</h3>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-700">
            <i class="fas fa-times"></i>
          </button>
        </div>

        <form @submit.prevent="submitTask" class="space-y-4">
          <div>
            <label class="block mb-1 text-sm font-medium">Title</label>
            <input v-model="newTask.title" type="text" class="w-full px-3 py-2 border rounded" required />
          </div>

          <div>
            <label class="block mb-1 text-sm font-medium">Description</label>
            <textarea v-model="newTask.description" class="w-full px-3 py-2 border rounded" rows="3"></textarea>
          </div>

          <div>
            <label class="block mb-1 text-sm font-medium">Status</label>
            <select v-model="newTask.status_id" class="w-full px-3 py-2 border rounded">
              <option v-for="status in useTaskStore().statuses" :key="status.id" :value="status.id">
                {{ status.name }}
              </option>
            </select>
          </div>

          <div>
            <label class="block mb-1 text-sm font-medium">Priority</label>
            <select v-model="newTask.priority_id" class="w-full px-3 py-2 border rounded">
              <option v-for="priority in useTaskStore().priorities" :key="priority.id" :value="priority.id">
                {{ priority.name }}
              </option>
            </select>
          </div>

          <VueDatePicker v-model="newTask.due_date" :format="format" :enable-time-picker="false" required class="w-full" />

          <div class="flex justify-end gap-2 mt-6">
            <button type="button" @click="closeModal" class="px-4 py-2 text-gray-600 border rounded hover:bg-gray-100">Cancel</button>
            <button type="submit" class="px-4 py-2 text-white bg-teal-600 rounded hover:bg-teal-700">{{ isEditing ? "Update" : "Create" }} Task</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup>
import { computed, ref, onMounted, onUnmounted } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
const format = "dd/MM/yyyy HH:mm";

import { useTaskStore } from "@/stores/task";

const selectedStatus = ref(""); // To filter by status

const showTaskModal = ref(false);

const getPriorityClass = (priority) => {
  const classes = "px-2 py-1 text-xs font-semibold rounded";
  const priorities = {
    3: "bg-red-100 text-red-700",
    2: "bg-yellow-100 text-yellow-700",
    1: "bg-green-100 text-green-700",
  };
  return `${classes} ${priorities[priority]}`;
};

const getStatusClass = (status) => {
  const classes = "px-2 py-1 text-xs font-semibold rounded";
  const statuses = {
    3: "bg-green-200 text-green-800",
    2: "bg-blue-200 text-blue-800",
    1: "bg-red-200 text-red-800",
  };
  return `${classes} ${statuses[status]}`;
};

const openTaskModal = () => {
  showTaskModal.value = true;
};

const isEditing = ref(false);

const editTask = (task) => {
  isEditing.value = true;
  newTask.value = { ...task };
  showTaskModal.value = true;
};

const closeModal = () => {
  showTaskModal.value = false;
  isEditing.value = false;
  newTask.value = {
    title: "",
    description: "",
    status_id: 1,
    priority_id: 2,
    due_date: "",
  };
};

const submitTask = async () => {
  if (isEditing.value) {
    const formattedDate = new Date(newTask.value.due_date).toISOString().slice(0, 19).replace("T", " ");
    const updatedTaskData = {
      ...newTask.value,
      due_date: formattedDate,
    };
    await useTaskStore().updateTask(updatedTaskData);
  } else {
    await createTask();
  }
  closeModal();
};

const isCollapsed = ref(false);
const updateTaskStatus = async (task) => {
  const updatedTask = {
    ...task,
    status_id: task.status_id === 3 ? 1 : 3,
  };
  await useTaskStore().updateTask(updatedTask);
};

const newTask = ref({
  title: "",
  description: "",
  status_id: 1,
  priority_id: 2,
  due_date: "",
});

const createTask = async () => {
  const formattedDate = new Date(newTask.value.due_date).toISOString().slice(0, 19).replace("T", " ");

  const taskData = {
    title: newTask.value.title,
    description: newTask.value.description,
    status_id: newTask.value.status_id,
    priority_id: newTask.value.priority_id,
    due_date: formattedDate,
    planner_guid: useTaskStore().selected_planner.guid,
  };

  useTaskStore().createTask(taskData);
  showTaskModal.value = false;
  newTask.value = {
    title: "",
    description: "",
    status_id: 1,
    priority_id: 2,
    due_date: "",
  };
};

// Add these reactive variables
const statusDropdownOpen = ref(false);
const priorityDropdownOpen = ref(false);
const selectedPriority = ref("");

// New methods for filter selection
const selectStatus = (status) => {
  selectedStatus.value = status;
  statusDropdownOpen.value = false;
};

const selectPriority = (priority) => {
  selectedPriority.value = priority;
  priorityDropdownOpen.value = false;
};

// Close dropdowns when clicking outside
const handleClickOutside = (event) => {
  const dropdowns = document.querySelectorAll(".relative");
  let isOutside = true;
  dropdowns.forEach((dropdown) => {
    if (dropdown.contains(event.target)) {
      isOutside = false;
    }
  });

  if (isOutside) {
    statusDropdownOpen.value = false;
    priorityDropdownOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});

// Modify existing filteredTasksByPlanner to include priority filtering
const filteredTasksByPlanner = computed(() => {
  if (useTaskStore()?.tasks?.length == 0) return [];

  let filteredTasks = useTaskStore().tasks;

  // Filter by status
  if (selectedStatus.value) {
    const statusObj = useTaskStore().statuses.find((s) => s.name === selectedStatus.value);
    filteredTasks = filteredTasks.filter((task) => task.status_id === statusObj?.id);
  }

  // Filter by priority
  if (selectedPriority.value) {
    const priorityObj = useTaskStore().priorities.find((p) => p.name === selectedPriority.value);
    filteredTasks = filteredTasks.filter((task) => task.priority_id === priorityObj?.id);
  }

  return filteredTasks.reduce((acc, task) => {
    const planner = task.planner_guid || "Unassigned";
    if (!acc[planner]) acc[planner] = [];
    acc[planner].push(task);
    return acc;
  }, {});
});
// Helper function to format dates
const formatDate = (dateStr) => {
  const date = new Date(dateStr);
  return date.toLocaleDateString();
};
</script>
