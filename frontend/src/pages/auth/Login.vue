<template>
  <q-form>
    <FormInput
      v-model="form.email"
      label="Email"
      bottom-slots
      :error="!!authStore.errors.email"
      :error-message="authStore.errors.email?.join(' ')"
    />
    <FormInput
      v-model="form.password"
      label="Password"
      :type="showPassword ? 'text' : 'password'"
      bottom-slots
      :error="!!authStore.errors.password"
      :error-message="authStore.errors.password?.join(' ')"
    >
      <template #append>
        <q-icon
          :name="showPassword ? 'visibility' : 'visibility_off'"
          class="cursor-pointer"
          @click="showPassword = !showPassword"
        />
      </template>
    </FormInput>
    <VButton label="Log In" @click="authStore.login(form)" />
  </q-form>
</template>

<script setup>
const authStore = useAuthStore();
const $q = useQuasar();

const errors = ref({})

const form = reactive({
  email: null,
  password: null,
});

const showPassword = ref(false);
</script>
