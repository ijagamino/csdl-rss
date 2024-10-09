<template>
  <!-- <template #header> Report #{{ report.id }} </template> -->
  <!-- <div class="mt-8 flex flex-wrap px-4 gap-8"> -->
  <!-- <ReportCard :report :startTime :endTime /> -->
  <div v-if="isLoading">Loading...</div>
  <div v-else-if="isError">Error: {{ error.message }}</div>
  <div v-else class="row">
    <ReportCard :report="reportData" />
  </div>
</template>

<script setup>
const route = useRoute();

const routeParams = computed(() => {
  return route.params;
});

const {
  data: reportData,
  error,
  isLoading,
  isError,
  refetch,
} = useQuery({
  queryKey: [`reports/${route.params.id}`],
});
</script>
