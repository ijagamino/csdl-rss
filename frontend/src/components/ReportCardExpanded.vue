<template>
  <div class="col-12 col-lg-6 col-xl-4 items-center">
    <q-card bordered>
      <q-expansion-item
        expand-separator
        default-opened
        label="More details"
        icon="info"
      >
        <q-card-section horizontal>
          <q-card-section class="col q-pt-xs">
            <div class="text-overline">{{ report.category }}</div>
            <div class="text-h5 q-mt-sm q-mb-xs">
              {{ edit.title }}
              <q-popup-edit
                v-model="edit.title"
                v-slot="scope"
                auto-save
                persistent
                buttons
                color="accent"
              >
                <q-input
                  v-model="scope.value"
                  dense
                  autofocus
                  counter
                  @keyup.enter="scope.set"
                />
              </q-popup-edit>
            </div>
            <div class="text-caption text-grey">{{ report.content }}</div>
          </q-card-section>

          <q-card-section>
            <VIcon
              name="check_circle"
              size="xl"
              v-if="report.appointment.status === 'approved'"
            />
            <VIcon
              name="pending"
              size="xl"
              v-if="report.appointment.status === 'pending'"
            />
          </q-card-section>
        </q-card-section>

        <q-separator />

        <!-- Expanded details -->
        <q-card-section>
          <div class="q-py-sm">
            <div class="text-subtitle2">Report Details</div>
            <div class="text-body1 q-mt-sm">
              <strong>Created At:</strong> {{ formatDate(report.created_at) }}
            </div>
            <div class="text-body1 q-mt-sm">
              <strong>Category:</strong> {{ report.category }}
            </div>
            <div class="text-body1 q-mt-sm">
              <strong>Content:</strong> {{ report.content }}
            </div>
          </div>
        </q-card-section>

        <q-separator />

        <q-card-section class="row justify-center">
          <q-btn flat :label="schedule" icon="event" color="primary" />
        </q-card-section>

        <q-separator />

        <q-card-actions class="row" align="between">
          <q-btn flat :label="schedule" icon="event" color="primary" />

          <q-space />

          <VButton
            v-if="
              can?.updateAppointments && report.appointment.status === 'pending'
            "
            @click="approveReport()"
            color="positive"
            >Approve</VButton
          >
          <VButton
            :to="{ name: 'reports.show', params: { id: report.id } }"
            label="Details"
          />
        </q-card-actions>
      </q-expansion-item>
    </q-card>
  </div>
</template>

<script setup>
const props = defineProps({
  report: { required: false, type: Object },
  can: { required: false, type: Object },
});

const $q = useQuasar();

const queryClient = useQueryClient();

const { isPending, isError, error, isSuccess, mutate } = useMutation({
  mutationFn: async () => {
    const response = await api.patch(
      `appointments/${props.report.appointment.id}`,
      {
        status: "approved",
      }
    );
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

const edit = reactive({
  category: props.report.category,
  title: props.report.title,
  content: props.report.content,
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
