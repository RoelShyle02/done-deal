import { createApp } from "vue";
import "./style.css";
import App from "./App.vue";
import { createPinia } from "pinia";
import router from "@/plugins/routes.js";
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

const pinia = createPinia();

const app = createApp(App);

app.use(router);
app.use(Toast, {
  position: "top-right",
  timeout: 4500,
  closeOnClick: true,
  pauseOnFocusLoss: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  hideProgressBar: true,
  closeButton: "button",
  classNames: ["p-1"],
  icon: true,
  rtl: false,
});
app.use(pinia);
app.mount("#app");
