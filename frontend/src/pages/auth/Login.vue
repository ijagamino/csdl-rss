<template>
  {{ authStore.username }}
  <q-form>
    <q-input label="Email" filled v-model="form.email" />
    <q-input
      label="Password"
      filled
      :type="showPassword ? 'text' : 'password'"
      v-model="form.password"
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
import axios from "axios";
import { api } from "boot/axios";
import { useAuthStore } from "stores/auth.js";

const authStore = useAuthStore();

const form = reactive({
  email: null,
  password: null,
});

const showPassword = ref(false);
</script>
