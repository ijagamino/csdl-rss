<template>
  <div class="text-center">
    <div class="row q-col-gutter-lg justify-center">
      <div class="col-12 col-md-6 justify-center">
        <q-img src="https://placehold.co/600x400" alt="" />
      </div>

      <div class="column col-12 col-md-6 justify-between">
        <header class="text-uppercase">
          <h1 class="text-h4">
            <span class="block">CSDL</span>
          </h1>

          <h2 class="text-h5">
            <span class="block">Report & Support System</span>
          </h2>
        </header>

        <p class="text-subtitle1">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem
          non vel quidem?
        </p>

        <div class="row q-col-gutter-lg">
          <div class="col-12 col-md-6">
            <VButton class="full-width" label="start" />
          </div>

          <div class="col-12 col-md-6">
            <VButton
              class="full-width"
              @click="getMessageWithAxios()"
              label="Later"
              color="secondary"
            />
          </div>
        </div>
      </div>
    </div>
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
