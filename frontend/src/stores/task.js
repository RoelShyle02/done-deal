import { defineStore } from "pinia";
import router from "@/plugins/routes";
import Api from "@/services/Api";

export const useTaskStore = defineStore("task", {
  state: () => ({
    planners: [],
    selected_planner: null,
    tasks: [
      {
        id: 1,
        name: "Plan marketing strategy",
        description: "Develop a detailed marketing strategy for Q1.",
        planner_guid: "19544d48-07a8-4fd8-ba51-9b4eac290f05",
        status: "1",
        priority: "1",
        due_date: "2024-12-01 12:00:00",
        completed_at: null,
        created_by: 1,
      },
      {
        id: 2,
        name: "Complete backend API",
        description: "Finalize and test all endpoints for the new task manager feature.",
        planner_guid: "19544d48-07a8-4fd8-ba51-9b4eac290f05",
        status: "1",
        priority: "1",
        due_date: "2024-11-30 18:00:00",
        completed_at: null,
        created_by: 2,
      },
    ],
    statuses: [
      { id: 1, name: "Not started" },
      { id: 2, name: "In progress" },
      { id: 3, name: "Completed" },
    ],
    priorities: [
      { id: 1, name: "Low" },
      { id: 2, name: "Medium" },
      { id: 3, name: "High" },
    ],
  }),

  actions: {
    async addPlanner(planner) {
      return await Api(true)
        .post("/create-planner", { name: planner })
        .then((response) => {
          this.planners.push(response.data.planner);
          //select planner
          this.selected_planner = response.data.planner;
        });
    },

    async getPlanners() {
      await Api(true)
        .get("/planners")
        .then((response) => {
          this.planners = response.data.planners;
        });
    },

    async getTasks() {
      let selected_guid = this.selected_planner.guid;
      if (selected_guid == null) {
        //alert problem
        alert("Please select a planner");
      } else {
        await Api(true)
          .get("/tasks")
          .then((response) => {
            this.tasks = response.data.tasks;
          });
      }
    },
  },
});
