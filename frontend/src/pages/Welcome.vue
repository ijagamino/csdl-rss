<template>
  <div class="row q-col-gutter-lg justify-center">
    <div class="text-center col-12 col-lg-6 row justify-center">
      <div class="col-12 circle-container q-ma-xl">
        <div class="circle-border"></div>
        <img src="~assets/lp1.png" class="circle-item" />
        <img src="~assets/lp2.png" class="circle-item" />
        <img src="~assets/lp3.png" class="circle-item" />
        <img src="~assets/lp4.png" class="circle-item" />
        <img src="~assets/lp5.png" class="circle-item" />
      </div>
      <header class="col-12 text-uppercase">
        <h1 class="text-h4">CSDL</h1>
        <h2 class="text-h5">Report & Support System</h2>
      </header>
      <div class="col-12 justify-between">
        <p class="text-subtitle1">
          Effortlessly report your concerns with the CSDL Report and Support
          System. Select a category, submit your details, and our platform
          organizes your request, schedules meetings, and keeps you informed.
          Get the support you need efficiently and safely. Connect with CSDL
          today
        </p>

        <div class="row justify-center">
          <div class="col-12 col-md-6">
            <VButton
              class="full-width"
              :to="{ name: 'reports.create' }"
              size="xl"
              label="start"
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

<style scoped>
.circle-container {
  position: relative;
  width: 300px; /* Adjust the size as needed */
  height: 300px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.circle-border {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 2px dashed #555; /* Circle Path with dashed border */
  position: absolute;
  z-index: 0; /* Ensures the circle is behind the images */
}

.circle-item {
  position: absolute;
  width: 80px; /* Size of each image */
  height: 80px;
  border-radius: 50%; /* Makes each image circular */
  z-index: 1; /* Places images above the border */
}

.circle-item:nth-child(2) {
  top: 0;
  left: 50%;
  transform: translate(-50%, -50%);
}

.circle-item:nth-child(3) {
  top: 50%;
  left: 100%;
  transform: translate(-50%, -50%);
}

.circle-item:nth-child(4) {
  top: 100%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.circle-item:nth-child(5) {
  top: 50%;
  left: 0;
  transform: translate(-50%, -50%);
}

.circle-item:nth-child(6) {
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(45deg);
}
</style>
