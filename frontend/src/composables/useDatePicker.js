export function useDatePicker(url, form, urlId = null) {
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

  const {
    isPending: isPendingAdd,
    isError: isErrorAdd,
    error: errorAdd,
    isSuccess: isSuccessAdd,
    mutate: mutateAdd,
  } = useMutation({
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
    mutateAdd(form);
  }

  const {
    isPending: isPendingUpdate,
    isError: isErrorUpdate,
    error: errorUpdate,
    isSuccess: isSuccessUpdate,
    mutate: mutateUpdate,
  } = useMutation({
    mutationFn: (form) => api.patch(urlId, form),
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

  function update() {
    mutateUpdate(form);
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
    update,
  };
}
