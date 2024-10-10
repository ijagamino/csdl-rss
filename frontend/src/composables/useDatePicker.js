export function useDatePicker(form) {
  const { today, tomorrow, oneMonthFromNow, minDate, maxDate } = useDate();

  const availableTimeSlots = ref([]);
  const errors = ref({});

  const dateOptions = (dateValue) => {
    const date = new Date(dateValue);
    const day = date.getDay();

    return date > tomorrow && day !== 0 && day !== 6;
  };

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

  return {
    dateOptions,
    availableTimeSlots,
    isLoadingTimeSlots,
    isErrorTimeSlots,
    errorTimeSlots,
    isLoadingTakenTimeSlots,
    isErrorTakenTimeSlots,
    errorTakenTimeSlots,
  };
}
