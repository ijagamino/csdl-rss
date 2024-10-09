<template>
  <PageHeader>Schedules</PageHeader>

  <section class="row q-col-gutter-lg q-mt-sm">
    <AppointmentCard
      v-for="appointment in appointmentsData"
      :key="appointment.id"
      :appointment
    />
  </section>
</template>

<script setup>
const { categories } = useCategory();

const {
  data: appointmentsData,
  error,
  isLoading,
  isError,
  refetch,
} = useQuery({
  queryKey: ["appointments"],
});
</script>
