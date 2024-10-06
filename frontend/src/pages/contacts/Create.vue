<template>
  <PageHeader> Contact Us </PageHeader>
  <Card class="flex gap-2">
    <template #content>
      <form class="flex flex-col gap-4">
        <FormInputText
          id="name"
          label="Name"
          type="email"
          v-model="form.name"
          :error="form.name"
        />
        <FormTextarea
          id="content"
          label="Message"
          v-model="form.content"
          :error="form.content"
        />
        <!-- </FormPanel> -->
      </form>
    </template>
    <template #footer>
      <Button class="w-full" @click="submit()">Send</Button>
    </template>
  </Card>

  <p class="pt-4">
    or alternatively, call us at:
    <span class="block text-3xl font-semibold text-blue-800"
      >09xx-xxx-xxxx</span
    >
  </p>
</template>

<script setup>
const submit = () => {
  form.post("/contact");
};
</script>
