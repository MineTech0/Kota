<script lang="ts" setup>
import Message from "@/components/Message.vue";
import useRedirect from "@/composables/useRedirect";
import useService from "@/composables/useService";
import UserService from "@/services/UserService";
import { Role, UserWithRoles } from "@/types";
import { NFormItemGi, NGrid, NInput, NSelect, NSpace } from "naive-ui";
import { computed, ref } from "vue";

const props = defineProps<{
    user: UserWithRoles;
    roles: Role[];
}>();

const userRoles = ref(props.user.roles.map((role) => role.id));

const { fetch, messages, loading } = useService();

const { redirect } = useRedirect();

/**
 * Maps the roles to a format that the select component can use
 */
const roles = computed(() => {
    return props.roles.map((role) => {
        if (role.name === "super-admin")
            return {
                label: role.name,
                value: role.id,
                disabled: true,
            };
        return {
            label: role.name,
            value: role.id,
        };
    });
});

/**
 * Saves the user roles
 */
const onSave = () => {
    fetch(UserService.updateUserRoles(props.user.id, userRoles.value)).then(
        () => {
            redirect("/users");
        }
    );
};

/**
 * Deletes the user
 */
const onDelete = () => {
    if(!confirm("Haluatko varmasti poistaa käyttäjän?")) return;
    fetch(UserService.deleteUser(props.user.id)).then(() => {
        redirect("/users");
    });
};
</script>
<template>
    <n-grid :span="24" :x-gap="6">
        <n-form-item-gi span="24" label="Nimi" path="name">
            <n-input v-model:value="user.name"  disabled />
        </n-form-item-gi>
        <n-form-item-gi span="24" label="Sähköposti" path="name">
            <n-input v-model:value="user.email"  disabled />
        </n-form-item-gi>

        <n-form-item-gi span="24" label="Roolit" path="roles">
            <n-select
                placeholder="Valitse rooleja"
                v-model:value="userRoles"
                multiple
                :options="roles"
            />
        </n-form-item-gi>
        <n-form-item-gi span="24">
            <n-space>
                <n-button :loading="loading" type="primary" @click="onSave"
                    >Tallenna</n-button
                >
                <n-button :loading="loading" type="error" @click="onDelete"
                    >Poista käyttäjä</n-button
                >
            </n-space>
        </n-form-item-gi>
    </n-grid>
    <Message :messages="messages" />
</template>
