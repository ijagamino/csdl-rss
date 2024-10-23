<template>
  <q-input
    v-model="model"
    color="accent"
    bottom-slots
    hint=""
    :error-message="errorMessage"
  >
    <template #prepend>
      <slot name="prepend" />
    </template>
    <template #append>
      <slot name="append" />
    </template>
  </q-input>
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
