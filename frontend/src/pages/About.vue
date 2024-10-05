<template>
  <Head title="About" />
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
        <h2 class="text-lg font-semibold">Profiles</h2>
      </header>
      <div class="pt-2 grid gap-4 grid-cols-2">
        <DeveloperFigure />
        <DeveloperFigure />
        <DeveloperFigure />
        <DeveloperFigure />
      </div>
    </section>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import {
  DeveloperFigure,
} from "@/Shared/components";
</script>
