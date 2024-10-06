<template>
  <PageHeader> Reporting </PageHeader>
  <q-form>
    <q-select
      placeholder="Choose a category"
      label="Choose a category"
      v-model="form.category"
      :error="form.errors.category"
      :options="categories"
    />
    <q-input
      label="Title"
      placeholder="Write the title..."
      v-model="form.title"
      :error="form.errors.title"
    />
    <q-input
      label="Content"
      name="content"
      placeholder="Write the content..."
      v-model="form.content"
      :error="form.errors.content"
    />

    <q-date
      minimal
      label="Date"
      v-model="form.date"
      :error="form.errors.date"
    />
    <q-select
      label="Time"
      placeholder="Choose a time"
      v-model="form.time"
      :options="availableSlots"
      optionLabel="label"
      optionValue="label"
      :error="form.errors.time"
      optionDisabled="disabled"
    />
    <Button label="Submit" @click="submit()" />
  </q-form>
</template>

<script setup>
import { useQuasar } from "quasar";

const $q = useQuasar();

const props = defineProps({
  timeSlots: Object,
  formattedSlots: Object,
  unavailableSlots: Object,
});

const date = computed(() => {
  const dt = new Date(form.date);
  const year = dt.getFullYear();
  const month = String(dt.getMonth() + 1).padStart(2, "0"); // Months are zero-indexed
  const day = String(dt.getDate()).padStart(2, "0");

  return `${year}-${month}-${day}`; // "2024-10-09"
});

const categories = ["Financial Assistance", "Complaints", "Others"];

const form = useForm({
  category: null,
  title: null,
  content: null,
  date: null,
  time: null,
});

const submit = () => {
  form.post(route("reports.store"), {
    onSuccess: () => {
      $q.notify({
        message: "Report created successfully!",
        color: "positive",
      });
    },
  });
};

const disabledSlots = computed(() => {
  if (!props.unavailableSlots[date.value]) {
    return;
  }
  const result = props.unavailableSlots[date.value].slots.map(
    (slot) => `${slot.startTime} - ${slot.endTime}`
  );

  return result;
});

const availableSlots = computed(() => {
  return props.timeSlots.map((slot) => ({
    label: `${slot.startTime} - ${slot.endTime}`,
    disable: disabledSlots.value?.includes(
      `${slot.startTime} - ${slot.endTime}`
    ),
  }));
});

const isTaken = (slot) => {
  const unavailableForDate = props.unavailableSlots.find(
    (entry) => entry.date === date.value
  );

  // If there are no unavailable slots for the selected date, return false
  if (!unavailableForDate) {
    return false;
  }

  // Check if the slot is in the unavailable slots for that date
  return unavailableForDate.slots.includes(slot);
};

watch(
  () => form.date,
  () => {
    form.time = null;
  }
);
</script>
