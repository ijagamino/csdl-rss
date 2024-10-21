<template>
  <div class="col-12 col-lg-6 col-xl-4 items-center">
    <q-card bordered>
      <q-card-section horizontal>
        <q-card-section class="col" horizontal>
          <q-card-section>
            <div class="text-h5 q-mt-sm q-mb-xs">{{ report.title }}</div>
          </q-card-section>
          <q-space />
          <q-card-section>
            <VIcon
              v-if="report.appointment?.status === 'pending'"
              name="hourglass_top"
              size="xl"
            />
            <VIcon
              v-if="report.appointment?.status === 'approved'"
              name="check"
              size="xl"
              color="positive"
            />
            <VIcon
              v-if="report.appointment?.status === 'cancelled'"
              name="block"
              size="xl"
              color="negative"
            />
          </q-card-section>
        </q-card-section>
      </q-card-section>

      <q-separator />

      <q-card-actions>
        <VButton
          v-if="report.appointment.status === 'cancelled'"
          label="Set schedule"
          icon="event"
          flat
        >
          <q-popup-proxy cover transition-show="scale" transition-hide="scale">
            <q-date
              v-model="form.date"
              :navigation-min-year-month="minDate"
              :navigation-max-year-month="maxDate"
              :options="dateOptions"
              minimal
              color="accent"
            >
              <FormSelect
                class="col-12 col-md-6"
                v-model="form.time"
                :loading="isLoadingTakenTimeSlots"
                label="Time"
                placeholder="Choose a time"
                :disable="!availableTimeSlots || isLoadingTakenTimeSlots"
                :hint="!form.date ? 'Choose a date first' : ''"
                :options="availableTimeSlots"
                optionLabel="label"
                optionValue="label"
                optionDisabled="disabled"
              />
              <div class="row items-center justify-end q-gutter-sm">
                <VButton label="Cancel" color="negative" v-close-popup />
                <VButton
                  @click="update()"
                  label="OK"
                  color="positive"
                  v-close-popup
                />
              </div>
            </q-date>
          </q-popup-proxy>
        </VButton>
        <VButton v-else color="positive" icon="event" flat :label="schedule" />

        <q-space />

        <VButton
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
          <q-card-section>
            <div class="text-h5">
              {{
                report.appointment.status === "cancelled"
                  ? "No schedule set"
                  : fullDate
              }}
            </div>
            <div class="text-overline">{{ report.category }}</div>
            <div class="text-caption">{{ report.content }}</div>
          </q-card-section>
          <q-card-actions align="right">
            <VButton
              v-if="
                authStore.can?.approveAppointments &&
                report.appointment?.status === 'pending'
              "
              @click="approveAppointment()"
              color="positive"
              label="Approve"
            />
            <VButton
              v-if="
                authStore.can?.completeAppointments &&
                report.appointment?.status === 'approved'
              "
              @click="completeAppointment()"
              color="positive"
              label="Complete"
            />
            <VButton
              v-if="
                authStore.can?.cancelAppointments &&
                report.appointment?.status === 'pending'
              "
              @click="confirmCancelAppointment()"
              color="negative"
              label="cancel"
            />
            <VButton
              v-if="
                authStore.can?.deleteReports &&
                report.appointment?.status === 'cancelled'
              "
              @click="deleteAppointment()"
              color="negative"
              label="Delete"
            />
          </q-card-actions>
        </div>
      </q-slide-transition>
    </q-card>

    <q-dialog v-model="showDialog" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <q-icon name="warning" color="negative" size="2em" />
          <span>Are you sure you want to delete this item?</span>
        </q-card-section>

        <q-card-actions align="right">
          <VButton label="Cancel" color="positive" v-close-popup />
          <VButton
            label="Confirm"
            color="negative"
            v-close-popup
            @click="cancelAppointment()"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script setup>
const props = defineProps({
  report: { required: false, type: Object },
});

const $q = useQuasar();
const authStore = useAuthStore();
const queryClient = useQueryClient();

const showDialog = ref(false);

const {
  today,
  tomorrow,
  oneMonthFromNow,
  minDate,
  maxDate,
  formatDate,
  formatTime,
} = useDate();

const form = reactive({
  date: null,
  time: null,
  status: "pending",
});

const {
  dateOptions,
  availableTimeSlots,
  timeSlotsData,
  errorTimeSlots,
  isLoadingTimeSlots,
  isErrorTimeSlots,
  takenTimeSlotsData,
  errorTakenTimeSlots,
  isLoadingTakenTimeSlots,
  isErrorTakenTimeSlots,
  refetchTakenTimeSlots,
  add,
  update,
} = useDatePicker(
  "appointments",
  form,
  `appointments/${props.report.appointment.id}`
);

const expanded = ref(false);

// changes appointment status to "approved"
const {
  isPending: isPendingApprove,
  isError: isErrorApprove,
  error: errorApprove,
  isSuccess: isSuccessApprove,
  mutate: mutateApprove,
} = useMutation({
  mutationFn: async () => {
    const response = await api.patch(
      `appointments/${props.report.appointment?.id}`,
      {
        date: props.report.appointment?.date,
        start_time: props.report.appointment?.start_time,
        end_time: props.report.appointment?.end_time,
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
      message: "Appointment approved.",
      color: "positive",
    });
  },
});

// changes appointment status to "completed"
const {
  isPending: isPendingComplete,
  isError: isErrorComplete,
  error: errorComplete,
  isSuccess: isSuccessComplete,
  mutate: mutateComplete,
} = useMutation({
  mutationFn: async () => {
    const response = await api.patch(
      `appointments/${props.report.appointment?.id}`,
      {
        date: props.report.appointment?.date,
        start_time: props.report.appointment?.start_time,
        end_time: props.report.appointment?.end_time,
        status: "completed",
      }
    );
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ["reports"] });
    $q.notify({
      message: "Report completed, moved to archives.",
      color: "positive",
    });
  },
});

// changes appointment status to "cancelled"
const {
  isPending: isPendingCancel,
  isError: isErrorCancel,
  error: errorCancel,
  isSuccess: isSuccessCancel,
  mutate: mutateCancel,
} = useMutation({
  mutationFn: async () => {
    const response = await api.patch(
      `appointments/${props.report.appointment?.id}`,
      {
        status: "cancelled",
      }
    );
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ["reports"] });
    $q.notify({
      message: "Appointment cancelled.",
      color: "negative",
    });
  },
});

function approveAppointment() {
  mutateApprove();
}

function completeAppointment() {
  mutateComplete();
}

const confirmCancelAppointment = () => {
  showDialog.value = true;
};
function cancelAppointment() {
  mutateCancel();
}

const {
  isPending: isPendingDelete,
  isError: isErrorDelete,
  error: errorDelete,
  isSuccess: isSuccessDelete,
  mutate: mutateDelete,
} = useMutation({
  mutationFn: async () => {
    const response = await api.delete(
      `reports/${props.report.appointment?.id}`
    );
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ["reports"] });
    $q.notify({
      message: "Report deleted.",
      color: "negative",
    });
  },
});

function deleteReport() {
  mutateDelete();
}

const schedule = computed(() => {
  if (!props.report.appointment) {
    return;
  }
  if (
    !props.report.appointment.start_time ||
    !props.report.appointment.end_time
  ) {
    return;
  }
  return `${formatTime(props.report.appointment?.start_time)} - ${formatTime(
    props.report.appointment?.end_time
  )}`;
});

const date = computed(() => {
  return formatDate(props.report.appointment?.date);
});

const fullDate = computed(() => {
  if (!props.report.appointment) {
    return;
  }
  return `${date.value.month} ${date.value.day}, ${date.value.year}`;
});
</script>
