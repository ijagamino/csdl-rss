<template>
  <PageHeader> Reports </PageHeader>
  <q-btn-dropdown
    class="mobile-only"
    color="accent"
    label="Filter by status"
    menu-anchor="bottom start"
    menu-self="top start"
  >
    <q-list>
      <DropdownItem :to="queryStatus('')" icon="folder" label="All" />
      <DropdownItem
        :to="queryStatus('pending')"
        icon="hourglass_top"
        label="Pending"
      />
      <DropdownItem
        :to="queryStatus('approved')"
        icon="check"
        label="Approved"
      />
      <DropdownItem
        :to="queryStatus('cancelled')"
        icon="block"
        label="Cancelled"
      />
    </q-list>
  </q-btn-dropdown>

  <section class="row justify-between">
    <div>
      <q-btn-group class="mobile-hide q-mb-sm" outline>
        <VButton
          :inactive="$route.query.status?.length > 0"
          to="?"
          label="All"
        />
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
        <VButton
          :inactive="$route.query.status !== 'cancelled'"
          :to="queryStatus('cancelled')"
          label="Cancelled"
        />
      </q-btn-group>
    </div>

    <div>
      <VButton
        class="mobile-hide"
        :to="{ name: 'reports.create' }"
        icon="add"
        :rounded="false"
        size="xl"
      />
    </div>
  </section>

  <section v-if="isLoading">
    <q-banner>
      <q-spinner size="xl" color="accent" />
      <p>Loading reports...</p>
    </q-banner>
  </section>

  <section v-else-if="isError">
    <q-banner type="negative">
      <VIcon name="error" />
      Error loading reports: {{ error.message }}
    </q-banner>
  </section>

  <section v-else>
    <div v-if="!reportsData.reports.data">No reports found</div>
    <div v-else-if="!reportsData.reports.data.length">No reports found</div>
    <div v-else>
      <VPagination v-model="currentPage" :max="reportsData.reports.last_page" />
      <div class="row q-col-gutter-lg q-mt-sm">
        <ReportCard
          v-for="report in reportsData.reports.data"
          :key="report.id"
          :report="report"
          :can="reportsData.can"
        />
      </div>
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
