<script lang="ts" setup>
import DataTable from "@/components/DataTable.vue";
import { Role, UserWithRoles } from "@/types";
import { DataTableColumns, NButton, NTag } from "naive-ui";
import { h, ref } from "vue";
import Dialog from "../Dialog.vue";
import UserEditForm from "./UserEditForm.vue";

const props = defineProps<{
    users: UserWithRoles[];
    roles: Role[];
}>();

const showModal = ref(false);
const filteredUsers = ref<UserWithRoles[]>(props.users);

const editingUser = ref<UserWithRoles>(props.users[0]);

const editUser = (user: UserWithRoles) => {
    editingUser.value = user;
    showModal.value = true;
};

const columns: DataTableColumns<UserWithRoles> = [
    {
        title: "Nimi",
        key: "name",
        minWidth: 120,
    },
    {
        title: "Sähköposti",
        key: "email",
        minWidth: 120,
    },
    {
        title: "Roolit",
        minWidth: 120,
        key: "roles",
        render: (row) => {
            if (row.roles) {
                const tags = row.roles.map((tagKey) => {
                    return h(
                        NTag,
                        {
                            style: {
                                marginRight: "6px",
                                marginTop: "6px",
                            },
                            type: "info",
                            bordered: false,
                        },
                        {
                            default: () => tagKey.name,
                        }
                    );
                });
                return tags;
            }
        },
    },
    {
        title: "",
        key: "actions",
        render(row) {
            return h(
                NButton,
                {
                    strong: true,
                    tertiary: true,
                    size: "small",
                    disabled: row.roles.some(
                        (role) => role.name === "super-admin"
                    ),
                    onClick: () => {
                        editUser(row);
                    },
                },
                { default: () => "Muokkaa" }
            );
        },
    },
];
</script>
<template>
    <DataTable
        :columns="columns"
        :data="filteredUsers"
        :row-key="(row) => row.id"
        search
    />
    <Dialog v-model="showModal" title="Muokkaa käyttäjää">
        <user-edit-form :user="editingUser" :roles="roles" />
    </Dialog>
</template>
<style scoped>
.user-card {
    min-width: 600px;
    max-width: 800px;
}
</style>
