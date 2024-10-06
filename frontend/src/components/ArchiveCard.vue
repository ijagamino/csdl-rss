<template>
  <Card
    class="min-w-48 max-w-64 flex aspect-square"
    v-bind:key="report.id"
    :pt="{
      body: 'grow',
      footer: 'mt-auto flex items-center justify-between',
    }"
  >
    <template #header>
      <img src="https://placehold.co/400" alt="" />
    </template>
    <template #title> {{ report.title }} </template>
    <template #subtitle> {{ report.category }} </template>

    <template #content>
      <p class="line-clamp-3">{{ report.content }}</p>
    </template>

    <template #footer>
      <Button
        :href="route('archives.show', report)"
        label="Details"
        :as="Link"
      />
      <Icon
        class="pi-trash border-2 rounded-full p-2"
        v-if="report.status === 'completed'"
      />
    </template>
  </Card>
</template>

<script setup>
defineProps({
  report: Object,
});
</script>
