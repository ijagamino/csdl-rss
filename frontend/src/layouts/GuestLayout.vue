<template>
  <q-layout view="hHh lpR fFf">
    <q-header bordered class="bg-primary text-white" height-hint="98">
      <q-toolbar>
        <q-toolbar-title>
          <q-avatar>
            <img src="https://placehold.co/40" />
          </q-avatar>
          RSS
        </q-toolbar-title>
        <VButton to="/login" color="accent" label="Login" />
      </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page class="q-pa-lg">
        <router-view />
      </q-page>
    </q-page-container>
  </q-layout>
</template>
