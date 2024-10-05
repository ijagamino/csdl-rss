import { api } from "boot/axios";
import { defineStore } from "pinia";
import axios from "axios";

const auth = reactive({
  authenticated: false,
  user: {},
});

export const useAuthStore = defineStore("auth", () => {
  const authenticated = computed(() => {
    auth.authenticated;
  });
  const user = computed(() => {
    auth.user;
  });

  const setAuthenticated = (authenticated) => {
    auth.authenticated = authenticated;
  };
  const setUser = (user) => {
    auth.user = user;
  };

  const login = async (credentials) => {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");

    try {
      await axios.post("http://localhost:8000/login", credentials);
      return attempt();
    } catch (e) {
      return Promise.reject(e.response.data.errors);
    }

    const { data } = await api.get("/user");

    console.log(`Credentials: ${credentials.email}`);
    console.log(auth);
  };

  const attempt = async () => {
    try {
      const response = await api.get("/user");

      setAuthenticated(true);
      setUser(response.data);
      console.log("Auth user " + auth.user.name);

      console.log(response);
      return response;
    } catch (e) {
      setAuthenticated(false);
      setUser({});
    }
  };

  return { authenticated, user, login, attempt };
});
