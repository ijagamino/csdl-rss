<template>
  <Head title="Archives" />
    <PageHeader> Archives </PageHeader>

    <input
      class="w-full rounded-full border-2 border-black px-3 py-1.5"
      placeholder="Search..."
      type="text"
      v-model="search"
      @keyup="searchInput"
    />
    <section class="mt-6 justify-center flex flex-wrap gap-2">
      <ArchiveCard :report :appointments :startTime :endTime />
    </section>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import ArchiveCard from "@/components/ArchiveCard.vue";

defineProps({
  report: Object,
});

const search = ref(null);

const searchInput = () => {
  console.log(search.value);
};
</script>
