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

<<<<<<< HEAD
        <q-toolbar-title>
          <q-item to="/">
            <q-item-section avatar>
              <q-img src="https://placehold.co/40" style="border-radius: 50%"/>
            </q-item-section>
            <q-item-section>
              <span class="text-accent"> RSS </span>
            </q-item-section>
          </q-item>
=======
        <q-toolbar-title class="mobile-hide">
          <VButton to="/" flat :rounded="false">
            <q-avatar>
              <img src="https://placehold.co/40" />
            </q-avatar>
            <span class="q-ml-sm"> RSS </span>
          </VButton>
>>>>>>> a51fc3c (fix: remove register, admin cannot disable own role, add role-based viewing on report page)
        </q-toolbar-title>

        <q-space />

        <VButton
          v-if="!authStore.user"
          :to="{ name: 'login' }"
          label="Log In"
        />
        <!-- <VButton -->
        <!--   v-if="!authStore.user" -->
        <!--   :to="{ name: 'register' }" -->
        <!--   label="Register" -->
        <!-- /> -->

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

          <div v-if="authStore.can.editUsers">
            <q-item-label header>Management</q-item-label>

            <q-item
              :to="{ name: 'users.index' }"
              v-ripple
              clickable
              active-class="bg-accent text-primary"
            >
              <q-item-section avatar>
                <q-avatar
                  icon="manage_accounts"
                  color="accent"
                  text-color="primary"
                />
              </q-item-section>
              <q-item-section>
                <q-item-label lines="1"> Users </q-item-label>
                <q-item-label lines="1" caption>
                  Manage user roles and permissions
                </q-item-label>
              </q-item-section>
            </q-item>
          </div>

          <div
            v-if="
              authStore.can.viewAllReports ||
              authStore.can.viewOwnReports ||
              authStore.can.viewAllAppointments ||
              authStore.can.viewOwnAppointments ||
              authStore.can.viewAllArchives ||
              authStore.can.viewOwnArchives
            "
          >
            <q-item-label header>Quick Access</q-item-label>

            <DrawerListItems :listItems="filteredQuickAccessItems" />

            <q-separator spaced />
          </div>

          <q-item-label header>Miscellaneous</q-item-label>

          <DrawerListItems :listItems="filteredMiscellaneousItems" />

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

    <q-footer v-if="authStore.user" bordered class="lt-md bg-dark">
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
  {
    name: "reports.index",
    label: "Reports",
    icon: "description",
    show: ["viewOwnReports", "viewAllReports"],
  },
  {
    name: "schedules.index",
    label: "Schedules",
    icon: "schedule",
    show: ["viewOwnAppointments", "viewAllAppointments"],
  },
  {
    name: "archives.index",
    label: "Archives",
    icon: "archive",
    show: ["viewOwnArchives", "viewAllArchives"],
  },
];

const miscellaneousItems = [
  { name: "about", label: "About", icon: "priority_high" },
  { name: "help", label: "Help", icon: "question_mark" },
  {
    name: "feedbacks.create",
    label: "Contact Us",
    icon: "chat",
    show: "createFeedbacks",
  },
  {
    name: "feedbacks.index",
    label: "Feedbacks",
    icon: "feedback",
    show: "viewAllFeedbacks",
  },
];

const filterListItems = (list) => {
  return list.filter((item) => {
    if (typeof item.show === "string") {
      return authStore.can[item.show];
    }

    if (Array.isArray(item.show)) {
      return item.show.some((permission) => authStore.can[permission]);
    }
    return true;
  });
};

const filteredQuickAccessItems = computed(() =>
  filterListItems(quickAccessItems)
);
const filteredMiscellaneousItems = computed(() =>
  filterListItems(miscellaneousItems)
);

const routeTabs = [
  { name: "reports.index", icon: "description" },
  { name: "schedules.index", icon: "schedule" },
  { name: "archives.index", icon: "archive" },
];
</script>
