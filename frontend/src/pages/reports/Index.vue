<template>
  <PageHeader> Reports </PageHeader>
  <q-btn-group>
    <q-btn to="?" label="All" />
    <q-btn to="?status=pending" label="Pending" />
    <q-btn to="?status=approved" label="Approved" />
  </q-btn-group>
  <div v-if="isLoading">
    <q-spinner size="xl" color="primary" />
    <p>Loading reports...</p>
  </div>

  <section v-else-if="isError">
    <q-banner type="negative">
      <q-icon name="error" />
      Error loading reports: {{ error.message }}
    </q-banner>
  </section>

  <section v-else class="row q-col-gutter-lg q-mt-sm">
    <ReportCard v-for="report in reportsData" :key="report.id" :report />
  </section>
  <div
    @click="
      () => {
        const ewan = refetch();
        console.log(ewan);
      }
    "
  ></div>
</template>

<script setup>
const route = useRoute();

const {
  data: reportsData,
  error,
  isLoading,
  isError,
  refetch,
} = useQuery({
  queryKey: ["reports", route.query],
});
</script>
