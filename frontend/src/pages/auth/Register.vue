<template>
  <q-card>
    <q-card-section>
      <q-form>
        <FormInput
          v-model="form.email"
          label="Email"
          bottom-slots
          :error="!!errors.email"
          :errors="errors.email"
        />
        <FormInput
          v-model="form.username"
          label="Username"
          bottom-slots
          :error="!!errors.username"
          :errors="errors.username"
        />
        <FormInput
          v-model="form.password"
          label="Password"
          bottom-slots
          :type="showPassword ? 'text' : 'password'"
          :error="!!errors.password"
          :errors="errors.password"
        >
          <template #append>
            <q-icon
              :name="showPassword ? 'visibility' : 'visibility_off'"
              class="cursor-pointer"
              @click="showPassword = !showPassword"
            />
          </template>
        </FormInput>
        <FormInput
          v-model="form.password_confirmation"
          label="Confirm Password"
          :type="showPasswordConfirmation ? 'text' : 'password'"
          :error="!!errors.pasword_confirmation"
          :errors="errors.pasword_confirmation"
        >
          <template #append>
            <q-icon
              :name="showPasswordConfirmation ? 'visibility' : 'visibility_off'"
              class="cursor-pointer"
              @click="showPasswordConfirmation = !showPasswordConfirmation"
            />
          </template>
        </FormInput>
        <div class="row q-col-gutter-lg q-mb-lg">
          <FormInput
            class="col-12 col-md-6"
            v-model="form.first_name"
            label="First Name"
            bottom-slots
            :error="!!errors.first_name"
            :error-message="
              errors.first_name?.length > 0 ? errors.first_name?.join(' ') : ''
            "
          />
          <FormInput
            class="col-12 col-md-6"
            v-model="form.last_name"
            label="Last Name"
            bottom-slots
            :error="!!errors.last_name"
            :errors="errors.last_name"
          />
        </div>
        <VButton label="Register" @click="register()" />
      </q-form>
    </q-card-section>
  </q-card>
</template>

<script setup>
const authStore = useAuthStore();
const $q = useQuasar();

const errors = ref({});

const form = reactive({
  email: null,
  username: null,
  password: null,
  password_confirmation: null,
  first_name: null,
  last_name: null,
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const { mutate } = useMutation({
  mutationFn: async (form) => {
    await axios.get("sanctum/csrf-cookie");
    await axios.post("register", form);
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
    $q.notify({
      message: "Registration fail, check for errors!",
      color: "negative",
    });
  },
  onSuccess: async () => {
    authStore.login(form);

    $q.notify({
      message: "Registered successfully, logging in and redirecting...",
      color: "positive",
    });
  },
});

const register = () => {
  mutate(form);
};
</script>
