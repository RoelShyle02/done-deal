import { defineStore } from "pinia";
import router from "@/plugins/routes";
import Api from "@/services/Api";

export const useUserStore = defineStore("user", {
  state: () => ({
    server: "http://127.0.0.1:8000/api",
    credentials: {
      email: "",
      password: "",
    },
    user: localStorage.getItem("user") != null ? JSON.parse(localStorage.getItem("user")) : null,
    token: localStorage.getItem("token"),
    loguar: false,
    access_token: localStorage.getItem("access_token"),
  }),

  actions: {
    async isLoggedIn(path) {
      var isLogged = false;

      if (this.user == null) {
        if (localStorage.getItem("token") != null) {
          try {
            await Api(true)
              .get("/session")
              .then((response) => {
                if (response.status == 200 && response.data != null) {
                  this.user = response.data;
                  isLogged = true;
                  this.loguar = true;
                }
              });
          } catch (e) {
            console.log(e);
          }
        }
      } else {
        isLogged = true;
        this.loguar = true;
      }

      console.log(this.loguar, "loguar");
      if (isLogged == false) {
        localStorage.removeItem("token");
        localStorage.removeItem("access_token");
        localStorage.removeItem("user");
        console.log("not logged", path);

        // return path
      }
    },
    redirectToHome(path) {
      if (this.loguar == true) {
        if (path == "/login" || path == "/signup") return "/";
      }
    },
    async login() {
      Api(false)
        .post("/login", this.credentials)
        .then((response) => {
          this.user = response.data.user;
          this.token = response.data.token;
          localStorage.setItem("token", this.token);

          localStorage.setItem("user", JSON.stringify(this.user));

          window.location.href = "/";
          this.loguar = true;
        })
        .catch((error) => {
          alert("Invalid credentials aa, please try again!");
        });
    },
    async signup(credentials) {
      Api(false)
        .post("/signup", credentials)
        .then((response) => {
          this.user = response.data.data.user;
          this.token = response.data.data.token;
          this.access_token = response.data.data.access_token;
          localStorage.setItem("token", this.token);

          localStorage.setItem("user", JSON.stringify(this.user));

          window.location.href = "/";
          this.loguar = true;
        })
        .catch((error) => {
          alert("Invalid credentials, please try again!");
        });
    },
    async logout() {
      this.user = null;
      this.token = null;
      this.access_token = null;
      localStorage.removeItem("token");
      localStorage.removeItem("user");
      window.location.reload();
    },
  },
});
