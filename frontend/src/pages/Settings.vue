<template>
    <PageHeader > Settings </PageHeader>
    <section class="divide-y-2 divide-black flex flex-col gap-2">
      <section class="uppercase flex gap-1 flex-col">
        <header class="">
          <h2 class="text-xl font-semibold">Security and Privacy</h2>
        </header>
        <NavLink class="font-semibold">Data Privacy</NavLink>
        <NavLink class="font-semibold">Two-Factor Authentication</NavLink>
        <NavLink class="font-semibold">Activity Log</NavLink>
      </section>
      <section class="flex uppercase flex-col gap-1 pt-2">
        <header class="">
          <h2 class="text-xl font-semibold">Notifications</h2>
        </header>
        <NavLink class="font-semibold">Push Notifications</NavLink>
        <NavLink class="font-semibold">Email Notifications</NavLink>
        <NavLink class="font-semibold">In-app Notifications</NavLink>
      </section>
      <section class="flex flex-col uppercase gap-1 pt-2">
        <header class="">
          <h2 class="text-xl font-semibold">Performance and Storage</h2>
        </header>
        <NavLink class="font-semibold">Data Sync Frequency</NavLink>
        <NavLink class="font-semibold">App Performance Optimization</NavLink>
        <NavLink class="font-semibold">Data Management</NavLink>
        <NavLink class="font-semibold">Data Cleanup</NavLink>
      </section>
    </section>
</template>

<script setup>
import { NavLink } from "@/Shared/components";
</script>
