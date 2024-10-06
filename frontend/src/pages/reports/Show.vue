<template>
  <!-- <template #header> Report #{{ report.id }} </template> -->
  <!-- <div class="mt-8 flex flex-wrap px-4 gap-8"> -->
  <!-- <ReportCard :report :startTime :endTime /> -->
  <div class="row">
    <ReportCard :report :appointment />
  </div>
  <!-- </div> -->
</template>

<script setup>
import ReportCard from "@/components/ReportCard.vue";

defineProps({
  report: Object,
  appointment: Object,
});
</script>
