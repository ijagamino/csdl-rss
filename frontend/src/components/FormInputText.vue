<template>
  <div>
    <label :for="id" v-text="label" />
    <input v-model="model" v-bind="$attrs" fluid />
    <div v-if="error" class="text-sm text-red-500" v-text="error"></div>
  </div>
</template>

<script setup>
const model = defineModel();
defineProps({
  id: String,
  label: String,
  error: String,
});
</script>
