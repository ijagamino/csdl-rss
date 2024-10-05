<template>
  <Head title="Dashboard" />
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
  <section class="row q-mt-sm q-col-gutter-lg">
    <ReportCard
      class="col-12 col-md-6"
      v-for="report in reports"
      v-bind:key="report.id"
      :report
    />
  </section>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import { computed } from "vue";

const dashboardIndex = computed(() => route("dashboard.index"));

defineProps({
  reports: Object,
});
</script>
