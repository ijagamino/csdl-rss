<template>
  <PageHeader> Archives </PageHeader>

  <FormInput
    placeholder="Search..."
    type="text"
    v-model="search"
    @keyup="searchInput"
  >
    <template #prepend>
      <VIcon name="search" />
    </template>
  </FormInput>
  <section class="row q-col-gutter-lg q-mt-sm">
    <ArchiveCard v-for="archive in archivesData" :key="archive.id" :archive />
  </section>
</template>

<script setup>
const { data: archivesData } = useQuery({
  queryKey: ["archives"],
});

const search = ref(null);
</script>
