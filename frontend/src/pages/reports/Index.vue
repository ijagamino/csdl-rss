<template>
  <PageHeader> Reports </PageHeader>

  <q-btn-group class="q-mb-sm" outline>
    <VButton :inactive="$route.query.status?.length > 0" to="?" label="All" />
    <VButton
      :inactive="$route.query.status !== 'pending'"
      :to="queryStatus('pending')"
      label="Pending"
    />
    <VButton
      :inactive="$route.query.status !== 'approved'"
      :to="queryStatus('approved')"
      label="Approved"
    />
  </q-btn-group>

  <section v-if="isLoading">
    <q-banner>
      <q-spinner size="xl" color="accent" />
      <p>Loading reports...</p>
    </q-banner>
  </section>

  <section v-else-if="isError">
    <q-banner type="negative">
      <q-icon name="error" />
      Error loading reports: {{ error.message }}
    </q-banner>
  </section>

  <section v-else>
    <VPagination v-model="currentPage" :max="reportsData.reports.last_page" />
    <div class="row q-col-gutter-lg q-mt-sm">
      <ReportCard
        v-for="report in reportsData.reports.data"
        :key="report.id"
        :report="report"
        :can="reportsData.can"
      />
    </div>
  </section>
</template>

<script setup>
const route = useRoute();

// needed in order to trigger a refetch when urlchanges
const routeQuery = computed(() => {
  return route.query;
});

const {
  data: reportsData,
  error,
  isFetching,
  isLoading,
  isError,
} = useQuery({
  queryKey: ["reports", routeQuery],
});

const queryStatus = (status) => {
  return {
    path: route.path,
    query: {
      ...route.query,
      status,
    },
  };
};

const routePage = computed(() => {
  return Number(route.query.page) || 1;
});

const currentPage = ref(routePage);
</script>
