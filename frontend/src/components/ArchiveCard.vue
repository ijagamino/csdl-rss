<template>
  <div class="col-12 col-lg-6 col-xl-4">
    <q-card bordered>
      <q-img src="https://cdn.quasar.dev/img/parallax2.jpg" />

      <q-card-section>
        <div class="text-h5 q-mt-sm q-mb-xs">{{ archive.report.title }}</div>
        <div class="text-caption text-grey">
          {{ archive.report.content }}
        </div>
      </q-card-section>

      <q-card-actions>
        <q-btn flat color="primary" label="Share" />
        <q-btn flat color="secondary" label="Book" />

        <q-space />

        <q-btn
          color="grey"
          round
          flat
          dense
          :icon="expanded ? 'keyboard_arrow_up' : 'keyboard_arrow_down'"
          @click="expanded = !expanded"
        />
      </q-card-actions>

      <q-slide-transition>
        <div v-show="expanded">
          <q-separator />
          <q-card-section class="text-subtitle2">
            Processed by: {{ fullName }}
          </q-card-section>
        </div>
      </q-slide-transition>
    </q-card>
  </div>
</template>

<script setup>
const props = defineProps({
  archive: Object,
});

const fullName = computed(() => {
  return `${props.archive.user.first_name} ${props.archive.user.last_name}`;
});

const expanded = ref(false);
</script>
