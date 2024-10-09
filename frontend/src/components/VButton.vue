<template>
  <q-btn rounded color="primary" :class="classes" :active>
    <slot />
  </q-btn>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  active: Boolean,
});

const classes = computed(() => ({
  "bg-dark": props.active,
}));
</script>
