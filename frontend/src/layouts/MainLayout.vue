<template>
  <q-layout view="hHh Lpr fFf">
    <q-header elevated>
      <q-toolbar :class="isDark ? 'bg-dark' : ''">
        <VButton
          v-if="authStore.user"
          @click="toggleLeftDrawer"
          :color="isDark ? 'primary' : 'accent'"
          flat
          round
          icon="menu"
          aria-label="Menu"
        />

        <q-toolbar-title class="gt-md">
          <VButton flat :rounded="false">
            <q-avatar>
              <img src="https://placehold.co/40" />
            </q-avatar>
            <span class="q-ml-sm"> RSS </span>
          </VButton>
        </q-toolbar-title>

        <q-space />

        <VButton v-if="!authStore.user" to="/login" label="Login" />

        <VButton v-else label="Log Out" @click="authStore.logout()" />
      </q-toolbar>
    </q-header>

    <q-drawer
      v-if="authStore.user"
      v-model="leftDrawerOpen"
      bordered
      elevated
      show-if-above
      @click="!leftDrawerOpen"
    >
      <q-scroll-area class="fit">
        <q-list padding>
          <q-item>
            <q-item-section avatar>
              <q-avatar icon="person" color="accent" text-color="white" />
            </q-item-section>
            <q-item-section>
              <q-item-label>{{ fullName }}</q-item-label>
              <q-item-label caption>{{ authStore.user.email }}</q-item-label>
            </q-item-section>
          </q-item>

          <q-separator spaced />

          <q-item-label header>Quick Access</q-item-label>

          <DrawerListItems :listItems="quickAccessItems" />

          <q-separator spaced />

          <q-item-label header>Miscellaneous</q-item-label>

          <DrawerListItems :listItems="miscellaneousItems" />

          <q-separator spaced />

          <q-toggle
            v-model="isDark"
            @click="darkMode.toggleDarkMode()"
            label="Dark Mode"
            color="accent"
          />

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
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <q-page class="q-pa-lg q-mb-xl">
        <router-view />
        <q-page-sticky position="bottom-right" :offset="[18, 18]">
          <VButton
            class="mobile-only"
            v-if="authStore.user && authStore.can.createReports"
            :to="{ name: 'reports.create' }"
            round
            icon="add"
            size="xl"
          />
        </q-page-sticky>
      </q-page>
    </q-page-container>

    <q-footer bordered class="lt-md bg-dark">
      <q-tabs
        active-color="primary"
        active-bg-color="accent"
        mobile-arrows
        align="justify"
      >
        <q-route-tab
          v-for="routeTab in routeTabs"
          :key="routeTab.name"
          :to="{ name: routeTab.name }"
          :icon="routeTab.icon"
        />
      </q-tabs>
    </q-footer>
  </q-layout>
</template>

<script setup>
const $q = useQuasar();
const authStore = useAuthStore();
const darkMode = useDarkMode();

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

const isDark = computed(() => {
  return darkMode.isDark.value;
});

const fullName = computed(() => {
  return `${authStore.user.first_name} ${authStore.user.last_name}`;
});

const quickAccessItems = [
  { name: "reports.index", label: "Reports", icon: "description" },
  { name: "schedules.index", label: "Schedules", icon: "schedule" },
  { name: "archives.index", label: "Archives", icon: "archive" },
];

const miscellaneousItems = [
  { name: "about", label: "About", icon: "priority_high" },
  { name: "help", label: "Help", icon: "question_mark" },
  { name: "contact-us", label: "Contact Us", icon: "feedback" },
];

const routeTabs = [
  { name: "reports.index", icon: "description" },
  { name: "schedules.index", icon: "schedule" },
  { name: "archives.index", icon: "archive" },
];
</script>
