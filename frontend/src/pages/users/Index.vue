<template>
  <PageHeader>Users</PageHeader>

  <div v-if="isLoadingUsers">Loading...</div>

  <div v-else-if="isErrorUsers">
    {{ usersError }}
  </div>

  <div v-else>
    <q-table
      title="List of users"
      :rows="users"
      :columns="columns"
      :filter="filter"
      row-key="id"
    >
      <template v-slot:top-right>
        <q-input dense debounce="300" v-model="filter" placeholder="Search">
          <template v-slot:append>
            <q-icon name="search" />
          </template>
        </q-input>
      </template>
      <template #body="props">
        <q-tr :props @click="openEditDialog(props.row)">
          <q-td key="id" :props>
            {{ props.row.id }}
          </q-td>
          <q-td key="username" :props>
            {{ props.row.username }}
          </q-td>
          <q-td key="email" :props>
            {{ props.row.email }}
          </q-td>
          <q-td key="first_name" :props>
            {{ props.row.first_name }}
          </q-td>
          <q-td key="last_name" :props>
            {{ props.row.last_name }}
          </q-td>
          <q-td key="roles" :props>
            <span v-for="(role, index) in props.row.roles" :key="role">
              {{ role
              }}<span v-if="index < props.row.roles.length - 1">, </span>
            </span>
          </q-td>
        </q-tr>
      </template>
    </q-table>
    <q-dialog v-model="showEditDialog">
      <q-card>
        <q-card-section>
          <div class="text-h6">
            Editing roles for {{ selectedUserFullName }}
          </div>
        </q-card-section>

        <q-card-section>
          <q-option-group
            v-model="selectedRoles"
            type="checkbox"
            :options="rolesOptions"
            color="accent"
          />
        </q-card-section>
        <q-card-actions align="right">
          <VButton label="Cancel" color="negative" v-close-popup />
          <VButton
            label="Update"
            color="positive"
            v-close-popup
            @click="updateUserRoles()"
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script setup>
const $q = useQuasar();
const queryClient = useQueryClient();

const showEditDialog = ref(false);
const selectedRoles = ref([]);
const selectedUser = ref();
const filter = ref("");

const users = computed(() => {
  return usersData.value.map((user) => ({
    ...user,
    roles: user.roles.map((role) => role.name),
  }));
});

const columns = [
  { name: "id", label: "ID", field: "id" },
  { name: "username", label: "Username", field: "username" },
  { name: "email", label: "Email", field: "email" },
  { name: "first_name", label: "First Name", field: "first_name" },
  { name: "last_name", label: "Last Name", field: "last_name" },
  { name: "roles", label: "Roles", field: "roles", sortable: true },
];

const {
  data: usersData,
  error: usersError,
  isError: isErrorUsers,
  isLoading: isLoadingUsers,
  isSuccess: isSuccessUsers,
} = useQuery({
  queryKey: ["users"],
});

const options = [
  { label: "Admin", value: "admin" },
  { label: "User", value: "user" },
];

const { data: rolesData, isSuccess: isSuccessRoles } = useQuery({
  queryKey: ["roles"],
});

watch(
  () => isSuccessUsers.value,
  () => {
    users.value = usersData.value.map((user) => ({
      ...user,
      roles: user.roles.map((role) => role.name),
    }));
  }
);

const openEditDialog = (user) => {
  console.log(user);
  selectedUser.value = user;
  selectedRoles.value = [...user.roles]; // Clone the user's roles
  showEditDialog.value = true;
};

const roles = ref([]);

// const rolesOptions = ref([]);
const rolesOptions = computed(() => {
  return rolesData.value.map((role) => ({
    label: role,
    value: role,
  }));
});

const {
  isPending: isPendingUpdate,
  isError: isErrorUpdate,
  error: errorUpdate,
  isSuccess: isSuccessUpdate,
  mutate: mutateUpdate,
} = useMutation({
  mutationFn: async () => {
    await api.patch(`users/${selectedUser.value.id}`, {
      roles: selectedRoles.value,
    });
  },
  onError: (err) => {
    errors.value = err.response.data.errors;
  },
  onSuccess: () => {
    queryClient.invalidateQueries({ queryKey: ["users"] });

    $q.notify({
      message: "Request successful!",
      color: "positive",
    });
  },
});

function updateUserRoles() {
  mutateUpdate();
}

const selectedUserFullName = computed(() => {
  return `${selectedUser.value.first_name} ${selectedUser.value.last_name}`;
});
</script>
