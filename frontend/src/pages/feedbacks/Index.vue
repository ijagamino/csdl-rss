<template>
  <PageHeader>Feedbacks</PageHeader>
  <header>
    <h2 class="uppercase text-2xl font-semibold">See what others have said</h2>
  </header>
  <section>
    <div class="row q-col-gutter-lg">
      <div
        class="col-12 col-md-6"
        v-for="feedback in feedbacksData"
        :key="feedback.id"
      >
        <q-card>
          <q-card-section>
            <div class="text-h6">
              {{ feedback.name ? feedback.name : "Anonymous" }}
            </div>
            <div>{{ feedback.content }}</div>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </section>
</template>

<script setup>
const form = reactive({
  name: null,
  content: null,
});

const errors = ref({});

const { data: feedbacksData } = useQuery({
  queryKey: ["feedbacks"],
});

const { mutate } = useMutation({
  mutationFn: async () => {
    await api.post("/feedbacks", form);
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ["feedbacks"] });
    $q.notify({
      message: "Feedback sent!",
      color: "positive",
    });
  },
});

const submit = () => {
  mutate();
};
</script>
