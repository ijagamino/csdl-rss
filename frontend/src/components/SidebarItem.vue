<template>
  <Link :href>
    <q-item clickable v-ripple>
      <q-item-section avatar v-if="icon">
        <q-avatar :icon :color="iconBackground" :text-color="iconColor" />
      </q-item-section>

      <q-item-section>{{ label }}</q-item-section>
    </q-item>
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";

defineOptions({
  inheritAttrs: false,
});

const props = defineProps({
  href: String,
  label: String,
  active: Boolean,
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

// const classes = computed(() => ({
//   "bg-primary ": props.active,
// }));
</script>
