<template>
  <q-layout view="hHh Lpr fFf">
    <q-header bordered elevated>
      <q-toolbar>
        <q-btn
          v-if="authStore.user"
          @click="toggleLeftDrawer"
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
        />

        <q-toolbar-title>
          <VButton flat rounded="false" color="white" size="xl">
            <q-avatar>
              <img src="https://placehold.co/40" />
            </q-avatar>
            <span class="q-ml-sm"> RSS </span>
          </VButton>
        </q-toolbar-title>

        <q-btn
          v-if="!authStore.user"
          to="/login"
          color="accent"
          label="Login"
        />

        <q-btn v-else label="Log Out" @click="authStore.logout()" />
      </q-toolbar>
    </q-header>

    <q-drawer
      v-if="authStore.user"
      v-model="leftDrawerOpen"
      bordered
      show-if-above
      @click="!leftDrawerOpen"
    >
      <q-scroll-area class="fit">
        <q-list padding>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-avatar icon="person" color="primary" text-color="white" />
            </q-item-section>
            <q-item-section>
              <q-item-label>{{ fullName }}</q-item-label>
              <q-item-label caption>{{ authStore.user.email }}</q-item-label>
            </q-item-section>
          </q-item>
          <q-item-label header>Quick Access</q-item-label>

          <SidebarItem
            :to="{ name: 'reports.index' }"
            label="Reports"
            icon="description"
          />
          <SidebarItem
            :to="{ name: 'schedules.index' }"
            label="Schedules"
            icon="schedule"
          />
          <SidebarItem
            :to="{ name: 'archives.index' }"
            label="Archives"
            icon="archive"
          />

          <q-separator spaced />

          <q-item-label header>Miscellaneous</q-item-label>

          <SidebarItem
            :to="{ name: 'settings' }"
            label="Settings"
            icon="settings"
          />
          <SidebarItem
            :to="{ name: 'about' }"
            label="About"
            icon="priority_high"
          />
          <SidebarItem
            :to="{ name: 'help' }"
            label="Help"
            icon="question_mark"
          />
          <SidebarItem
            :to="{ name: 'contact-us' }"
            label="Contact Us"
            icon="dashboard"
          />

          <q-separator spaced />

          <q-item clickable v-ripple>
            <q-item-section>
              <q-btn
                color="primary"
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
      <q-page class="relative q-pa-xl">
        <router-view />

        <q-page-sticky position="bottom-right" :offset="[18, 18]">
          <q-btn
            v-if="authStore.user"
            :to="{ name: 'reports.create' }"
            round
            color="primary"
            icon="add"
            size="xl"
          />
        </q-page-sticky>
      </q-page>
    </q-page-container>

    <q-footer bordered class="lt-md bg-dark">
      <q-btn-group push square spread>
        <VButton
          :to="{ name: 'reports.index' }"
          icon="dashboard"
          size="xl"
          push
        />
        <VButton
          :to="{ name: 'schedules.index' }"
          icon="schedule"
          size="xl"
          push
        />
        <VButton
          :to="{ name: 'archives.index' }"
          icon="archive"
          size="xl"
          push
        />
      </q-btn-group>
    </q-footer>
  </q-layout>
</template>

<script setup>
defineOptions({
  name: "MainLayout",
});
const leftDrawerOpen = ref(false);

const authStore = useAuthStore();

const fullName = computed(() => {
  return `${authStore.user.first_name} ${authStore.user.last_name}`;
});

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
