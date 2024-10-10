<template>
  <PageHeader>Schedules</PageHeader>

  <section v-if="isLoading">
    <q-banner>
      <q-spinner size="xl" color="accent" />
      <p>Loading appointments...</p>
    </q-banner>
  </section>

  <section v-else-if="isError">
    <q-banner type="negative">
      <q-icon name="error" />
      Error loading appointments: {{ error.message }}
    </q-banner>
  </section>
  <section v-else>
    <VPagination
      v-model="currentPage"
      :max="appointmentsData?.appointments.last_page"
    />
    <div class="row q-col-gutter-lg q-mt-sm">
      <AppointmentCard
        v-for="appointment in appointmentsData.appointments.data"
        :key="appointment.id"
        :appointment
      />
    </div>
  </section>
</template>

<script setup>
const { categories } = useCategory();
const route = useRoute();

const routeQuery = computed(() => {
  return route.query;
});

const {
  data: appointmentsData,
  error,
  isLoading,
  isError,
  refetch,
} = useQuery({
  queryKey: ["appointments", routeQuery],
});

const routePage = computed(() => {
  return Number(route.query.page) || 1;
});

const currentPage = ref(routePage);
</script>
