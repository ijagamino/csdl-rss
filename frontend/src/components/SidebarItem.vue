<template>
  <q-item clickable v-ripple active-class="bg-accent text-primary">
    <q-item-section avatar v-if="icon">
      <q-avatar :icon :color="iconBackground" :text-color="iconColor" />
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
  iconBackground: {
    type: String,
    default: "accent",
  },
  iconColor: {
    type: String,
    default: "primary",
  },
});
</script>
