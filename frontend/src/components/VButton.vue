<template>
  <q-btn rounded color="accent" :outline="inactive" :active>
    <slot />
  </q-btn>
</template>

<script setup>
const props = defineProps({
  active: Boolean,
  inactive: Boolean,
});
</script>
