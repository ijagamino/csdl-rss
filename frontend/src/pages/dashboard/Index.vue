<template>
  <PageHeader>Dashboard</PageHeader>
  <q-btn-group>
    <Button
      label="All"
      @click="$inertia.get(dashboardIndex)"
      :active="$page.url === '/dashboard'"
    />
    <Button
      label="Pending"
      @click="$inertia.get(`${dashboardIndex}?status=pending`)"
      :active="$page.url === '/dashboard?status=pending'"
    />
    <Button
      label="Approved"
      @click="$inertia.get(`${dashboardIndex}?status=approved`)"
      :active="$page.url === '/dashboard?status=approved'"
    />
  </q-btn-group>
  <section class="row q-col-gutter-lg q-mt-sm">
    <ReportCard
      class="col-12 col-md-6"
      v-for="report in reports"
      :key="report.id"
      :report
    />
  </section>
</template>

<script setup>
defineProps({
  reports: Object,
});
</script>
