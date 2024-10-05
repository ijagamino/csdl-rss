<template>
  <section class="mx-auto">
    <img src="https://placehold.co/600x400" alt="" />
  </section>

  <header class="mt-12">
    <h1 class="uppercase text-4xl text-center font-bold">
      <span class="block">CSDL</span>
      <span class="block">Report & Support System</span>
    </h1>

    <p class="mt-8 block text-center">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem non
      vel quidem?
    </p>
  </header>

  <div class="mt-12 flex flex-col font-bold text-xl lg:flex-row gap-4">
    <VButton
      class="w-full bg-gradient-to-r from-primary-200 to-primary-900 text-white uppercase font-bold border-2 border-black text-xl"
      label="start"
    />

    <VButton
      @click="getMessageWithAxios()"
      label="Later"
      class="w-full bg-primary-200"
    />
  </div>
</template>

<script setup>
import { api } from "boot/axios";

const getMessageWithAxios = () => {
  api.get("/get-message").then((response) => {
    alert(response.data.message);
  });
};
</script>
