<template>
  <PageHeader> Reporting </PageHeader>
  <div class="row justify-center">
    <div class="col-12 col-lg-6">
      <q-card>
        <q-card-section>
          <q-form class="">
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
            <div class="row q-col-gutter-lg q-mb-lg">
              <FormInput
                class="col-12 col-md-6"
                v-model="form.date"
                mask="date"
                bottom-slots
                hint="YYYY/MM/DD"
                :error="!!errors.date"
                :error-message="
                  errors.date?.length > 0 ? errors.date?.join(' ') : ''
                "
              >
                <template #append>
                  <VIcon name="event" class="cursor-pointer">
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
                        color="accent"
                      />
                    </q-popup-proxy>
                  </VIcon>
                </template>
              </FormInput>
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
            <VButton label="Submit" @click="add()" />
          </q-form>
        </q-card-section>
      </q-card>
      <span v-if="isPendingAdd">Adding report...</span>
      <span v-else-if="isErrorAdd">An error occurred: {{ error.message }}</span>
      <span v-else-if="isSuccessAdd">Report added!</span>
    </div>
  </div>
</template>

<script setup>
const $q = useQuasar();
const { today, tomorrow, oneMonthFromNow, minDate, maxDate } = useDate();
const { categories } = useCategory();

const errors = ref({});

const form = reactive({
  date: null,
  time: null,
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
  isPendingAdd,
  isErrorAdd,
  isSuccessAdd,
  errorAdd,
  add,
} = useDatePicker("reports", form);
</script>
