<template>
  <q-layout view="hHh lpR fFf">
    <q-header bordered class="bg-primary text-white" height-hint="98">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg" />
          </q-avatar>
          RSS
        </q-toolbar-title>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" side="left" overlay bordered>
      <Sidebar />
    </q-drawer>

    <q-page-container>
      <q-page class="relative q-pa-lg">
        <router-view />
        <ReportCreateButton v-if="$page.url !== '/reports/create'" />
      </q-page>
    </q-page-container>

    <q-footer bordered class="lt-md bg-dark">
      <q-btn-group push square spread>
        <Button
          @click="$inertia.get(route('dashboard.index'))"
          icon="dashboard"
          size="xl"
          push
        />
        <Button
          @click="$inertia.get(route('schedules.index'))"
          icon="schedule"
          size="xl"
          push
        />
        <Button
          @click="$inertia.get(route('archives.index'))"
          icon="archive"
          size="xl"
          push
        />
      </q-btn-group>
    </q-footer>
  </q-layout>
</template>

<script setup>
import { ref } from "vue";

const leftDrawerOpen = ref(false);

const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};
</script>
