<template>
  <q-input v-model="model" bottom-slots hint="" :error-message="errorMessage" />
</template>

<script setup>
const model = defineModel();

const errorMessage = computed(() => {
  if (!props.errors) {
    return;
  }
  return props.errors.length > 0 ? props.errors.join(" ") : "";
});

const props = defineProps({
  errors: Array,
});
</script>
