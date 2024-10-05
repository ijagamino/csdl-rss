<template>
  <Head title="Archives" />
  <PageHeader> Archives </PageHeader>

  <q-input
    filled
    placeholder="Search..."
    type="text"
    v-model="search"
    @keyup="searchInput"
  >
    <template #prepend>
      <Icon name="search" />
    </template>
  </q-input>
  <section class="mt-6 justify-center flex flex-wrap gap-2">
    <ArchiveCard v-for="report in reports" :key="report.id" :report />
    <!-- <ArchiveCard /> -->
    <!-- <ArchiveCard /> -->
    <!-- <ArchiveCard /> -->
    <!-- <ArchiveCard /> -->
  </section>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
  reports: Object,
});

const search = ref(null);
</script>
