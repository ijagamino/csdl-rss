<template>
  <PageHeader> Contact Us </PageHeader>
  <div class="row justify-center">
    <div class="col-12 col-lg-6">
      <q-card>
        <q-card-section>
          <q-form>
            <FormInput
              v-model="form.name"
              label="Name"
              bottom-slots
              :error="!!errors.name"
              :errors="errors.name"
            />
            <FormInput
              v-model="form.content"
              label="Message"
              bottom-slots
              :error="!!errors.content"
              :errors="errors.content"
            />
          </q-form>
          <VButton class="w-full" label="Send" @click="submit()" />
        </q-card-section>
      </q-card>
    </div>
  </div>
</template>

<script setup>
const form = reactive({
  name: null,
  content: null,
});

const errors = ref({});

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
