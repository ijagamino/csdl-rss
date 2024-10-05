<template>
  <Head title="Register" />
  <!-- <FormPanel @submit.prevent="submit()"> -->
  <FormInput
    id="email"
    label="Email"
    v-model="form.email"
    :error="form.errors.email"
  />
  <FormInput
    id="username"
    label="Username"
    v-model="form.username"
    :error="form.errors.username"
  />
  <FormInput
    id="password"
    label="Password"
    v-model="form.password"
    type="password"
    :error="form.errors.password"
  />
  <FormInput
    id="password_confirmation"
    label="Confirm password"
    v-model="form.password_confirmation"
    type="password"
    :error="form.errors.password_confirmation"
  />
  <ButtonElevated class="rounded border py-2 px-4 mt-4"
    >Register</ButtonElevated
  >
  <!-- </FormPanel> -->
</template>

<script setup>
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
  email: null,
  username: null,
  password: null,
  password_confirmation: null,
});

const submit = () => {
  form.post("/register");
};
</script>
