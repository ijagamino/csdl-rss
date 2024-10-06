import axios from "axios";
import { api } from "boot/axios";
import { defineStore } from "pinia";

export const useAuthStore = defineStore(
  "auth",
  () => {
    const user = ref(null);
    const token = ref(localStorage.getItem("token") || "");

    const router = useRouter();

    const login = async (credentials) => {
      await axios.get("http://localhost:8000/sanctum/csrf-cookie");

      try {
        await axios.post("http://localhost:8000/login", credentials);
      } catch (e) {
        return Promise.reject(e.response.data.errors);
      }

      const { data } = await api.get("/user");

      user.value = data;

      await router.push({ name: "reports" });

      // reroute to dashboard
    };

    const logout = async () => {
      try {
        await axios.post("/logout");
      } catch (e) {
        return Promise.reject(e.response.data.errors);
      }

      await router.push({ name: "welcome" });
      user.value = null;
      token.value = ""; // reroute to welcome
    };

    return { user, token, login, logout };
  },
  {
    persist: true,
  }
);
