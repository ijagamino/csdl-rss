<template>
  <PageHeader> Reports </PageHeader>
  <q-btn-group outline>
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
  <div v-if="isLoading">
    <q-spinner size="xl" color="primary" />
    <p>Loading reports...</p>
  </div>
  <span v-if="isLoading">Loading...</span>
  <section v-else-if="isError">
    <q-banner type="negative">
      <q-icon name="error" />
      Error loading reports: {{ error.message }}
    </q-banner>
  </section>
  <section v-else>
    <q-pagination
      class="q-mt-md"
      v-model="currentPage"
      :max="reportsData.reports.last_page"
      :max-pages="6"
      outline
      color="accent"
      direction-links
      :to-fn="queryPage"
    />
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
const router = useRouter();
const route = useRoute();

// needed in order to trigger a refetch when urlchanges
const routeQuery = computed(() => {
  return route.query;
});

const routeQueryPage = computed(() => {
  return route.query.page;
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

const prevPage = computed(() => {
  return reportsData.value.reports.prev_page_url;
});
//
const nextPage = computed(() => {
  return reportsData.value.reports.next_page_url;
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

const queryPage = (page) => {
  return {
    path: route.path,
    query: {
      ...route.query,
      page,
    },
  };
};
const routePage = computed(() => {
  return Number(route.query.page) || 1;
});

const currentPage = ref(routePage); // Tracks the current page
const perPage = ref(10); // Items per page
const totalPages = ref(1); // Total number of pages
const totalItems = ref(0); // Total items from the API
</script>
