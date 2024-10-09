<template>
  <PageHeader> About </PageHeader>

  <section class="grid grid-cols-2 lg:flex gap-2">
    <div>
      <header class="uppercase">
        <h2 class="text-lg font-semibold">Details About the Team</h2>
      </header>
      <p>
        Lorem ipsum dolor sit, amet consectetur adipisicing elit. Illo rerum
        esse ad!
      </p>
    </div>
    <img
      class="rounded-xl border-2 border-black"
      src="https://placehold.co/400"
      alt=""
    />
  </section>

  <section class="mt-4">
    <header class="uppercase">
      <h2>Profiles</h2>
    </header>
    <div class="row">
      <q-item class="col-12 col-lg-6 col-xl-4" clickable v-ripple>
        <q-item-section side>
          <q-avatar size="128px">
            <img src="https://placehold.co/400" />
          </q-avatar>
        </q-item-section>
        <q-item-section>
          <q-item-label>John Doe</q-item-label>
          <q-item-label caption>Developer</q-item-label>
        </q-item-section>
      </q-item>
    </div>
  </section>
</template>

<script setup></script>
