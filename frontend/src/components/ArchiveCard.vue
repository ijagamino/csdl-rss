<template>
  <div class="col-12 col-lg-6 col-xl-4">
    <q-card bordered>
      <q-responsive :ratio="2 / 1">
        <q-img src="http://placehold.co/40" />
      </q-responsive>

      <q-card-section>
        <div class="text-h5 q-mt-sm q-mb-xs">{{ archive.report.title }}</div>
        <div class="text-caption">
          {{ archive.report.content }}
        </div>
      </q-card-section>

      <q-card-actions>
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
