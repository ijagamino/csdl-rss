<template>
  <PageHeader> Contact Us </PageHeader>
  <q-card>
    <q-card-section>
      <q-form>
        <FormInput
          v-model="form.name"
          label="Name"
          type="email"
          :error="!!errors.name"
          :errors="errors.name"
        />
        <FormInput
          v-model="form.content"
          type="textarea"
          label="Message"
          :error="!!errors.content"
          :errors="errors.content"
        />
      </q-form>
      <VButton @click="addFeedback()" label="send" />
    </q-card-section>
  </q-card>

  <p class="pt-4">
    or alternatively, call us at:
    <span>09xx-xxx-xxxx</span>
  </p>
</template>

<script setup>
import { useQuasar } from "quasar";

const $q = useQuasar();

const errors = ref({});

const form = reactive({
  name: null,
  content: null,
});

const { isPending, isError, error, isSuccess, mutate } = useMutation({
  mutationFn: (form) => api.post("/reports", form),
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    $q.notify({
      message: "Feedback sent!",
      color: "positive",
    });
  },
});

function addReport() {
  mutate({
    category: form.category,
    title: form.title,
    content: form.content,
    date: form.date,
    time: form.time,
  });
}
</script>
