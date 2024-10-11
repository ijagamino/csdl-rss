export function useDatePicker(url, form) {
  const $q = useQuasar();
  const queryClient = useQueryClient();
  const router = useRouter();

  const { tomorrow } = useDate();
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

  const { isPending, isError, error, isSuccess, mutate } = useMutation({
    mutationFn: (form) => api.post(url, form),
    onError: (err) => {
      errors.value = err.response.data.errors;
    },
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["reports"] });
      router.push({ name: "reports.index" });

      $q.notify({
        message: "Request successful!",
        color: "positive",
      });
    },
  });

  function add() {
    mutate({
      category: form.category,
      title: form.title,
      content: form.content,
      date: form.date,
      time: form.time,
      report_id: form.report_id,
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

  return {
    dateOptions,
    availableTimeSlots,
    isLoadingTimeSlots,
    isErrorTimeSlots,
    errorTimeSlots,
    isLoadingTakenTimeSlots,
    isErrorTakenTimeSlots,
    errorTakenTimeSlots,
    isPending,
    isError,
    isSuccess,
    error,
    add,
  };
}
