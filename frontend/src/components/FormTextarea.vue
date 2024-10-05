<template>
  <div>
    <Textarea v-bind="$attrs" rows="5" fluid />
    <div v-if="error" class="block text-sm text-red-500" v-text="error"></div>
  </div>
</template>

<script setup>
defineOptions({
  inheritAttrs: false,
});

defineProps({
  label: String,
  id: String,
  error: String,
});
</script>
