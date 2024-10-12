export const useAuthStore = defineStore(
  "auth",
  () => {
    const user = ref(null);
    const can = ref(null);
    const token = ref(localStorage.getItem("token") || "");

    const errors = ref({});

    const router = useRouter();

    const { mutate } = useMutation({
      mutationFn: async (form) => {
        await axios.get("sanctum/csrf-cookie");
        await axios.post("login", form);
      },
      onError: (err) => {
        errors.value = err.response.data.errors;
        $q.notify({
          message: "Log in fail",
          color: "red",
        });
      },
      onSuccess: async () => {
        const { data } = await api.get("/user");

        errors.value = {};
        user.value = data.user;
        can.value = data.can;

        console.log(can.value);
        console.log(data.can);

        router.push({ name: "reports.index" });

        $q.notify({
          message: "Logged in successfully!",
          color: "positive",
        });
      },
    });

    const login = (form) => {
      mutate({
        email: form.email,
        password: form.password,
      });
    };

    const logout = async () => {
      try {
        await axios.post("/logout");
      } catch (error) {
        router.push({ name: "welcome" });
        user.value = null;
        token.value = "";
        return Promise.reject(err.response.data.errors);
      }

      router.push({ name: "welcome" });

      user.value = null;
      can.value = null;
      token.value = "";
    };

    return { user, can, token, errors, login, logout };
  },
  {
    persist: true,
  }
);
