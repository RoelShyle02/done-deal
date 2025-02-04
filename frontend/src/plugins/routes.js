import { createRouter, createWebHistory } from "vue-router";
import { useUserStore } from "@/stores/user";
import { useTaskStore } from "../stores/task";

const routes = [
  {
    path: "/dashboard",
    component: () => import("@/pages/dashboard.vue"),
    beforeEnter: [() => useUserStore().isLoggedIn("/"), () => useTaskStore().getDashboardPlanners()],
    meta: {
      title: "DoneDeal - Dashboard",
    },
  },
  {
    path: "/",
    component: () => import("@/pages/home.vue"),
    beforeEnter: [
      // check if the user is logged in
      () => useUserStore().isLoggedIn("/"),
      () => useTaskStore().getPlanners(),
    ],
    meta: {
      title: "DoneDeal - Tasks",
    },
  },
  {
    path: "/login",
    component: () => import("@/pages/register/login.vue"),
    beforeEnter: [
      // check if the user is logged in
      (to) => useUserStore().isLoggedIn(to.path),
      (to) => useUserStore().redirectToHome(to.path),
    ],
    meta: {
      title: "DoneDeal - Login",
    },
  },
  {
    path: "/signup",
    component: () => import("@/pages/register/sign-up.vue"),
    beforeEnter: [
      // check if the user is logged in
      (to) => useUserStore().isLoggedIn(to.path),
      (to) => useUserStore().redirectToHome(to.path),
    ],
    meta: {
      title: "DoneDeal - Sign-up",
    },
  },

  {
    path: "/about",
    component: () => import("@/pages/about.vue"),
    meta: {
      title: "DoneDeal - About",
    },
  },
  {
    path: "/contact",
    component: () => import("@/pages/contact.vue"),
    meta: {
      title: "DoneDeal - Contact",
    },
  },
];

const router = createRouter({ history: createWebHistory(), routes });

// // Global navigation guard to set document title
// router.beforeEach((to, from, next) => {
//   document.title = to.meta.title || document.title || "Tetris";
//   next();
// });

export default router;
