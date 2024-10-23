<template>
  <q-pagination
    class="q-mt-md"
    v-model="model"
    :max-pages="6"
    outline
    color="accent"
    direction-links
    :to-fn="queryPage"
  />
</template>

<script setup>
const model = defineModel();
const route = useRoute();

const queryPage = (page) => {
  return {
    path: route.path,
    query: {
      ...route.query,
      page,
    },
  };
};
</script>
