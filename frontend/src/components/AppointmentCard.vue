<template>
  <div class="col-12 col-lg-6 col-xl-4 items-center">
    <q-card bordered>
      <q-card-section class="col text-uppercase text-center">
        <h4 class="text-h4 text-weight-bolder">
          {{ formatDate(appointment.date).dayOfWeek }}
        </h4>
        <h5 class="text-weight-bold">
          <span class="block">{{ formatDate(appointment.date).month }}</span>
          <span class="block text-weight-bolder">
            {{ formatDate(appointment.date).day }}
          </span>
          <span class="block">{{ formatDate(appointment.date).year }}</span>
        </h5>
        <h6>
          {{ schedule }}
        </h6>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
const props = defineProps({
  appointment: Object,
});

const { formatDate, formatTime } = useDate();

const schedule = computed(() => {
  return `${formatTime(props.appointment.start_time)} - ${formatTime(
    props.appointment.end_time
  )}`;
});
</script>
