<template>
  <Head title="Schedules" />
  <PageHeader>Schedules</PageHeader>

  <q-select
    label="Choose a category"
    :options="options"
    v-model="search"
    @change="searchInput"
  />

  <section class="row">
    <ScheduleCard class="col-lg-6" />
  </section>

  <Card
    class="min-w-96 aspect-[2/1] grid grid-cols-3 max-w-lg grow"
    :pt="{
      header: 'uppercase p-5 content-center text-center',
      body: 'col-span-2',
      footer: 'mt-auto font-semibold',
    }"
  >
    <template #header> </template>
    <template #title> Report Title </template>
    <template #subtitle> Report Category </template>
    <template #content>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
    </template>
    <template #footer>
      <footer>Appointed time: 1:00 PM</footer>
    </template>
  </Card>

  <!-- Month, year per section-->
  <section class="mt-4"></section>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

const options = ["Name 1", "Name 2"];

const search = ref(null);

const searchInput = () => {
  console.log(search.value);
};
</script>
