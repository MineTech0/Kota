<script lang="ts" setup>
import DataTable from "@/components/DataTable.vue";
import InviteService from "@/services/InviteService";
import { Invite } from "@/types";
import { differenceInDays, formatDistance } from "date-fns";
import { fi } from "date-fns/locale";
import { DataTableColumns, NButton, useMessage } from "naive-ui";
import { h, ref } from "vue";

const props = defineProps<{
    invites: Invite[];
}>();

const message = useMessage();

const invitesList = ref<Invite[]>(props.invites);

const loadingIds = ref<number[]>([]);

const deleteInvite = (invite: Invite) => {
    if (!confirm("Haluatko varmasti poistaa kutsun?")) return;
    loadingIds.value.push(invite.id);
    InviteService.deleteInvite(invite.id)
        .then((res) => {
            message.success(res.message, { duration: 5000 });
            invitesList.value = invitesList.value.filter(
                (i) => i.id !== invite.id
            );
        })
        .catch((error) => {
            message.error(error.message);
        });
};

const resendInvite = (invite: Invite) => {
    loadingIds.value.push(invite.id);
    InviteService.resendInvite(invite)
        .then((res) => {
            message.success(res.message, { duration: 5000 });
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        })
        .catch((error) => {
            message.error(error.message);
        })
};


const columns: DataTableColumns<Invite> = [
    {
        title: "Sähköposti",
        key: "email",
        minWidth: 120,
    },
    {
        title: "Kutsuttu",
        key: "updated_at",
        minWidth: 120,
        render(row) {
            //days ago
            return formatDistance(new Date(row.updated_at), new Date(), {
                addSuffix: true,
                locale: fi,
            });
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
                    disabled:
                        differenceInDays(new Date(), new Date(row.created_at)) <
                        14,
                    onClick: () => {
                        resendInvite(row);
                    },
                },
                { default: () => "Lähetä uudestaan" }
            );
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
                    type: "error",
                    onClick: () => {
                        deleteInvite(row);
                    },
                },
                { default: () => "Poista" }
            );
        },
    },
];
</script>
<template>
    <DataTable
        :columns="columns"
        :data="invitesList"
        :row-key="(row) => row.id"
        search
    />
</template>
<style scoped></style>
