<template>
  <q-item v-close-popup clickable>
    <q-item-section avatar>
      <q-avatar :icon text-color="accent" />
    </q-item-section>
    <q-item-section>
      <q-item-label>
        {{ label }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
const props = defineProps({
  label: String,
  icon: String,
});
</script>
