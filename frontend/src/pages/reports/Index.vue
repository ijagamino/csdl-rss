<template>
  <PageHeader> Reports </PageHeader>
  <p>Hello, reports!</p>
  <q-btn @click="getReports">Click to get reports</q-btn>
</template>

<script setup>
const getReports = async () => {
  try {
    const reports = await api.get("reports");
    console.log(reports);
  } catch (error) {
    console.error(error);
  }
};
</script>
