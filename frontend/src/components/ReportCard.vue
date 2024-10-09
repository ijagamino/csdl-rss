<template>
  <div class="col-12 col-lg-6 col-xl-4 items-center">
    <q-card bordered>
      <q-card-section horizontal>
        <q-card-section class="col q-pt-xs">
          <div class="text-overline">{{ report.category }}</div>
          <div class="text-h5 q-mt-sm q-mb-xs">{{ report.title }}</div>
          <div class="text-caption text-grey">{{ report.content }}</div>
        </q-card-section>

        <q-card-section class="col-4 flex flex-center">
          <v-icon
            name="check_circle"
            size="xl"
            v-if="report.status === 'approved'"
          />
          <v-icon name="pending" size="xl" v-if="report.status === 'pending'" />
        </q-card-section>
      </q-card-section>

      <q-separator />

      <q-card-actions align="between">
        <div>
          <q-btn flat round icon="event" />
          <q-btn flat :label="schedule" />
        </div>
        <!-- <Link to="reports" v-if="!appointment"> -->
        <q-btn
          :to="{ name: 'reports.show', params: { id: report.id } }"
          color="primary"
          label="Details"
        />
        <!-- </Link> -->
      </q-card-actions>
    </q-card>
  </div>
</template>

<script setup>
const props = defineProps({
  report: Object,
  startTime: Object,
  endTime: Object,
});

const { formatDate, formatTime } = useDate();

const schedule = computed(() => {
  if (!props.report.appointment) {
    return;
  }
  return `${formatTime(props.report.appointment?.start_time)} - ${formatTime(
    props.report.appointment?.end_time
  )}`;
});
</script>
