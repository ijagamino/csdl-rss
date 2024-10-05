<template>
  <div class="col-lg-6 col-xl-4 items-center">
    <q-card flat bordered class="text-white">
      <q-card-section horizontal>
        <q-card-section class="col q-pt-xs">
          <div class="text-overline">{{ report.category }}</div>
          <div class="text-h5 q-mt-sm q-mb-xs">{{ report.title }}</div>
          <div class="text-caption text-grey">{{ report.content }}</div>
        </q-card-section>

        <q-card-section class="col-4 flex flex-center">
          <Icon
            name="check_circle"
            size="xl"
            v-if="report.status === 'approved'"
          />
          <Icon name="pending" size="xl" v-if="report.status === 'pending'" />
        </q-card-section>
      </q-card-section>

      <q-separator />

      <q-card-actions align="between">
        <div>
          <Button flat color="white" round icon="event" />
          <Button flat color="white" :label="schedule" />
        </div>
        <Link :href="route('reports.show', report)" v-if="!appointment">
          <Button label="Details" />
        </Link>
      </q-card-actions>
    </q-card>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import Icon from "@/components/Icon.vue";
import Button from "@/components/Button.vue";

const props = defineProps({
  report: Object,
  appointment: Object,
  startTime: Object,
  endTime: Object,
});

const schedule = computed(() => {
  if (props.appointment) {
    return `${props.appointment.start_time} - ${props.appointment.end_time}`;
  }
  return `${props.report.appointment.start_time} - ${props.report.appointment.end_time}`;
});
</script>
