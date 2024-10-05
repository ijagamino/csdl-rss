<template>
  <div class="q-pa-md" style="max-width: 350px">
    <q-list bordered padding>
      <q-item-label header>Quick Access</q-item-label>

      <SidebarItem
        :href="route('dashboard.index')"
        label="Dashboard"
        icon="dashboard"
      />
      <SidebarItem
        :href="route('schedules.index')"
        label="Schedules"
        icon="schedule"
      />
      <SidebarItem
        :href="route('archives.index')"
        label="Archives"
        icon="archive"
      />

      <q-separator spaced />

      <q-item-label header>Miscellaneous</q-item-label>

      <SidebarItem :href="route('settings')" label="Settings" icon="settings" />
      <SidebarItem :href="route('about')" label="About" icon="priority_high" />
      <SidebarItem :href="route('help')" label="Help" icon="question_mark" />
      <SidebarItem
        :href="route('contacts.create')"
        label="Contact Us"
        icon="dashboard"
      />

      <q-separator spaced />

      <q-item clickable v-ripple>
        <q-item-section>
          <Button class="w-full uppercase" @click="logout()" label="Log Out" />
        </q-item-section>
      </q-item>
    </q-list>
  </div>
</template>
