<template>
  <q-item clickable v-ripple active-class="bg-teal-1 text-grey-8">
    <q-item-section avatar v-if="icon">
      <q-avatar :icon :color="iconBackground" :text-color="iconColor" />
    </q-item-section>

    <q-item-section>{{ label }}</q-item-section>
  </q-item>
</template>

<script setup>
const props = defineProps({
  label: String,
  icon: String,
  iconBackground: {
    type: String,
    default: "primary",
  },
  iconColor: {
    type: String,
    default: "white",
  },
});
</script>
