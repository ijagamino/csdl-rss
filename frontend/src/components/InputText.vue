<template>
  <q-input
    filled
    v-model="model"
    lazy-rules
    :rules="[(val) => (val && val.length > 0) || 'Please type something']"
  >
    <slot />
  </q-input>
</template>

<script setup>
const model = defineModel();
</script>
