<template>
  <PageHeader> Help </PageHeader>
  <header>
    <h2 class="uppercase text-2xl font-semibold">Browse these topics</h2>
  </header>

  <section class="border-black border-2 rounded-xl text-xl p-4">
    <q-list bordered class="rounded-borders">
      <q-expansion-item
        expand-separator
        icon="mail"
        label="Overview of the Reporting System"
        default-opened
      >
        <q-card>
          <q-card-section>{{ lorem }}</q-card-section>
        </q-card>
      </q-expansion-item>
      <q-expansion-item
        expand-separator
        icon="notifications"
        label="Getting Started with the Reporting System"
      >
        <q-card>
          <q-card-section>{{ lorem }}</q-card-section>
        </q-card>
      </q-expansion-item>
      <q-expansion-item
        expand-separator
        icon="storage"
        label="How to Submit a Report"
      >
        <q-card>
          <q-card-section>{{ lorem }}</q-card-section>
        </q-card>
      </q-expansion-item>
    </q-list>
  </section>
</template>

<script setup>
const lorem =
  "Lorem ipsum dolor sit amet consectetur adipisicing elit. Sequi aut voluptates minima cupiditate voluptate, tempora perferendis ut, pariatur quidem nesciunt velit alias minus, excepturi facere culpa maxime animi voluptatem temporibus. ";
</script>
