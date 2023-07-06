<script lang="ts" setup>
import { Role, UserWithRoles } from "@types";
import { DataTableColumns, NButton, NCard, NDataTable, NModal, NTag } from "naive-ui";
import { h, ref } from "vue";
import UserEditForm from "./UserEditForm.vue";

const props = defineProps<{
    users: UserWithRoles[];
    roles: Role[];
}>();

const showModal = ref(false);

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
                    disabled: row.roles.some((role) => role.name === "super-admin"),
                    onClick: () => {
                        editUser(row);
                    },
                },
                { default: () => "Muokkaa" }
            );
        },
    }
];
</script>
<template>
    <n-data-table
        class="table"
        :columns="columns"
        :data="props.users"
        :row-key="(row) => row.id"
        scroll-x="100%"
    />
    <n-modal v-model:show="showModal">
        <n-card
            style="width: 600px"
            title="Muokkaa käyttäjää"
            :bordered="false"
            size="huge"
            role="dialog"
            aria-modal="true"
        >
            <user-edit-form :user="editingUser" :roles="roles" />
        </n-card>
    </n-modal>
</template>
<style scoped>
@media (max-width: 600px) {
    .table {
        font-size: 12px;
        width: 100%;
        overflow-x: auto;
    }
}
</style>
