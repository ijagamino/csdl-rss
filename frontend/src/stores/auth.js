import axios from "axios";
import { api } from "boot/axios";
import { defineStore } from "pinia";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const token = ref(localStorage.getItem("token") || "");

  const login = async (credentials) => {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");

    try {
      await axios.post("http://localhost:8000/login", credentials);
    } catch (e) {
      return Promise.reject(e.response.data.errors);
    }

    const { data } = await api.get("/user");

    console.log(data);
    user.value = data;

    // reroute to dashboard
  };

  const logout = async () => {
    try {
      await axios.post("/logout");
    } catch (e) {
      return Promise.reject(e.response.data.errors);
    }

    user.value = null;
    token.value = "";

    // reroute to welcome
  };

  return { user, token, login, logout };
});
