<template>
  <q-form>
    <q-input
      v-model="form.email"
      label="Email"
      bottom-slots
      :error="!!errors.email"
      :error-message="errors.email?.join(' ')"
    />
    <q-input
      v-model="form.password"
      label="Password"
      :type="showPassword ? 'text' : 'password'"
      bottom-slots
      :error="!!errors.password"
      :error-message="errors.password?.join(' ')"
    >
      <template #append>
        <q-icon
          :name="showPassword ? 'visibility' : 'visibility_off'"
          class="cursor-pointer"
          @click="showPassword = !showPassword"
        />
      </template>
    </q-input>
    <VButton label="Log In" @click="authStore.login(form)" />
  </q-form>
</template>

<script setup>
const authStore = useAuthStore();
const $q = useQuasar();

const errors = ref({});

const form = reactive({
  email: null,
  password: null,
});

const showPassword = ref(false);
</script>
