<template>
  <div class="col-12 col-lg-6 col-xl-4 items-center">
    <q-card bordered>
      <q-card-section horizontal>
        <q-card-section class="col q-pt-xs">
          <div class="text-overline">{{ report.category }}</div>
          <div class="text-h5 q-mt-sm q-mb-xs">{{ report.title }}</div>
          <div class="text-caption text-grey">{{ report.content }}</div>
        </q-card-section>

        <q-card-section>
          <VIcon
            name="check_circle"
            size="xl"
            v-if="report.status === 'approved'"
          />
          <VIcon name="pending" size="xl" v-if="report.status === 'pending'" />
        </q-card-section>
      </q-card-section>

      <q-separator />

      <q-card-actions class="row" align="between">
        <q-btn flat round icon="event" />
        <q-btn flat :label="schedule" />
        <q-space />
          <VButton
            v-if="can.approve && report.status === 'pending'"
            @click="approveReport()"
            color="positive"
            >Approve</VButton
          >
          <VButton
            :to="{ name: 'reports.show', params: { id: report.id } }"
            label="Details"
          />
      </q-card-actions>
    </q-card>
  </div>
</template>

<script setup>
const props = defineProps({
  report: Object,
  can: Object,
});

const $q = useQuasar();

const queryClient = useQueryClient();

const { isPending, isError, error, isSuccess, mutate } = useMutation({
  mutationFn: async () => {
    const response = await api.patch(`reports/${props.report.id}/approve`, {
      status: "approved",
    });
    console.log(response);
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ["reports"] });
    $q.notify({
      message: "Report approved.",
      color: "positive",
    });
  },
});

function approveReport() {
  mutate();
}

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
