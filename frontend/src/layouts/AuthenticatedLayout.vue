<template>
  <q-layout view="hHh lpR fFf">
    <q-header bordered class="bg-primary text-white" height-hint="98">
      <q-toolbar>
        <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://placehold.co/40" />
          </q-avatar>
          RSS
        </q-toolbar-title>

        <VButton
          to="/login"
          color="accent"
          label="Login"
          v-if="!authStore.user"
        />

        <q-btn label="Log Out" @click="authStore.logout()" v-else />
      </q-toolbar>

    </q-header>

    <q-drawer v-model="leftDrawerOpen" overlay bordered>
      <SidebarPanel />
    </q-drawer>

    <q-page-container>
      <q-page class="relative q-pa-lg">
        <router-view />
        <ReportCreateButton v-if="$page.url !== '/reports/create'" />
      </q-page>
    </q-page-container>
</q-layout>
</template>

<script setup>
import { ref } from "vue";

const leftDrawerOpen = ref(false);

const toggleLeftDrawer = () => {
  leftDrawerOpen.value = !leftDrawerOpen.value;
};
</script>
