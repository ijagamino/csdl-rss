<template>
  <q-btn color="primary" :class="classes" :active v-bind="$attrs" />
</template>

<script setup>
import { computed } from "vue";

defineOptions({
  inheritAttrs: false,
});

const props = defineProps({
  active: Boolean,
});

const classes = computed(() => ({
  "bg-dark": props.active,
}));
</script>
