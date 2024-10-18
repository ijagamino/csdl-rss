<template>
  <q-item
    v-for="listItem in listItems"
    :key="listItem.label"
    :to="{ name: listItem.name }"
    v-ripple
    clickable
    active-class="bg-accent text-primary"
  >
    <q-item-section v-if="listItem.icon" avatar>
      <q-avatar :icon="listItem.icon" color="accent" text-color="primary" />
    </q-item-section>

    <q-item-section>
      <q-item-label lines="1">
        {{ listItem.label }}
      </q-item-label>
      <q-item-label v-if="listItem.caption" lines="1" caption>
        {{ listItem.caption }}
      </q-item-label>
    </q-item-section>
  </q-item>
</template>

<script setup>
const props = defineProps({
  listItems: {
    type: Array,
    default: () => [],
  },
});
</script>
