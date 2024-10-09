<template>
  <div>
    <div v-for="report in reports" :key="report.id">
      {{ report }}
    </div>
    <q-btn @click="getReports">Click to get reports</q-btn>
  </div>
</template>

<script setup>
// const { data } = await api.get("reports");
// await new Promise((resolve) => setTimeout(resolve, 2000));
// const reports = ref(data);

// const getReports = async () => {
//   try {
//     const { data } = await api.get("reports");
//     await new Promise((resolve) => setTimeout(resolve, 1000));
//     reports.value = data.reports;
//   } catch (error) {
//     console.error(error);
//   }
// };

// onMounted(() => {
//   return getReports();
// });
</script>
