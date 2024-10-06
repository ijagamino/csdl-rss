<template>
  <q-layout view="hHh lpR fFf">
    <q-header bordered elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          v-if="authStore.user"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          <q-avatar>
            <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg" />
          </q-avatar>
          RSS
        </q-toolbar-title>

        <q-btn
          to="/login"
          color="accent"
          label="Login"
          v-if="!authStore.user"
        />

        <q-btn v-else label="Log Out" @click="authStore.logout()" />
      </q-toolbar>
    </q-header>

    <q-drawer
      v-if="authStore.user"
      v-model="leftDrawerOpen"
      show-if-above
      bordered
    >
      <div class="q-pa-md" style="max-width: 350px">
        <q-list bordered padding>
          <q-item-label header>Quick Access</q-item-label>

          <SidebarItem to="reports" label="Reports" icon="description" />
          <SidebarItem to="schedules" label="Schedules" icon="schedule" />
          <SidebarItem to="archives" label="Archives" icon="archive" />

          <q-separator spaced />

          <q-item-label header>Miscellaneous</q-item-label>

          <SidebarItem to="settings" label="Settings" icon="settings" />
          <SidebarItem to="about" label="About" icon="priority_high" />
          <SidebarItem to="help" label="Help" icon="question_mark" />
          <SidebarItem to="contact-us" label="Contact Us" icon="dashboard" />

          <q-separator spaced />

          <q-item clickable v-ripple>
            <q-item-section>
              <VButton
                class="w-full uppercase"
                @click="authStore.logout()"
                label="Log Out"
              />
            </q-item-section>
          </q-item>
        </q-list>
      </div>
    </q-drawer>

    <q-page-container>
      <q-page class="relative q-pa-lg">
        <router-view />
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
defineOptions({
  name: "MainLayout",
});

const authStore = useAuthStore();

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
