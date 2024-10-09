<template>
  <PageHeader> Reporting </PageHeader>
  <q-form>
    <FormSelect
      v-model="form.category"
      placeholder="Choose a category"
      label="Choose a category"
      :options="categories"
      :error="!!errors.category"
      :errors="errors.category"
    />
    <FormInput
      v-model="form.title"
      label="Title"
      placeholder="Write the title..."
      :error="!!errors.title"
      :errors="errors.title"
    />
    <FormInput
      v-model="form.content"
      type="textarea"
      label="Content"
      placeholder="Write the content..."
      :error="!!errors.content"
      :errors="errors.content"
    />
    <div class="row q-col-gutter-lg q-mt-sm">
      <q-input
        class="col-12 col-md-6"
        v-model="form.date"
        mask="date"
        hint=""
        bottom-slots
        :error="!!errors.date"
        :error-message="errors.date?.length > 0 ? errors.date?.join(' ') : ''"
      >
        <template #append>
          <q-icon name="event" class="cursor-pointer">
            <q-popup-proxy
              cover
              transition-show="scale"
              transition-hide="scale"
            >
              <q-date
                v-model="form.date"
                :navigation-min-year-month="minDate"
                :navigation-max-year-month="maxDate"
                :options="dateOptions"
                minimal
                label="Date"
              />
            </q-popup-proxy>
          </q-icon>
        </template>
      </q-input>
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
        :error="!!errors.time"
        :errors="errors.time"
      />
    </div>
    <q-btn label="Submit" @click="addReport()" />
  </q-form>
  <span v-if="isPending">Adding report...</span>
  <span v-else-if="isError">An error occurred: {{ error.message }}</span>
  <span v-else-if="isSuccess">Report added!</span>
</template>

<script setup>
const $q = useQuasar();
const { today, tomorrow, oneMonthFromNow, minDate, maxDate } = useDate();

const { categories } = useCategory();
const availableTimeSlots = ref();

const errors = ref({});

const dateOptions = (dateValue) => {
  const date = new Date(dateValue);
  const day = date.getDay();

  return date > tomorrow && day !== 0 && day !== 6;
};

const form = reactive({
  category: null,
  title: null,
  content: null,
  date: null,
  time: null,
});

const {
  data: timeSlotsData,
  error: errorTimeSlots,
  isLoading: isLoadingTimeSlots,
  isError: isErrorTimeSlots,
} = useQuery({
  queryKey: ["time-slots"],
});

const {
  data: takenTimeSlotsData,
  error: errorTakenTimeSlots,
  isLoading: isLoadingTakenTimeSlots,
  isError: isErrorTakenTimeSlots,
  refetch: refetchTakenTimeSlots,
} = useQuery({
  queryKey: ["taken-time-slots", form],
});

const { isPending, isError, error, isSuccess, mutate } = useMutation({
  mutationFn: (form) => api.post("/reports", form),
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    $q.notify({
      message: "Report created successfully!",
      color: "positive",
    });
  },
});

function addReport() {
  mutate({
    category: form.category,
    title: form.title,
    content: form.content,
    date: form.date,
    time: form.time,
  });
}

watch(
  () => form.date,
  async () => {
    await refetchTakenTimeSlots();
    form.time = null;

    availableTimeSlots.value = timeSlotsData.value.map((slot) => ({
      label: slot,
      disable: takenTimeSlotsData.value?.includes(slot),
    }));
  }
);
</script>
