<template>
  <div>
    <q-card class="my-card" flat bordered>
      <q-card-section>
        <q-card-section class="col-4 text-uppercase text-center" vertical>
          <h3 class="text-5xl text-weight-bolder">Tue</h3>
          <!-- Day of the week -->
          <h4 class="text-xl text-weight-bold">
            <!-- Month -->
            <span class="block">August</span>
            <!-- Day -->
            <span class="block text-5xl text-weight-bolder">08</span>
            <!-- Year -->
            <span class="block">2024</span>
          </h4>
        </q-card-section>

        <q-card-section class="col justify-around q-px-md">
          <h3>Report Title</h3>
          <h4>Report Category</h4>

          <p>Report Content</p>

          <q-separator />
          <div>Report Footer</div>
        </q-card-section>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
defineProps({
  report: Object,
});
</script>
