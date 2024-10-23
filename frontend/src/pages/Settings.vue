<template>
  <PageHeader> Settings </PageHeader>
  <q-list bordered class="rounded-borders">
    <q-expansion-item
      expand-separator
      icon="mail"
      label="Security and Privacy"
      default-opened
    >
      <q-item clickable v-ripple>Data Privacy</q-item>
      <q-item clickable v-ripple> Two-Factor Authentication </q-item>
      <q-item clickable v-ripple>Activity Log</q-item>
    </q-expansion-item>
    <q-expansion-item
      expand-separator
      icon="notifications"
      label="Notifications"
      default-opened
    >
      <q-item clickable v-ripple> Push Notifications </q-item>
      <q-item clickable v-ripple>Email Notifications</q-item>
      <q-item clickable v-ripple>In-app Notifications</q-item>
    </q-expansion-item>
    <q-expansion-item
      expand-separator
      icon="storage"
      label="Performance and Storage"
      default-opened
    >
      <q-item clickable v-ripple>Data Sync Frequency</q-item>
      <q-item clickable v-ripple>App Performance Optimization</q-item>
      <q-item clickable v-ripple>Data Management</q-item>
      <q-item clickable v-ripple>Data Cleanup</q-item>
    </q-expansion-item>
  </q-list>
</template>
