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
              name="pending"
              size="xl"
            />
            <VIcon
              v-if="report.appointment?.status === 'approved'"
              name="check_circle"
              size="xl"
              color="positive"
            />
            <VIcon
              v-if="report.appointment?.status === 'cancelled'"
              name="cancel"
              size="xl"
              color="negative"
            />
          </q-card-section>
        </q-card-section>
      </q-card-section>

      <q-separator />

      <q-card-actions>
        <VButton
          v-if="
            report.appointment.status === 'pending' ||
            report.appointment.status === 'approved'
          "
          icon="event"
          flat
          :label="schedule"
        />
        <VButton v-else label="Set schedule" icon="event" flat>
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
                  @click="add()"
                  label="OK"
                  color="positive"
                  v-close-popup
                />
              </div>
            </q-date>
          </q-popup-proxy>
        </VButton>

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
            <div class="text-h5">{{ fullDate }}</div>
            <div class="text-overline">{{ report.category }}</div>
            <div class="text-caption">{{ report.content }}</div>
          </q-card-section>
          <q-card-actions align="right">
            <VButton
              v-if="
                can?.approveAppointments &&
                report.appointment?.status === 'pending'
              "
              @click="approveAppointment()"
              color="positive"
              label="Approve"
            />
            <VButton
              v-if="
                can?.cancelAppointments &&
                report.appointment?.status === 'pending'
              "
              @click="cancelAppointment()"
              color="negative"
              label="cancel"
            />
          </q-card-actions>
        </div>
      </q-slide-transition>
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
});

const {
  dateOptions,
  availableTimeSlots,
  isLoadingTimeSlots,
  isErrorTimeSlots,
  errorTimeSlots,
  isLoadingTakenTimeSlots,
  isErrorTakenTimeSlots,
  errorTakenTimeSlots,
  add,
} = useDatePicker("appointments", form);

const expanded = ref(false);

// changes appointment status to "approved"
const { isPending, isError, error, isSuccess, mutate } = useMutation({
  mutationFn: async () => {
    const response = await api.patch(
      `appointments/${props.report.appointment?.id}`,
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
      message: "Appointment approved.",
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
  mutate();
}

function cancelAppointment() {
  mutateCancel();
}

const schedule = computed(() => {
  if (!props.report.appointment) {
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
