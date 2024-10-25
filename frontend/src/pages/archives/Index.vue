<template>
  <PageHeader> Archives </PageHeader>

  <section class="row q-col-gutter-lg q-mt-sm">
    <ArchiveCard v-for="archive in archivesData" :key="archive.id" :archive />
  </section>
</template>

<script setup>
const { data: archivesData } = useQuery({
  queryKey: ["archives"],
});
</script>
