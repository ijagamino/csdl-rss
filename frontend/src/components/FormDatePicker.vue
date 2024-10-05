<template>
  <div>
    <label :for="id" v-text="label" />
    <DatePicker :id v-bind="$attrs" fluid />
    <span class="text-sm italic text-red-500" v-if="error" v-text="error" />
  </div>
</template>

<script setup>
defineOptions({
  inheritAttrs: false,
});

defineProps({
  id: String,
  label: String,
  error: String,
});
</script>
